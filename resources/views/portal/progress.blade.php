@extends('portal.layout')

@section('content')

    <div class="py-1">

        {{-- ── ENCABEZADO ── --}}
        <div class="mb-4">
            <h1 class="font-heading font-black text-amalfi text-2xl tracking-tight mb-2">
                Detalle de calificaciones
            </h1>
            <div class="flex items-center gap-3 flex-wrap">
                <span
                    class="flex items-center gap-1.5 text-xs font-sans font-bold px-3 py-1 rounded-full bg-blue-50 text-amalfi">
                    <i class="fa-regular fa-calendar"></i> {{ $student->cycle->name }}
                </span>
            </div>
        </div>

        {{-- ── CARDS DE EVALUACIÓN ── --}}
        @forelse($grades as $evaluationId => $evalGrades)
            @php
                $grade = $evalGrades->first();
                $eval = $grade->evaluation;
                $scores = $grade->scores ?? [];
                $total = $grade->total ?? 0;
                $pct = round(($total / 20) * 100);
                $criteria = $eval->rubric?->criteria ?? collect();

                $tipo = match ($eval->type ?? '') {
                    'practice' => 'Práctica',
                    'alp' => 'ALP',
                    'final' => 'Final',
                    default => $eval->type ?? '—',
                };

                $habilidad = match ($eval->rubric?->type ?? '') {
                    'writing' => 'Writing',
                    'reading' => 'Reading',
                    'speaking' => 'Speaking',
                    'alp' => 'ALP',
                    'final' => 'Final',
                    default => null,
                };

                $tipoLabel = $habilidad ? "{$tipo} · {$habilidad}" : $tipo;

                $scoreColor = $total >= 14 ? 'text-amalfi' : ($total >= 11 ? 'text-citrus' : 'text-red-500');
                $barColor = $total >= 14 ? 'bg-amalfi' : ($total >= 11 ? 'bg-citrus' : 'bg-red-400');
                $badgeBg =
                    $total >= 14
                        ? 'bg-blue-50 text-amalfi'
                        : ($total >= 11
                            ? 'bg-cream text-yellow-800'
                            : 'bg-red-50 text-red-600');
                $nivelLabel = $total >= 14 ? 'Aprobado' : ($total >= 11 ? 'Regular' : 'Desaprobado');
            @endphp

            <div
                class="bg-white border-2 border-amalfi rounded-2xl overflow-hidden mb-6 transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">

                {{-- Cabecera con fondo sutil --}}
                <div class="bg-blue-50/50 px-5 pt-3 pb-2 border-b border-blue-100">
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        <div>
                            <span
                                class="text-[9px] font-sans font-bold uppercase tracking-widest text-amalfi/60 mb-0.5 block">
                                {{ $tipoLabel }}
                            </span>
                            <h2 class="font-heading font-bold text-gray-900 text-base leading-tight">
                                {{ $eval->title }}
                            </h2>
                        </div>
                        <div class="text-right shrink-0">
                            <div class="flex items-baseline gap-1.5 justify-end">
                                <span class="font-heading font-black text-4xl leading-none {{ $scoreColor }}">
                                    {{ number_format($total, 1) }}
                                </span>
                                <span class="text-sm font-sans text-gray-300 font-medium">/ 20</span>
                            </div>
                            <span
                                class="text-[10px] font-sans font-bold px-2.5 py-0.5 rounded-full uppercase mt-1 inline-block {{ $badgeBg }}">
                                {{ $nivelLabel }}
                            </span>
                        </div>
                    </div>

                    {{-- Barra de progreso --}}
                    <div class="w-full bg-white h-1.5 rounded-full mt-2 overflow-hidden">
                        <div class="{{ $barColor }} h-full rounded-full transition-all duration-700"
                            style="width: {{ $pct }}%"></div>
                    </div>
                </div>

                {{-- Tabla de criterios --}}
                <div class="px-5 pb-1">
                    @if ($criteria->count())
                        <table class="w-full text-sm font-sans">
                            <thead>
                                <tr
                                    class="text-[9px] font-bold uppercase tracking-widest text-amalfi border-b border-blue-100">
                                    <th class="text-left py-1.5">Criterio de evaluación</th>
                                    <th class="text-center py-1.5 w-16">Puntaje</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-blue-50">
                                @foreach ($criteria as $criterion)
                                    @php
                                        $s = $scores[$criterion->id] ?? null;
                                    @endphp
                                    <tr class="hover:bg-blue-50/30 transition-colors group">
                                        <td class="py-2 pr-6">
                                            <p
                                                class="font-medium text-gray-800 mb-0 group-hover:text-amalfi transition-colors">
                                                {{ $criterion->name }}
                                            </p>
                                            <p class="text-[11px] text-gray-400 leading-snug">
                                                {{ $criterion->description }}
                                            </p>
                                        </td>
                                        <td class="py-2 text-center">
                                            @if (!is_null($s))
                                                <p
                                                    class="font-heading font-black text-xl leading-none {{ $scoreColor }}">
                                                    {{ $s }}
                                                </p>
                                            @else
                                                <p class="font-heading font-black text-xl leading-none text-gray-200">—</p>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="py-4 text-center">
                            <i class="fa-regular fa-circle-question text-2xl text-gray-200 mb-2 block"></i>
                            <p class="text-sm font-sans text-gray-400 italic">Sin criterios registrados.</p>
                        </div>
                    @endif
                </div>

            </div>

        @empty
            <div class="text-center py-12 bg-white rounded-2xl border-2 border-amalfi/20">
                <i class="fa-solid fa-clipboard-question text-5xl text-amalfi opacity-10 mb-4 block"></i>
                <p class="font-heading font-bold text-gray-400 text-base mb-1">Sin calificaciones aún</p>
                <p class="font-sans text-gray-300 text-sm italic">Tus notas aparecerán aquí cuando sean registradas.</p>
            </div>
        @endforelse

    </div>

@endsection
