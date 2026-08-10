<?php

namespace App\Filament\Resources\Students\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

use Illuminate\Support\Facades\Auth;
use App\Models\Cycle;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Nombre completo')->searchable()->sortable(),
                TextColumn::make('code')->label('Código')->searchable()->fontFamily('mono'),
                TextColumn::make('cycle.name')->label('Ciclo')->badge()->color('success'),
                TextColumn::make('grades_count')->label('Evaluaciones')->counts('grades'),
                TextColumn::make('school.name')
                    ->label('Escuela')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('section')
                    ->label('Grupo')
                    ->badge()
                    ->color('info')
                    ->getStateUsing(
                        fn($record) =>
                        \App\Models\StudentAssignment::where('student_id', $record->id)
                            ->with('assignment')
                            ->first()
                            ?->assignment
                            ?->section ?? '—'
                    ),
            ])
            ->filters([
                SelectFilter::make('cycle_id')
                    ->label('Ciclo')
                    ->options(Cycle::pluck('name', 'id')),

                SelectFilter::make('section')
                    ->label('Sección')
                    ->options(function () {
                        $teacher = Auth::user()->teacher;
                        if (!$teacher) return [];

                        return \App\Models\Assignment::where('teacher_id', $teacher->id)
                            ->pluck('section', 'section')
                            ->toArray();
                    })
                    ->query(
                        fn($query, $data) =>
                        $data['value']
                            ? $query->whereHas(
                                'studentAssignments.assignment',
                                fn($q) =>
                                $q->where('section', $data['value'])
                            )
                            : $query
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
