<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class GroupReportExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    public function __construct(
        private $students,
        private $cycle
    ) {}

    public function title(): string
    {
        return 'Reporte ' . ($this->cycle?->name ?? 'Ciclo');
    }

    public function headings(): array
    {
        return [
            '#',
            'Nombre completo',
            'Código',
            'Escuela',
            'Grupo',
            'Nivel IA',
            'Evaluaciones',
            'Nota final',
            'Estado',
        ];
    }

    public function collection()
    {
        return $this->students->map(function ($student, $i) {
            $grades = $student->grades;

            $notaFinal = null;
            if ($grades->isNotEmpty()) {
                $sumaPonderada = 0;
                $sumaPesos     = 0;
                foreach ($grades as $grade) {
                    $peso           = $grade->evaluation->weight ?? 1;
                    $sumaPonderada += $grade->total * $peso;
                    $sumaPesos     += $peso;
                }
                $notaFinal = $sumaPesos > 0
                    ? round($sumaPonderada / $sumaPesos, 2)
                    : null;
            }

            $seccion = \App\Models\StudentAssignment::where('student_id', $student->id)
                ->with('assignment')
                ->first()
                ?->assignment
                ?->section ?? '—';

            return [
                $i + 1,
                $student->user->name,
                $student->code,
                $student->school->name ?? '—',
                $seccion,
                $student->level ?? '—',
                $grades->count(),
                $notaFinal ? number_format($notaFinal, 2) : '—',
                $notaFinal >= 10 ? 'Aprobado' : ($notaFinal ? 'Desaprobado' : 'Sin evaluar'),
            ];
        });
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header en azul
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF5B6EF5'],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}
