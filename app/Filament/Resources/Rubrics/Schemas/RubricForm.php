<?php

namespace App\Filament\Resources\Rubrics\Schemas;

use Filament\Schemas\Schema;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;

class RubricForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información de la rúbrica')->schema([
                    Select::make('type')
                        ->label('Tipo de rúbrica')
                        ->options([
                            'writing'  => 'Writing - Expresión escrita',
                            'reading'  => 'Reading - Comprensión lectora',
                            'speaking' => 'Speaking - Expresión oral',
                            'alp'      => 'ALP - Proyecto de unidad',
                            'final'    => 'Evaluación final de ciclo',
                        ])
                        ->unique(ignoreRecord: true)
                        ->required(),
                    TextInput::make('description')
                        ->label('Descripción')
                        ->placeholder('Descripción breve de la rúbrica'),
                ])
                    ->columnSpanFull(), //seccion de form mas grande

                Section::make('Criterios de evaluación')
                    ->description('Criterios calificados del 1 (Insuficiente) al 4 (Excelente)')
                    ->schema([
                        Repeater::make('criteria')
                            ->label('Criterios')
                            ->relationship()
                            ->addActionLabel('+ Agregar criterio')
                            ->orderColumn('order')
                            ->reorderable()
                            ->collapsible()
                            ->defaultItems(3)
                            ->columns(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Criterio')
                                    ->placeholder('Ej. Grammar & Syntax')
                                    ->required()
                                    ->columnSpan(1),
                                TextInput::make('description')
                                    ->label('Descripción')
                                    ->placeholder('Ej. Correct use of verb tenses')
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->columnSpanFull() //seccion de form mas grande
            ]);
    }
}
