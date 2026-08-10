<?php

namespace App\Filament\Resources\Units\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Models\Cycle;
use Filament\Actions\DeleteAction;

class UnitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->label('#')->sortable()->width(60),
                TextColumn::make('name')->label('Unidad')->searchable()->sortable(),
                TextColumn::make('cycle.name')->label('Ciclo')->badge()->color('success'),
                TextColumn::make('evaluations_count')->label('Evaluaciones')->counts('evaluations'),
                TextColumn::make('practices_count')->label('Prácticas')->counts('practices'),
            ])
            ->defaultSort('number')
            ->filters([
                SelectFilter::make('cycle_id')
                    ->label('Ciclo')
                    ->options(Cycle::pluck('name', 'id')),
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
