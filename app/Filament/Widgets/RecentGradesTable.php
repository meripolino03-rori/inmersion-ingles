<?php

namespace App\Filament\Widgets;

use App\Models\Grade;
use App\Models\Cycle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecentGradesTable extends BaseWidget
{
    protected static ?string $heading = 'Últimas calificaciones';
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $cycle   = Cycle::where('active', true)->first();
        $teacher = Auth::user()->teacher;

        $query = Grade::with(['student.user', 'evaluation.rubric'])->latest();

        if ($teacher) {
            $studentIds = DB::table('student_assignments')
                ->join('assignments', 'assignments.id', '=', 'student_assignments.assignment_id')
                ->where('assignments.teacher_id', $teacher->id)
                ->where('assignments.cycle_id', $cycle?->id)
                ->pluck('student_assignments.student_id');

            $query->whereIn('student_id', $studentIds);
        } else {
            // Admin: solo del ciclo activo
            $query->whereHas(
                'student',
                fn($q) =>
                $q->where('cycle_id', $cycle?->id)
            );
        }

        return $table
            ->query($query->limit(8))
            ->columns([
                TextColumn::make('student.user.name')
                    ->label('Estudiante')
                    ->searchable(),

                TextColumn::make('student.code')
                    ->label('Código')
                    ->fontFamily('mono')
                    ->color('gray'),

                TextColumn::make('evaluation.title')
                    ->label('Evaluación')
                    ->limit(25),

                TextColumn::make('evaluation.rubric.type')
                    ->label('Rúbrica')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'writing'  => 'warning',
                        'reading'  => 'success',
                        'speaking' => 'info',
                        'alp'      => 'primary',
                        'final'    => 'danger',
                        default    => 'gray',
                    })
                    ->formatStateUsing(fn($state) => match ($state) {
                        'writing'  => 'Writing',
                        'reading'  => 'Reading',
                        'speaking' => 'Speaking',
                        'alp'      => 'ALP',
                        'final'    => 'Final',
                        default    => $state,
                    }),

                TextColumn::make('total')
                    ->label('Nota')
                    ->badge()
                    ->color(fn($state) => match (true) {
                        $state >= 18 => 'success',
                        $state >= 14 => 'info',
                        $state >= 10 => 'warning',
                        default      => 'danger',
                    })
                    ->formatStateUsing(
                        fn($state) =>
                        number_format($state, 1) . ' / 20'
                    ),

                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ]);
    }
}
