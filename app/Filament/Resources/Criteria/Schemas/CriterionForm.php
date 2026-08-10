<?php

namespace App\Filament\Resources\Criteria\Schemas;

use Filament\Schemas\Schema;

use App\Models\Rubric;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class CriterionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del criterio')->schema([
                    Select::make('rubric_id')
                        ->label('Rúbrica')
                        ->options(
                            Rubric::all()->mapWithKeys(fn($r) => [
                                $r->id => match ($r->type) {
                                    'writing'  => 'Writing — Expresión escrita',
                                    'reading'  => 'Reading — Comprensión lectora',
                                    'speaking' => 'Speaking — Expresión oral',
                                    'alp'      => 'ALP — Proyecto de unidad',
                                    'final'    => 'Evaluación final de ciclo',
                                    default    => $r->type,
                                }
                            ])
                        )
                        ->searchable()
                        ->required(),
                    TextInput::make('order')
                        ->label('Puntaje')
                        ->numeric()
                        ->default(0)
                        ->required(),
                    TextInput::make('name')
                        ->label('Nombre del criterio')
                        ->placeholder('Ej. Grammar & Syntax')
                        ->columnSpanFull()
                        ->required(),
                    TextInput::make('description')
                        ->label('Descripción')
                        ->placeholder('Ej. Correct use of verb tenses and sentence structures')
                        ->columnSpanFull(),
                ])
                    ->columns(2) //columnas en el formulario
                    ->columnSpanFull() //seccion de form mas grande
            ]);
    }
}
