<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use App\Models\Cycle;
use App\Models\School;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentsBySchoolChart extends ChartWidget
{
    protected ?string $heading = 'Estudiantes por escuela profesional';
    protected static ?int $sort = 2;
    protected ?string $maxHeight = '200px';
    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $cycle   = Cycle::where('active', true)->first();
        $teacher = Auth::user()->teacher;

        $schools = School::all();
        $labels  = [];
        $data    = [];
        $colors  = ['#4c7ff5', '#f0a035', '#2ec4a9', '#f06b6b', '#9b7ff5'];

        foreach ($schools as $index => $school) {
            $query = Student::where('school_id', $school->id)
                ->where('cycle_id', $cycle?->id);

            if ($teacher) {
                $studentIds = DB::table('student_assignments')
                    ->join('assignments', 'assignments.id', '=', 'student_assignments.assignment_id')
                    ->where('assignments.teacher_id', $teacher->id)
                    ->where('assignments.cycle_id', $cycle?->id)
                    ->pluck('student_assignments.student_id');

                $query->whereIn('id', $studentIds);
            }

            $count = $query->count();

            if ($count > 0) {
                $labels[] = $school->name;
                $data[]   = $count;
            }
        }

        return [
            'datasets' => [[
                'data'            => $data,
                'backgroundColor' => array_slice($colors, 0, count($data)),
                'borderWidth'     => 2,
                'hoverOffset'     => 6,
            ]],
            'labels' => $labels,
        ];
    }

    protected function getType(): string { return 'doughnut'; }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display'  => true,
                    'position' => 'bottom',
                ],
            ],
            'cutout' => '65%',
        ];
    }
}