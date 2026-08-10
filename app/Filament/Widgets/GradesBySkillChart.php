<?php

namespace App\Filament\Widgets;

use App\Models\Grade;
use App\Models\Cycle;
use App\Models\Assignment;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GradesBySkillChart extends ChartWidget
{
    protected ?string $heading = 'Promedio por habilidad';
    protected static ?int $sort = 2;
    protected ?string $maxHeight = '200px';
    protected int|string|array $columnSpan = 2;

    protected function getData(): array
    {
        $cycle   = Cycle::where('active', true)->first();
        $teacher = Auth::user()->teacher;

        $studentIds = null;
        if ($teacher) {
            $studentIds = DB::table('student_assignments')
                ->join('assignments', 'assignments.id', '=', 'student_assignments.assignment_id')
                ->where('assignments.teacher_id', $teacher->id)
                ->where('assignments.cycle_id', $cycle?->id)
                ->pluck('student_assignments.student_id');
        }

        $tipos  = ['writing', 'reading', 'speaking', 'alp', 'final'];
        $labels = ['Writing', 'Reading', 'Speaking', 'ALP', 'Final'];
        $colors = ['#f0a035', '#2ec4a9', '#9b7ff5', '#4caf7d', '#f06b6b'];
        $data   = [];

        foreach ($tipos as $tipo) {
            $query = Grade::whereHas('evaluation.rubric', fn($q) =>
                $q->where('type', $tipo)
            );

            if ($studentIds !== null) {
                $query->whereIn('student_id', $studentIds);
            }

            $data[] = round((float) ($query->avg('total') ?? 0), 1);
        }

        return [
            'datasets' => [[
                'label'           => 'Promedio / 20',
                'data'            => $data,
                'backgroundColor' => $colors,
                'borderRadius'    => 6,
                'borderWidth'     => 0,
            ]],
            'labels' => $labels,
        ];
    }

    protected function getType(): string { return 'bar'; }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'min'   => 0,
                    'max'   => 20,
                    'ticks' => ['stepSize' => 4],
                ],
                'x' => ['grid' => ['display' => false]],
            ],
            'plugins' => ['legend' => ['display' => false]],
        ];
    }
}