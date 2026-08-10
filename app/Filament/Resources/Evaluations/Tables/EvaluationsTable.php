<?php

namespace App\Filament\Resources\Evaluations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;

class EvaluationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Título')->searchable(),
                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'practice' => 'warning',
                        'alp'      => 'success',
                        'final'    => 'danger',
                        default    => 'gray',
                    })
                    ->formatStateUsing(fn($state) => match ($state) {
                        'practice' => 'Práctica',
                        'alp'      => 'ALP',
                        'final'    => 'Final',
                        default    => $state,
                    }),
                TextColumn::make('rubric.type')->label('Rúbrica')->badge()->color('info'),
                TextColumn::make('unit.name')->label('Unidad')->default('— Final —'),
                TextColumn::make('date')->label('Fecha')->date('d/m/Y')->sortable(),
                TextColumn::make('grades_count')->label('Calificados')->counts('grades'),

                TextColumn::make('weight') //pesos
                    ->label('Peso')
                    ->badge()
                    ->color('warning')
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
