<?php

namespace App\Filament\Resources\Cycles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;

class CyclesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Ciclo')->searchable()->sortable(),
                TextColumn::make('year')->label('Año')->sortable(),
                TextColumn::make('semester')->label('Semestre')->badge()->color('info'),
                IconColumn::make('active')->label('Activo')->boolean(),
                TextColumn::make('units_count')->label('Unidades')->counts('units'),
                TextColumn::make('students_count')->label('Estudiantes')->counts('students'),
            ])
            ->filters([
                SelectFilter::make('semester')
                    ->label('Semestre')
                    ->options(['I' => 'Semestre I', 'II' => 'Semestre II']),
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
