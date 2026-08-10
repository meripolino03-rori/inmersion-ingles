@extends('portal.layout')

@section('content')

<div class="max-w-3xl mx-auto py-6 px-4">

    {{-- ── HEADER ── --}}
    <div class="text-center mb-8">
        <div class="w-16 h-16 rounded-2xl bg-amalfi flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-robot text-white text-2xl"></i>
        </div>
        <h1 class="font-heading font-black text-amalfi text-2xl mb-2">Inglés con IA</h1>
        <p class="font-sans text-gray-400 text-sm leading-relaxed">
            La IA evaluará tu nivel de inglés y creará un plan de estudio
            personalizado según tu carrera profesional.
        </p>
    </div>

    {{-- ── NIVEL ACTUAL ── --}}
    @if ($student->level)
        <div class="bg-white border-2 border-amalfi rounded-2xl p-5 mb-4 text-center">
            <p class="text-[10px] font-sans font-bold uppercase tracking-widest text-amalfi/60 mb-2">Tu nivel actual</p>
            <p class="font-heading font-black text-6xl text-amalfi leading-none mb-4">{{ $student->level }}</p>

            @if (!empty($student->strengths))
                <div class="flex gap-2 justify-center flex-wrap mb-2">
                    @foreach ($student->strengths as $s)
                        <span class="text-[10px] font-bold uppercase px-2.5 py-1 rounded-full bg-green-50 text-green-700">
                            ✓ {{ $s }}
                        </span>
                    @endforeach
                </div>
            @endif

            @if (!empty($student->weaknesses))
                <div class="flex gap-2 justify-center flex-wrap">
                    @foreach ($student->weaknesses as $w)
                        <span class="text-[10px] font-bold uppercase px-2.5 py-1 rounded-full bg-cream text-yellow-800">
                            ↑ {{ $w }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    {{-- ── QUÉ INCLUYE ── --}}
    <div class="bg-white border-2 border-amalfi rounded-2xl p-5 mb-4">
        <p class="text-[10px] font-sans font-bold uppercase tracking-widest text-amalfi mb-4">¿Qué incluye el diagnóstico?</p>
        <div class="grid grid-cols-2 gap-4">
            @foreach ([
                ['fa-solid fa-pen-nib',      'Writing',    'Redacción y expresión',   'text-amalfi',      'bg-blue-50'],
                ['fa-solid fa-book-open',    'Reading',    'Comprensión de textos',    'text-amalfi',      'bg-blue-50'],
                ['fa-solid fa-spell-check',  'Grammar',    'Gramática y estructura',   'text-yellow-700',  'bg-cream'],
                ['fa-solid fa-layer-group',  'Vocabulary', 'Vocabulario técnico',      'text-yellow-700',  'bg-cream'],
            ] as [$icon, $skill, $desc, $iconColor, $iconBg])
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl {{ $iconBg }} flex items-center justify-center shrink-0">
                        <i class="{{ $icon }} text-xs {{ $iconColor }}"></i>
                    </div>
                    <div>
                        <p class="font-sans font-semibold text-gray-800 text-sm leading-tight">{{ $skill }}</p>
                        <p class="font-sans text-[11px] text-gray-400 leading-tight mt-0.5">{{ $desc }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ── STATS ── --}}
    <div class="grid grid-cols-2 gap-3 mb-6">
        <div class="bg-white border-2 border-amalfi rounded-2xl p-4 text-center">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center mx-auto mb-2">
                <i class="fa-regular fa-clock text-amalfi"></i>
            </div>
            <p class="font-heading font-bold text-gray-800 text-sm">~10 minutos</p>
            <p class="font-sans text-[11px] text-gray-400">Duración aprox.</p>
        </div>
        <div class="bg-white border-2 border-amalfi rounded-2xl p-4 text-center">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center mx-auto mb-2">
                <i class="fa-regular fa-clipboard text-amalfi"></i>
            </div>
            <p class="font-heading font-bold text-gray-800 text-sm">10 preguntas</p>
            <p class="font-sans text-[11px] text-gray-400">Una a la vez</p>
        </div>
    </div>

    {{-- ── BOTONES ── --}}
    <div class="flex flex-col gap-3">

        {{-- Botón principal --}}
        <a href="{{ route('portal.placement') }}?start=1"
           class="group relative w-full flex items-center justify-center gap-3
                  bg-amalfi hover:bg-amalfi-dark active:scale-[0.98]
                  text-white font-heading font-black text-base
                  px-6 py-4 rounded-2xl
                  shadow-lg shadow-amalfi/20
                  hover:-translate-y-0.5 active:translate-y-0
                  transition-all duration-200">
            <i class="{{ $student->level ? 'fa-solid fa-rotate' : 'fa-solid fa-rocket' }} text-sm"></i>
            <span>{{ $student->level ? 'Volver a hacer el diagnóstico' : 'Comenzar diagnóstico ahora' }}</span>
            <i class="fa-solid fa-arrow-right ml-auto opacity-60 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-200 text-xs"></i>
        </a>

        {{-- Botón secundario plan de estudios --}}
        @if ($studyPlan)
            <a href="{{ route('portal.study-plan') }}"
               class="group w-full flex items-center justify-center gap-3
                      bg-white hover:bg-blue-50
                      text-amalfi font-heading font-bold text-sm
                      px-6 py-3.5 rounded-2xl
                      border-2 border-amalfi/30 hover:border-amalfi
                      hover:-translate-y-0.5 active:scale-[0.98]
                      transition-all duration-200">
                <i class="fa-solid fa-book-open text-sm"></i>
                <span>Ver mi plan de estudios actual</span>
                <i class="fa-solid fa-arrow-right ml-auto opacity-40 group-hover:opacity-80 group-hover:translate-x-1 transition-all duration-200 text-xs"></i>
            </a>
        @endif

    </div>

</div>

@endsection