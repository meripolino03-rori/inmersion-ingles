<?php

namespace App\Filament\Resources\Criteria\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

use App\Models\Rubric;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class CriteriaTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->width(50),
                TextColumn::make('name')
                    ->label('Criterio')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Descripción')
                    ->limit(50)
                    ->color('gray'),
                TextColumn::make('rubric.type')
                    ->label('Rúbrica')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'writing'  => 'warning',
                        'reading'  => 'success',
                        'speaking' => 'info',
                        'alp'      => 'primary',
                        'final'    => 'danger',
                        default    => 'gray',
                    })
                    ->formatStateUsing(fn($state) => match ($state) {
                        'writing'  => 'Writing',
                        'reading'  => 'Reading',
                        'speaking' => 'Speaking',
                        'alp'      => 'ALP',
                        'final'    => 'Final',
                        default    => $state,
                    }),
            ])
            ->defaultSort('order')
            ->filters([
                SelectFilter::make('rubric_id')
                    ->label('Rúbrica')
                    ->options(
                        Rubric::all()->mapWithKeys(fn($r) => [
                            $r->id => ucfirst($r->type)
                        ])
                    ),
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
