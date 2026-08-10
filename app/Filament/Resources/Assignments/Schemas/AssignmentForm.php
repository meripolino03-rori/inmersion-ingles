<?php

namespace App\Filament\Resources\Assignments\Schemas;

use Filament\Schemas\Schema;

use Filament\Schemas\Components\Section;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class AssignmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Información de la sección')
                    ->description('Asigna un docente a una sección dentro del ciclo académico activo.')
                    ->schema([

                        Select::make('teacher_id')
                            ->label('Docente')
                            ->relationship(
                                name: 'teacher',
                                titleAttribute: 'id',
                                modifyQueryUsing: fn($query) =>
                                $query->whereHas(
                                    'user',
                                    fn($q) => $q->role('teacher')
                                )
                            )
                            ->getOptionLabelFromRecordUsing(
                                fn($record) =>
                                $record->user->name .
                                    ' • ' .
                                    $record->school->name
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('cycle_id')
                            ->label('Ciclo académico')
                            ->relationship(
                                name: 'cycle',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn($query) =>
                                $query->where('active', true)
                            )
                            ->default(
                                fn() =>
                                \App\Models\Cycle::where('active', true)
                                    ->first()?->id
                            )
                            ->disabled()
                            ->dehydrated()
                            ->required(),

                        TextInput::make('section')
                            ->label('Sección')
                            ->placeholder('Ej. A')
                            ->maxLength(10)
                            ->required(),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),

            ]);
    }
}
