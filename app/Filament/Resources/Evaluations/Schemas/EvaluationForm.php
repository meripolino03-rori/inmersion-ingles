<?php

namespace App\Filament\Resources\Evaluations\Schemas;

use Filament\Schemas\Schema;

use App\Models\Rubric;
use App\Models\Unit;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Utilities\Get; // ← v5

class EvaluationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos de la evaluación')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('type')
                            ->label('Tipo')
                            ->options([
                                'practice' => 'Práctica (Writing / Reading / Speaking)',
                                'alp'      => 'ALP — Proyecto de unidad',
                                'final'    => 'Evaluación final',
                            ])
                            ->live()
                            ->required(),
                        Select::make('rubric_id')
                            ->label('Rúbrica')
                            ->options(fn(Get $get) => match ($get('type')) {
                                'practice' => Rubric::whereIn('type', ['writing', 'reading', 'speaking'])
                                    ->pluck('type', 'id')
                                    ->map(fn($t) => ucfirst($t)),
                                'alp'   => Rubric::where('type', 'alp')->pluck('type', 'id'),
                                'final' => Rubric::where('type', 'final')->pluck('type', 'id'),
                                default => Rubric::pluck('type', 'id'),
                            })
                            ->required(),
                        Select::make('unit_id')
                            ->label('Unidad')
                            ->options(
                                Unit::with('cycle')->get()
                                    ->mapWithKeys(fn($u) => [$u->id => "{$u->cycle->name} — {$u->name}"])
                            )
                            ->hidden(fn(Get $get) => $get('type') === 'final')
                            ->required(fn(Get $get) => $get('type') !== 'final'),
                        DatePicker::make('date')
                            ->label('Fecha')
                            ->default(now())
                            ->required(),

                        TextInput::make('weight') //pesos
                            ->label('Peso de la nota')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(10)
                            ->default(1)
                            ->suffix('pts')
                            ->helperText('Ej: 1 = normal, 2 = doble peso en la nota final')
                            ->required(),

                    ])->columnSpanFull() //seccion de form mas grande
            ]);
    }
}
