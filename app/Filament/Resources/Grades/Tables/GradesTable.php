<?php

namespace App\Filament\Resources\Grades\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Table;
use App\Models\Evaluation;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class GradesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.user.name')
                    ->label('Estudiante')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('student.code')
                    ->label('Código')
                    ->fontFamily('mono')
                    ->color('gray'),
                TextColumn::make('evaluation.title')
                    ->label('Evaluación')
                    ->searchable()
                    ->limit(30),
                TextColumn::make('evaluation.type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'practice' => 'warning',
                        'alp'      => 'success',
                        'final'    => 'danger',
                        default    => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'practice' => 'Práctica',
                        'alp'      => 'ALP',
                        'final'    => 'Final',
                        default    => $state,
                    }),
                TextColumn::make('total')
                    ->label('Nota final')
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 18 => 'success',
                        $state >= 14 => 'info',
                        $state >= 10 => 'warning',
                        default      => 'danger',
                    })
                    ->formatStateUsing(fn ($state) => number_format($state, 2) . ' / 20'),
                TextColumn::make('feedback')
                    ->label('Observaciones')
                    ->limit(40)
                    ->color('gray'),
            ])
            ->filters([
                SelectFilter::make('evaluation_id')
                    ->label('Evaluación')
                    ->options(Evaluation::pluck('title', 'id')),
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