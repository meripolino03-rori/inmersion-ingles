<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Schemas\Schema;

use App\Models\User;
use App\Models\Cycle;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos del estudiante')->schema([
                    Select::make('user_id')
                        ->label('Usuario')
                        ->options(
                            User::whereDoesntHave(
                                'roles',
                                fn($q) =>
                                $q->whereIn('name', ['admin', 'teacher'])
                            )->pluck('name', 'id')
                        )
                        ->searchable()
                        ->required(),
                    Select::make('cycle_id')
                        ->label('Ciclo')
                        ->options(Cycle::where('active', true)->pluck('name', 'id'))
                        ->required(),
                    TextInput::make('code')
                        ->label('Código de Matrícula')
                        ->placeholder('Ej. 2022110266')
                        ->unique(ignoreRecord: true)
                        ->columnSpanFull()
                        ->required(),
                    Select::make('school_id')
                        ->label('Escuela')
                        ->relationship('school', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                ])
                    ->columns(2) //columnas en el formulario
                    ->columnSpanFull() //seccion de form mas grande
            ]);
    }
}
