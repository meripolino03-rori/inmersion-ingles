<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Practice;
use App\Models\Evaluation;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;

class StudentPortalController extends Controller
{
    private function getStudent()
    {
        return Student::with([
            'cycle',
            'user',
            'studentAssignments.assignment.teacher.user',
        ])
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }

    public function index()
    {
        $student = $this->getStudent();

        $assignment = $student->studentAssignments->first()?->assignment;
        $teacher = $assignment?->teacher;
        $section = $assignment?->section;

        // 1. PRIMERO: Obtener todos los datos necesarios
        $grades = Grade::where('student_id', $student->id)
            ->with(['evaluation.rubric', 'evaluation.unit'])
            ->get();

        $notaFinal = $this->finalGrade($student);

        $scores = [
            'writing'  => $this->avgByType($student, 'writing'),
            'reading'  => $this->avgByType($student, 'reading'),
            'speaking' => $this->avgByType($student, 'speaking'),
            'alp'      => $this->avgByType($student, 'alp'),
            'final'    => $this->avgByType($student, 'final'),
        ];

        $alp = Evaluation::with(['unit', 'grades' => fn($q) => $q->where('student_id', $student->id)])
            ->where('type', 'alp')
            ->whereHas('unit', fn($q) => $q->where('cycle_id', $student->cycle_id))
            ->orderBy('created_at')
            ->get();

        // 2. LUEGO: Definir los elementos visuales
        $skills = [
            'writing'  => 'Writing',
            'reading'  => 'Reading',
            'speaking' => 'Speaking',
            'final'    => 'Evaluación Final',
        ];

        $skillIcons = [
            'writing'  => 'fa-solid fa-pen-nib',
            'reading'  => 'fa-solid fa-book-open',
            'speaking' => 'fa-solid fa-microphone',
            'final'    => 'fa-solid fa-flag-checkered',
        ];

        $color = '#2563eb'; // Azul por defecto (amalfi)
        $nivel = 'En proceso';

        if (!is_null($notaFinal)) {
            if ($notaFinal >= 14) {
                $color = '#185FA5'; // Azul en vez de verde
                $nivel = 'Aprobado';
            } elseif ($notaFinal >= 11) {
                $color = '#BA7517'; // Ámbar
                $nivel = 'Regular';
            } else {
                $color = '#A32D2D'; // Rojo oscuro
                $nivel = 'Desaprobado';
            }
        }

        // 3. FINALMENTE: Retornar la vista con TODO listo
        return view('portal.home', compact(
            'student',
            'teacher',
            'section',
            'scores',
            'alp',
            'notaFinal',
            'grades',
            'skills',
            'skillIcons',
            'color', // <--- NUEVO
            'nivel'  // <--- NUEVO
        ));
    }

    public function progress()
    {
        $student = $this->getStudent();

        $assignment = $student
            ->studentAssignments
            ->first()?->assignment;

        $teacher = $assignment?->teacher;

        $section = $assignment?->section;

        $grades = $student->grades()
            ->with([
                'evaluation.rubric',
                'evaluation.unit'
            ])
            ->get()
            ->groupBy('evaluation_id');

        return view('portal.progress', compact(
            'student',
            'teacher',
            'section',
            'grades'
        ));
    }

    public function practices()
    {
        $student = $this->getStudent();

        $assignment = $student
            ->studentAssignments
            ->first()?->assignment;

        $teacher = $assignment?->teacher;

        $section = $assignment?->section;

        $practices = Practice::with('unit')
            ->whereHas(
                'unit',
                fn($q) =>
                $q->where('cycle_id', $student->cycle_id)
            )
            ->orderBy('unit_id')
            ->get()
            ->groupBy('unit_id');

        return view('portal.practices', compact(
            'student',
            'teacher',
            'section',
            'practices'
        ));
    }

    /**
     * Promedio por tipo de evaluación
     */
    private function avgByType(
        Student $student,
        string $type
    ): ?float {

        $avg = $student->grades()
            ->whereHas(
                'evaluation.rubric',
                fn($q) =>
                $q->where('type', $type)
            )
            ->avg('total');

        return $avg
            ? round($avg, 1)
            : null;
    }

    /**
     * Nota final ponderada
     */
    private function finalGrade(
        Student $student
    ): ?float {

        $grades = Grade::where(
            'student_id',
            $student->id
        )
            ->with('evaluation')
            ->get();

        if ($grades->isEmpty()) {
            return null;
        }

        $sumaPonderada = 0;
        $sumaPesos = 0;

        foreach ($grades as $grade) {

            $peso = $grade->evaluation->weight ?? 1;

            $sumaPonderada +=
                ($grade->total ?? 0) * $peso;

            $sumaPesos += $peso;
        }
        return $sumaPesos > 0
            ? round(
                $sumaPonderada / $sumaPesos,
                2
            )
            : null;
    }
}
