<?php

namespace App\Filament\Resources\Units\Schemas;

use Filament\Schemas\Schema;

use App\Models\Cycle;

use Filament\Schemas\Components\Section;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class UnitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Información de la unidad')
                    ->schema([

                        Select::make('cycle_id')
                            ->label('Ciclo')
                            ->options(
                                Cycle::where('active', true)
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->required(),

                        Select::make('number')
                            ->label('Número de unidad')
                            ->options([
                                1 => 'Unidad 1',
                                2 => 'Unidad 2',
                                3 => 'Unidad 3',
                                4 => 'Unidad 4',
                            ])

                            ->unique(
                                table: 'units',
                                column: 'number',
                                ignoreRecord: true,

                                modifyRuleUsing: function ($rule, callable $get) {

                                    return $rule->where(
                                        'cycle_id',
                                        $get('cycle_id')
                                    );
                                }
                            )

                            ->validationMessages([
                                'unique' =>
                                'Ya existe esa unidad en el ciclo seleccionado.',
                            ])

                            ->required(),

                        TextInput::make('name')
                            ->label('Nombre')
                            ->placeholder('Ej. Unit 1 — Foundations')
                            ->columnSpanFull()
                            ->required(),

                    ])
                    ->columnSpanFull()
                    ->columns(2),

            ]);
    }
}
