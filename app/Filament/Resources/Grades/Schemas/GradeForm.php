<?php

namespace App\Filament\Resources\Grades\Schemas;

use App\Models\Evaluation;
use App\Models\Student;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;

class GradeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Información académica')
                    ->description('Selecciona la evaluación y el estudiante.')
                    ->schema([

                        Select::make('evaluation_id')
                            ->label('Evaluación')
                            ->options(
                                Evaluation::with(['rubric', 'unit'])
                                    ->get()
                                    ->mapWithKeys(fn($evaluation) => [
                                        $evaluation->id =>
                                        $evaluation->title .
                                            ' • ' .
                                            ucfirst($evaluation->type)
                                    ])
                            )
                            ->searchable()
                            ->live()
                            ->required(),

                        Select::make('student_id')
                            ->label('Estudiante')
                            ->options(
                                Student::with('user')
                                    ->get()
                                    ->mapWithKeys(fn($student) => [
                                        $student->id =>
                                        $student->user->name .
                                            ' • ' .
                                            $student->code
                                    ])
                            )
                            ->searchable()
                            ->live()
                            ->required(),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Retroalimentación')
                    ->description('Comentarios generales del docente.')
                    ->schema([

                        Textarea::make('feedback')
                            ->label('Observaciones')
                            ->placeholder('Ej. Mejorar pronunciación y fluidez...')
                            ->columnSpanFull(),

                    ])
                    ->columnSpanFull(),

                Section::make('Evaluación por criterios')
                    ->description('Asigna el puntaje correspondiente a cada criterio.')
                    ->schema(function (Get $get) {

                        $evaluationId = $get('evaluation_id');

                        if (!$evaluationId) {

                            return [

                                Placeholder::make('select_evaluation')
                                    ->label('')
                                    ->content(
                                        '👆 Selecciona una evaluación para visualizar los criterios.'
                                    ),

                            ];
                        }

                        $evaluation = Evaluation::with('rubric.criteria')
                            ->find($evaluationId);

                        if (
                            !$evaluation ||
                            $evaluation->rubric->criteria->isEmpty()
                        ) {

                            return [

                                Placeholder::make('empty_criteria')
                                    ->label('')
                                    ->content(
                                        '⚠️ Esta rúbrica aún no tiene criterios registrados.'
                                    ),

                            ];
                        }

                        $criteriaCount = $evaluation->rubric
                            ->criteria
                            ->count();

                        $maxPerCriterion = round(
                            20 / $criteriaCount,
                            2
                        );

                        $fields = [];

                        foreach (
                            $evaluation->rubric->criteria->sortBy('order')
                            as $criterion
                        ) {

                            $fields[] = TextInput::make(
                                "scores.{$criterion->id}"
                            )
                                ->label($criterion->name)

                                ->helperText(
                                    $criterion->description .
                                        " • Máximo {$maxPerCriterion} pts"
                                )

                                ->numeric()

                                ->minValue(0)

                                ->maxValue($maxPerCriterion)

                                ->step(0.5)

                                ->suffix("/ {$maxPerCriterion}")

                                ->live(onBlur: true)

                                ->required();
                        }

                        $fields[] = Placeholder::make('total_preview')

                            ->label('Resultado estimado')

                            ->content(function (Get $get) {

                                $scores = $get('scores') ?? [];

                                $total = round(
                                    collect($scores)
                                        ->filter()
                                        ->sum(
                                            fn($value) => (float) $value
                                        ),
                                    2
                                );

                                [$nivel, $estado] = match (true) {

                                    $total >= 18 => [
                                        'Logro destacado',
                                        '🟢'
                                    ],

                                    $total >= 14 => [
                                        'Logro esperado',
                                        '🔵'
                                    ],

                                    $total >= 11 => [
                                        'En proceso',
                                        '🟠'
                                    ],

                                    default => [
                                        'En inicio',
                                        '🔴'
                                    ],
                                };

                                return
                                    "{$estado} {$total} / 20 — {$nivel}";
                            });

                        return $fields;
                    })

                    ->columns(2)
                    ->live()
                    ->columnSpanFull(),

            ]);
    }
}
