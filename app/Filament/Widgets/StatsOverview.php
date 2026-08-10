<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use App\Models\Grade;
use App\Models\Cycle;
use App\Models\Challenge;
use App\Models\Assignment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int|string|array $columnSpan = 'full';
    protected function getStats(): array
    {
        $cycle   = Cycle::where('active', true)->first();
        $teacher = Auth::user()->teacher;

        $studentIds = $this->getStudentIds($cycle, $teacher);

        $totalStudents   = $studentIds === null
            ? Student::where('cycle_id', $cycle?->id)->count()
            : $studentIds->count();

        $totalGrades = $studentIds === null
            ? Grade::whereHas('student', fn($q) => $q->where('cycle_id', $cycle?->id))->count()
            : Grade::whereIn('student_id', $studentIds)->count();

        $avgTotal = $studentIds === null
            ? Grade::whereHas('student', fn($q) => $q->where('cycle_id', $cycle?->id))->avg('total')
            : Grade::whereIn('student_id', $studentIds)->avg('total');

        $totalChallenges = $studentIds === null
            ? Challenge::where('status', 'submitted')
            ->whereHas('student', fn($q) => $q->where('cycle_id', $cycle?->id))->count()
            : Challenge::whereIn('student_id', $studentIds)
            ->where('status', 'submitted')->count();

        $avgFormatted = $avgTotal !== null
            ? number_format((float) $avgTotal, 1) . ' / 20'
            : '—';

        $avgColor = match (true) {
            $avgTotal === null => 'gray',
            $avgTotal >= 14   => 'success',
            $avgTotal >= 10   => 'warning',
            default           => 'danger',
        };

        $descripcion = $teacher
            ? 'Mis estudiantes – ' . ($cycle?->name ?? '—')
            : 'Ciclo activo: ' . ($cycle?->name ?? '—');

        return [
            Stat::make('Estudiantes activos', $totalStudents)
                ->description($descripcion)
                ->color('success')
                ->icon('heroicon-o-academic-cap'),

            Stat::make('Evaluaciones calificadas', $totalGrades)
                ->description($teacher ? 'Evaluaciones de mis secciones' : 'Total del ciclo')
                ->color('info')
                ->icon('heroicon-o-clipboard-document-check'),

            Stat::make('Promedio general', $avgFormatted)
                ->description($teacher ? 'Nota promedio de mis estudiantes' : 'Nota promedio del ciclo')
                ->color($avgColor)
                ->icon('heroicon-o-chart-bar'),

            Stat::make('Retos completados (IA)', $totalChallenges)
                ->description($teacher ? 'Retos de mis estudiantes' : 'Por todos los estudiantes')
                ->color('warning')
                ->icon('heroicon-o-sparkles'),
        ];
    }

    // null = admin (sin filtro), Collection = docente (ids filtrados)
    private function getStudentIds($cycle, $teacher)
    {
        if (!$teacher) return null;

        return DB::table('student_assignments')
            ->join('assignments', 'assignments.id', '=', 'student_assignments.assignment_id')
            ->where('assignments.teacher_id', $teacher->id)
            ->where('assignments.cycle_id', $cycle?->id)
            ->pluck('student_assignments.student_id');
    }
}
