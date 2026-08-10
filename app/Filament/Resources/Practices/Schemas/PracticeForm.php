<?php

namespace App\Filament\Resources\Practices\Schemas;

use Filament\Schemas\Schema;

use App\Models\Unit;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;

class PracticeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Enlace de práctica')->schema([
                        TextInput::make('title')
                            ->label('Nombre de la práctica')
                            ->placeholder('Ej. Vocabulario técnico — Unidad 1')
                            ->columnSpanFull()
                            ->required(),
                        Select::make('platform')
                            ->label('Plataforma')
                            ->options([
                                'quizizz' => 'Quizizz',
                                'kahoot'  => 'Kahoot',
                                'other'   => 'Otro',
                            ])
                            ->required(),
                        Select::make('unit_id')
                            ->label('Unidad')
                            ->options(
                                Unit::with('cycle')->get()
                                    ->mapWithKeys(fn($u) => [$u->id => "{$u->cycle->name} — {$u->name}"])
                            )
                            ->required(),
                        TextInput::make('url')
                            ->label('Enlace URL')
                            ->url()
                            ->placeholder('https://quizizz.com/...')
                            ->columnSpanFull()
                            ->required(),
                    ])
                    ->columns(2) //columnas en el formulario
                    ->columnSpanFull() //seccion de form mas grande
            ]);
    }
}
