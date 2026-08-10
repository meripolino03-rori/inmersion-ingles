<?php

namespace App\Filament\Resources\StudentAssignments\Tables;

use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class StudentAssignmentsTable
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
                    ->searchable(),

                TextColumn::make('student.school.name')
                    ->label('Escuela')
                    ->badge()
                    ->sortable(),

                TextColumn::make('assignment.teacher.user.name')
                    ->label('Docente')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('assignment.section')
                    ->label('Grupo')
                    ->badge(),

                TextColumn::make('assignment.cycle.name')
                    ->label('Ciclo')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Asignado')
                    ->dateTime('d/m/Y')
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
