<?php

namespace App\Filament\Resources\Rubrics\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class RubricsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state) => match($state) {
                        'writing'  => 'warning',
                        'reading'  => 'success',
                        'speaking' => 'info',
                        'alp'      => 'primary',
                        'final'    => 'danger',
                        default    => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match($state) {
                        'writing'  => 'Writing',
                        'reading'  => 'Reading',
                        'speaking' => 'Speaking',
                        'alp'      => 'ALP',
                        'final'    => 'Final',
                        default    => $state,
                    }),
                TextColumn::make('description')->label('Descripción')->limit(50),
                TextColumn::make('criteria_count')->label('Criterios')->counts('criteria')->badge()->color('gray'),
                TextColumn::make('evaluations_count')->label('Evaluaciones')->counts('evaluations'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                //DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
