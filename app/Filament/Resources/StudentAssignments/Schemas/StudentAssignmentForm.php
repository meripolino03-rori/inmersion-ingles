<?php

namespace App\Filament\Resources\StudentAssignments\Schemas;

use Filament\Schemas\Schema;

use Filament\Schemas\Components\Section;

use Filament\Forms\Components\Select;

class StudentAssignmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Asignación de estudiantes')
                    ->description('Relaciona estudiantes con una sección docente.')
                    ->schema([

                        Select::make('assignment_id')
                            ->label('Sección docente')
                            ->relationship(
                                name: 'assignment',
                                titleAttribute: 'section'
                            )
                            ->getOptionLabelFromRecordUsing(
                                fn($record) =>
                                $record->teacher->user->name .
                                    ' • Sección ' .
                                    $record->section .
                                    ' • ' .
                                    $record->cycle->name
                            )
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(),

                        Select::make('student_id')
                            ->label('Estudiante')
                            ->options(function (callable $get) {

                                $assignmentId = $get('assignment_id');

                                if (!$assignmentId) {
                                    return [];
                                }

                                $assignment = \App\Models\Assignment::find($assignmentId);

                                if (!$assignment) {
                                    return [];
                                }

                                return \App\Models\Student::query()

                                    ->where('cycle_id', $assignment->cycle_id)

                                    ->where('school_id', $assignment->teacher->school_id)

                                    ->with('user')

                                    ->get()

                                    ->mapWithKeys(fn($student) => [
                                        $student->id =>
                                        $student->user->name .
                                            ' • ' .
                                            $student->code
                                    ]);
                            })

                            ->unique(
                                table: 'student_assignments',
                                column: 'student_id',
                                ignorable: fn($record) => $record,
                                modifyRuleUsing: function ($rule, callable $get) {

                                    return $rule->where(
                                        'assignment_id',
                                        $get('assignment_id')
                                    );
                                }
                            )

                            ->validationMessages([
                                'unique' =>
                                'Este estudiante ya fue asignado a esta sección.',
                            ])

                            ->searchable()
                            ->preload()
                            ->required(),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),

            ]);
    }
}
