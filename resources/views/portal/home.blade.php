@extends('portal.layout')

@section('content')

<div class="py-6">

    {{-- ── 1. ENCABEZADO ── --}}
    <div class="mb-6">
        <h1 class="font-heading font-black text-amalfi text-2xl mb-4">Mi progreso académico</h1>

        <div class="rounded-2xl overflow-hidden bg-amalfi">
            <div class="grid grid-cols-3 divide-x divide-white/10">

                {{-- Ciclo --}}
                <div class="flex items-center gap-3 px-5 py-4">
                    <div class="w-8 h-8 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
                        <i class="fa-regular fa-calendar text-xs text-white"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-sans font-bold uppercase tracking-widest text-white/60">
                            Ciclo
                        </p>
                        <p class="font-sans font-bold text-white text-sm">
                            {{ $student->cycle->name }}
                        </p>
                    </div>
                </div>

                {{-- Código --}}
                <div class="flex items-center gap-3 px-5 py-4">
                    <div class="w-8 h-8 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-id-card text-xs text-white"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-sans font-bold uppercase tracking-widest text-white/60">
                            Código
                        </p>
                        <p class="font-sans font-bold text-white text-sm font-mono">
                            {{ $student->code }}
                        </p>
                    </div>
                </div>

                {{-- Docente --}}
                <div class="flex items-center gap-3 px-5 py-4">
                    <div class="w-8 h-8 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-chalkboard-user text-xs text-white"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[9px] font-sans font-bold uppercase tracking-widest text-white/60">
                            Docente
                        </p>
                        <p class="font-sans font-bold text-white text-sm truncate">
                            {{ Str::title($teacher?->user?->name ?? 'Sin asignar') }}
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ── 2. NOTA FINAL ── --}}
    <div class="bg-white border-2 border-amalfi rounded-2xl p-6 mb-6">
        <p class="text-[10px] font-sans font-bold uppercase tracking-widest text-amalfi mb-4">Nota final del ciclo</p>

        @if (!is_null($notaFinal))
            <div class="flex flex-col md:flex-row md:items-center gap-6">

                {{-- Nota grande --}}
                <div class="flex items-baseline gap-3 shrink-0">
                    <span class="font-heading font-black text-6xl leading-none text-amalfi">
                        {{ $notaFinal }}
                    </span>
                    <div class="flex flex-col gap-1">
                        <span class="text-base font-sans text-gray-400 font-medium leading-none">/ 20</span>
                        <span class="text-[10px] font-sans font-bold px-2.5 py-1 rounded-full uppercase leading-none bg-blue-50 text-amalfi">
                            {{ $nivel }}
                        </span>
                    </div>
                </div>

                {{-- Separador vertical --}}
                <div class="hidden md:block w-px bg-blue-100 self-stretch"></div>

                {{-- Detalle de notas + barra --}}
                <div class="flex-1 min-w-0">
                    <div class="w-full bg-blue-50 h-2 rounded-full mb-4 overflow-hidden">
                        <div class="h-full rounded-full bg-amalfi transition-all duration-700"
                            style="width: {{ ($notaFinal / 20) * 100 }}%"></div>
                    </div>
                    <table class="w-full text-sm font-sans">
                        @foreach ($grades as $grade)
                            <tr class="border-b border-blue-50 last:border-0">
                                <td class="py-2 font-medium text-gray-600">{{ $grade->evaluation->title }}</td>
                                <td class="py-2 text-center font-mono font-bold text-amalfi">
                                    {{ number_format($grade->total, 1) }}
                                </td>
                                <td class="py-2 text-right">
                                    <span class="text-[10px] font-sans font-bold px-2 py-0.5 rounded-full bg-blue-50 text-amalfi">
                                        Peso {{ $grade->evaluation->weight }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>

            </div>
        @else
            <div class="text-center py-6">
                <i class="fa-regular fa-chart-bar text-3xl text-gray-200 mb-3 block"></i>
                <p class="font-sans text-gray-400 italic text-sm">Aún no hay evaluaciones registradas.</p>
            </div>
        @endif
    </div>

    {{-- ── 3. HABILIDADES ── --}}
    @php
        // Contar cuántas prácticas (grades) tiene el estudiante por habilidad,
        // usando la cadena grade->evaluation->rubric->type
        $practiceCounts = $grades
            ->filter(fn($g) => in_array($g->evaluation->rubric->type ?? null, array_keys($skills)))
            ->groupBy(fn($g) => $g->evaluation->rubric->type)
            ->map(fn($group) => $group->count());
    @endphp

    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        @foreach ($skills as $key => $label)
            @php
                $score = $scores[$key] ?? null;
                $count = $practiceCounts[$key] ?? 0;
            @endphp

            <div class="rounded-2xl p-4 transition-all duration-200
                {{ $score
                    ? 'bg-white border-2 border-amalfi hover:shadow-md hover:-translate-y-0.5'
                    : 'bg-white border-2 border-dashed border-gray-200 opacity-70' }}">

                {{-- Icono + label --}}
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0
                        {{ $score ? 'bg-blue-50' : 'bg-gray-50' }}">
                        <i class="{{ $skillIcons[$key] }} text-xs {{ $score ? 'text-amalfi' : 'text-gray-300' }}"></i>
                    </div>
                    <p class="text-[9px] font-sans font-bold uppercase tracking-widest truncate
                        {{ $score ? 'text-amalfi' : 'text-gray-400' }}">
                        {{ $label }}
                    </p>
                </div>

                @if ($score)
                    <p class="font-heading font-black text-4xl text-amalfi mb-2 leading-none">{{ $score }}</p>
                    <div class="w-full bg-blue-50 h-1 rounded-full overflow-hidden mb-2">
                        <div class="bg-amalfi h-full rounded-full" style="width: {{ ($score / 20) * 100 }}%"></div>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] font-sans font-semibold text-green-600 flex items-center gap-1">
                            <i class="fa-solid fa-circle-check text-[10px]"></i> Completado
                        </p>
                        <p class="text-[10px] font-sans font-bold text-gray-400">
                            {{ $count }} {{ Str::plural('práctica', $count) }}
                        </p>
                    </div>
                @else
                    <p class="font-heading font-black text-4xl text-gray-200 mb-2 leading-none">—</p>
                    <div class="w-full bg-gray-100 h-1 rounded-full mb-2"></div>
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] font-sans italic text-gray-400">Pendiente</p>
                        @if ($count > 0)
                            <p class="text-[10px] font-sans font-bold text-gray-400">
                                {{ $count }} {{ Str::plural('práctica', $count) }}
                            </p>
                        @endif
                    </div>
                @endif

            </div>
        @endforeach
    </div>

    {{-- ── 4. TABLA ALP ── --}}
    <div class="bg-white border-2 border-amalfi rounded-2xl p-6">
        <h2 class="font-heading font-bold text-gray-900 text-base mb-5">Evaluaciones ALP por unidad</h2>
        <table class="w-full text-sm font-sans">
            <thead>
                <tr class="text-[9px] font-bold uppercase tracking-widest text-amalfi border-b border-blue-100">
                    <th class="text-left pb-3">Unidad</th>
                    <th class="text-center pb-3">Puntaje</th>
                    <th class="text-right pb-3">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-blue-50">
                @forelse($alp as $eval)
                    @php $avg = $eval->grades->avg('total'); @endphp
                    <tr class="hover:bg-blue-50/40 transition-colors">
                        <td class="py-3.5 font-medium text-gray-700">{{ $eval->unit->name }}</td>
                        <td class="py-3.5 text-center font-mono font-bold text-amalfi">
                            {{ !is_null($avg) ? number_format($avg, 1) : '—' }}
                        </td>
                        <td class="py-3.5 text-right">
                            @if (!is_null($avg) && $avg >= 14)
                                <span class="text-[10px] font-bold uppercase px-2.5 py-1 rounded-full bg-green-50 text-green-700">
                                    Aprobado
                                </span>
                            @elseif (!is_null($avg))
                                <span class="text-[10px] font-bold uppercase px-2.5 py-1 rounded-full bg-cream text-yellow-800">
                                    En revisión
                                </span>
                            @else
                                <span class="text-[10px] font-bold uppercase px-2.5 py-1 rounded-full bg-gray-100 text-gray-400">
                                    Pendiente
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-12">
                            <i class="fa-regular fa-folder-open text-3xl text-gray-200 mb-3 block"></i>
                            <p class="text-gray-400 italic text-sm">No hay evaluaciones ALP registradas.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection