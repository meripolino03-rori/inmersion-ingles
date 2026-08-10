@extends('portal.layout')

@section('content')
    <div class="py-10">

        {{-- ── HEADER ── --}}
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-amalfi flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-graduation-cap text-white text-2xl"></i>
            </div>
            <h1 class="font-heading font-black text-amalfi text-2xl mb-2">Resultados del diagnóstico</h1>
            <p class="font-sans text-gray-400 text-sm">
                Hemos evaluado tu nivel de inglés según el Marco Común Europeo de Referencia (MCER).
            </p>
        </div>

        {{-- ── NIVEL MCER ── --}}
        <div class="bg-white border-2 border-amalfi rounded-2xl p-6 mb-4 text-center">
            <p class="text-[9px] font-sans font-bold uppercase tracking-widest text-amalfi/60 mb-2">
                Tu nivel determinado
            </p>
            <p class="font-heading font-black text-7xl text-amalfi leading-none mb-3">
                {{ $level }}
            </p>
            @php
                $levelDesc = match ($level) {
                    'A1' => 'Principiante — Comprendes y usas expresiones básicas del inglés.',
                    'A2' => 'Básico — Puedes comunicarte en situaciones simples y familiares.',
                    'B1' => 'Intermedio — Puedes desenvolverte en la mayoría de situaciones cotidianas.',
                    'B2' => 'Intermedio alto — Puedes interactuar con fluidez con hablantes nativos.',
                    'C1' => 'Avanzado — Usas el inglés de forma flexible y efectiva.',
                    'C2' => 'Maestría — Dominas el inglés con precisión y fluidez.',
                    default => 'Nivel determinado según tus respuestas.',
                };
            @endphp
            <p class="font-sans text-gray-500 text-sm">{{ $levelDesc }}</p>
        </div>

        {{-- ── FORTALEZAS + DEBILIDADES + ANÁLISIS ── --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            {{-- Fortalezas --}}
            <div class="bg-white border-2 border-amalfi rounded-2xl p-5">
                <p class="text-[9px] font-sans font-bold uppercase tracking-widest text-green-600 mb-4 flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-check text-green-500"></i> Lo que haces bien
                </p>
                @forelse($strengths as $strength)
                    <div class="flex items-center gap-2.5 mb-2.5 last:mb-0">
                        <div class="w-6 h-6 rounded-lg bg-green-50 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-check text-[9px] text-green-600"></i>
                        </div>
                        <p class="font-sans text-sm text-gray-700">{{ $strength }}</p>
                    </div>
                @empty
                    <p class="font-sans text-sm text-gray-400 italic">Sin fortalezas detectadas.</p>
                @endforelse
            </div>

            {{-- Debilidades --}}
            <div class="bg-white border-2 border-amalfi rounded-2xl p-5">
                <p class="text-[9px] font-sans font-bold uppercase tracking-widest text-yellow-700 mb-4 flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-trend-up text-yellow-600"></i> Por mejorar
                </p>
                @forelse($weaknesses as $weakness)
                    <div class="flex items-center gap-2.5 mb-2.5 last:mb-0">
                        <div class="w-6 h-6 rounded-lg bg-cream flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-arrow-up text-[9px] text-yellow-700"></i>
                        </div>
                        <p class="font-sans text-sm text-gray-700">{{ $weakness }}</p>
                    </div>
                @empty
                    <p class="font-sans text-sm text-gray-400 italic">Sin áreas de mejora detectadas.</p>
                @endforelse
            </div>

            {{-- Análisis --}}
            <div class="bg-white border-2 border-amalfi rounded-2xl p-5">
                <p class="text-[9px] font-sans font-bold uppercase tracking-widest text-amalfi mb-4 flex items-center gap-1.5">
                    <i class="fa-solid fa-brain text-amalfi"></i> Análisis detallado
                </p>
                @if ($analysis)
                    <p class="font-sans text-sm text-gray-600 leading-relaxed">
                        {{ Str::limit($analysis, 200) }}
                    </p>
                @else
                    <p class="font-sans text-sm text-gray-400 italic">Sin análisis disponible.</p>
                @endif
            </div>

        </div>

        {{-- ── BOTÓN AL PLAN ── --}}
        <div class="flex justify-center">
            <a href="{{ route('portal.study-plan') }}"
                class="group inline-flex items-center justify-between gap-3
              bg-amalfi hover:bg-blue-800 active:scale-[0.98]
              text-white font-heading font-black text-sm
              px-6 py-3.5 rounded-2xl shadow-lg shadow-amalfi/20
              hover:-translate-y-0.5 transition-all duration-200 min-w-80">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-book-open text-sm"></i>
                    <span>Ver mi plan de estudios personalizado</span>
                </div>
                <i class="fa-solid fa-arrow-right opacity-60 group-hover:opacity-100
                  group-hover:translate-x-1 transition-all duration-200 text-xs"></i>
            </a>
        </div>

    </div>
@endsection