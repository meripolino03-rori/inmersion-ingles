<?php

namespace App\Filament\Resources\Practices\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;

class PracticesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Práctica')->searchable(),
                TextColumn::make('platform')
                    ->label('Plataforma')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'quizizz' => 'warning',
                        'kahoot'  => 'danger',
                        default   => 'gray',
                    })
                    ->formatStateUsing(fn($state) => match ($state) {
                        'quizizz' => 'Quizizz',
                        'kahoot'  => 'Kahoot',
                        default   => 'Otro',
                    }),
                TextColumn::make('unit.name')->label('Unidad'),
                TextColumn::make('url')
                    ->label('Enlace')
                    ->url(fn($record) => $record->url)
                    ->openUrlInNewTab()
                    ->limit(40),
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
