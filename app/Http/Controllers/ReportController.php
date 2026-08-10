<?php

namespace App\Http\Controllers;

use App\Exports\GroupReportExport;
use App\Models\Student;
use App\Models\StudentAssignment;
use App\Models\Cycle;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function groupExcel()
    {
        $user    = Auth::user();
        $teacher = $user->teacher;
        $cycle   = Cycle::where('active', true)->first();

        if ($user->hasRole('admin')) {
            $students = Student::with(['user', 'school', 'grades.evaluation'])
                ->where('cycle_id', $cycle?->id)
                ->get();
        } else {
            $studentIds = StudentAssignment::whereHas(
                'assignment',
                fn($q) =>
                $q->where('teacher_id', $teacher->id)
            )->pluck('student_id');

            $students = Student::with(['user', 'school', 'grades.evaluation'])
                ->whereIn('id', $studentIds)
                ->get();
        }

        $filename = 'reporte-grupal-' . ($cycle?->name ?? 'ciclo') . '.xlsx';

        return Excel::download(new GroupReportExport($students, $cycle), $filename);
    }
}
