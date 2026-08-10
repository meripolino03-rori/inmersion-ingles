<?php

namespace App\Filament\Resources\Cycles\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

class CycleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del ciclo')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre del ciclo')
                            ->placeholder('Ej. 2025-I')
                            ->required(),
                        TextInput::make('year')
                            ->label('Año')
                            ->numeric()
                            ->default(date('Y'))
                            ->required(),
                        Select::make('semester')
                            ->label('Semestre')
                            ->options(['I' => 'Semestre I', 'II' => 'Semestre II'])
                            ->required(),
                        Toggle::make('active')
                            ->label('Ciclo activo')
                            ->default(true),
                    ])
                    ->columns(2) //columnas en el formulario
                    ->columnSpanFull() //seccion de form mas grande
            ]);
    }
}
