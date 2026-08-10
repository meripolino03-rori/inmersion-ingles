@extends('portal.layout')

@section('content')

    <div class="max-w-5xl mx-auto py-8 px-6">

        {{-- ── HEADER ── --}}
        <div class="mb-6">
            <h1 class="font-heading font-black text-amalfi text-2xl mb-1">Mi plan de estudio</h1>
            <p class="font-sans text-gray-400 text-sm">
                <i class="fa-solid fa-graduation-cap mr-1"></i>
                Plan personalizado según tu nivel —
                <strong class="text-amalfi">{{ $studyPlan->level ?? ($student->level ?? '—') }}</strong>
            </p>
        </div>

        {{-- ── CARD PRINCIPAL ── --}}
        @php $plan = $studyPlan->plan ?? []; @endphp

        <div class="bg-white border border-gray-200 rounded-3xl p-8 mb-6 shadow-lg shadow-blue-900/5">

            {{-- ── FILA 1: Nivel | Enfoque | Consejos ── --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">

                {{-- Nivel --}}
                <div class="md:col-span-2 text-center md:text-left">
                    <div class="bg-amalfi rounded-2xl px-4 py-5 text-center shadow-md shadow-amalfi/30">
                        <p class="text-[9px] font-bold uppercase tracking-widest text-white/60 mb-1">Nivel MCER</p>
                        <p class="font-mono font-black text-6xl text-white leading-none mb-2">
                            {{ $studyPlan->level ?? ($student->level ?? '—') }}
                        </p>
                        @php
                            $lvl = $studyPlan->level ?? ($student->level ?? 'A1');
                            $levelDesc = match ($lvl) {
                                'A1' => 'Principiante',
                                'A2' => 'Básico',
                                'B1' => 'Intermedio',
                                'B2' => 'Intermedio alto',
                                'C1' => 'Avanzado',
                                'C2' => 'Maestría',
                                default => '',
                            };
                        @endphp
                        @if ($levelDesc)
                            <span class="text-[9px] font-bold uppercase tracking-widest px-2.5 py-1
                                 rounded-full bg-white/15 text-white">
                                {{ $levelDesc }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Enfoque del plan --}}
                @if (!empty($plan['focus_areas']))
                    <div class="md:col-span-5">
                        <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-3 flex items-center gap-1.5">
                            <i class="fa-solid fa-bullseye text-amalfi"></i> Enfoque del plan
                        </p>
                        <div class="flex gap-2 flex-wrap">
                            @foreach ($plan['focus_areas'] as $area)
                                <span class="text-[10px] font-bold uppercase px-3 py-1.5 rounded-full
                                             bg-amalfi text-white shadow-sm shadow-amalfi/20">
                                    {{ $area }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Consejos --}}
                @if (!empty($plan['study_tips']))
                    <div class="md:col-span-5">
                        <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-3 flex items-center gap-1.5">
                            <i class="fa-solid fa-lightbulb text-yellow-500"></i> Consejos para tu nivel
                        </p>
                        <div class="space-y-2.5">
                            @foreach ($plan['study_tips'] as $tip)
                                <div class="flex gap-2.5 items-start bg-cream/50 rounded-xl p-3">
                                    <i class="fa-solid fa-arrow-right text-xs text-yellow-600 mt-0.5 shrink-0"></i>
                                    <span class="text-xs text-gray-700 leading-relaxed">{{ $tip }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            {{-- ── FILA 2: Fortalezas + Debilidades ── --}}
            @if (!empty($student->strengths) || !empty($student->weaknesses))
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8 pt-8 border-t border-gray-100">

                    @if (!empty($student->strengths))
                        <div class="bg-green-50/60 rounded-2xl p-4">
                            <p class="text-[9px] font-bold uppercase tracking-widest text-green-700 mb-3 flex items-center gap-1.5">
                                <i class="fa-solid fa-circle-check text-green-500"></i> Fortalezas
                            </p>
                            <div class="flex gap-2 flex-wrap">
                                @foreach ($student->strengths as $s)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase
                                             px-3 py-1.5 rounded-full bg-white text-green-700 shadow-sm">
                                        <i class="fa-solid fa-check text-[8px]"></i> {{ $s }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if (!empty($student->weaknesses))
                        <div class="bg-cream/60 rounded-2xl p-4">
                            <p class="text-[9px] font-bold uppercase tracking-widest text-yellow-700 mb-3 flex items-center gap-1.5">
                                <i class="fa-solid fa-arrow-trend-up text-yellow-600"></i> Áreas a mejorar
                            </p>
                            <div class="flex gap-2 flex-wrap">
                                @foreach ($student->weaknesses as $w)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase
                                             px-3 py-1.5 rounded-full bg-white text-yellow-800 shadow-sm">
                                        <i class="fa-solid fa-arrow-up text-[8px]"></i> {{ $w }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            @endif

        </div>

        {{-- ── TÓPICOS + RECURSOS ── --}}
        @php
            $topicsByLevel = [
                'A1' => [
                    'writing' => 'Oraciones simples, presentaciones personales, verbos to be y have',
                    'reading' => 'Textos muy cortos, señales, menús, instrucciones simples',
                    'grammar' => 'Presente simple, artículos, plurales, pronombres personales',
                    'vocabulary' => 'Números, colores, días, saludos, objetos cotidianos',
                    'listening' => 'Palabras aisladas, instrucciones simples, diálogos muy cortos',
                    'speaking' => 'Saludos, presentaciones, respuestas sí/no',
                ],
                'A2' => [
                    'writing' => 'Párrafos cortos, emails simples, descripciones de rutinas',
                    'reading' => 'Textos cortos sobre temas familiares, avisos, mensajes',
                    'grammar' => 'Pasado simple, presente continuo, comparativos, preposiciones',
                    'vocabulary' => 'Familia, trabajo, transporte, tiempo libre, carrera técnica básica',
                    'listening' => 'Diálogos cotidianos, anuncios simples, conversaciones lentas',
                    'speaking' => 'Describir experiencias pasadas, pedir información, expresar preferencias',
                ],
                'B1' => [
                    'writing' => 'Emails formales, resúmenes, textos de opinión cortos',
                    'reading' => 'Artículos de noticias, manuales técnicos simples, blogs',
                    'grammar' => 'Presente perfecto, condicionales, voz pasiva, conectores',
                    'vocabulary' => 'Vocabulario técnico de la carrera, expresiones idiomáticas básicas',
                    'listening' => 'Podcasts cortos, noticias lentas, entrevistas simples',
                    'speaking' => 'Dar opiniones, describir procesos, participar en debates simples',
                ],
                'B2' => [
                    'writing' => 'Reportes técnicos, ensayos argumentativos, resúmenes académicos',
                    'reading' => 'Artículos académicos, papers técnicos, noticias especializadas',
                    'grammar' => 'Condicionales mixtos, subjuntivo, estructuras avanzadas',
                    'vocabulary' => 'Vocabulario académico y técnico avanzado, phrasal verbs',
                    'listening' => 'Conferencias, debates, documentales técnicos',
                    'speaking' => 'Presentaciones técnicas, negociaciones, debates académicos',
                ],
            ];

            $skillIcons = [
                'writing' => 'fa-solid fa-pen-nib',
                'reading' => 'fa-solid fa-book-open',
                'grammar' => 'fa-solid fa-spell-check',
                'vocabulary' => 'fa-solid fa-layer-group',
                'listening' => 'fa-solid fa-headphones',
                'speaking' => 'fa-solid fa-microphone',
            ];

            $skillLabels = [
                'writing' => 'Writing',
                'reading' => 'Reading',
                'grammar' => 'Grammar',
                'vocabulary' => 'Vocabulary',
                'listening' => 'Listening',
                'speaking' => 'Speaking',
            ];

            $lvl = $studyPlan->level ?? ($student->level ?? 'A1');
            $topics = $topicsByLevel[$lvl] ?? $topicsByLevel['A1'];
            $weaknesses = array_map('strtolower', $student->weaknesses ?? []);
            $resources = collect($plan['resources'] ?? [])->groupBy('skill');

            $ordered = array_merge(
                array_filter($topics, fn($k) => in_array($k, $weaknesses), ARRAY_FILTER_USE_KEY),
                array_filter($topics, fn($k) => !in_array($k, $weaknesses), ARRAY_FILTER_USE_KEY),
            );
        @endphp

        <div class="bg-white border border-gray-200 rounded-3xl p-6 mb-4 shadow-lg shadow-blue-900/5">
            <p class="text-[9px] font-bold uppercase tracking-widest text-amalfi mb-5 flex items-center gap-1.5">
                <i class="fa-solid fa-list-check"></i>
                Tópicos a revisar — Nivel {{ $lvl }}
            </p>

            <div class="space-y-4">
                @foreach ($ordered as $skill => $topic)
                    @php
                        $isWeak = in_array($skill, $weaknesses);
                        $skillResources = $resources->get($skill, collect());
                    @endphp

                    <div class="rounded-2xl border-2 overflow-hidden transition-shadow
                        {{ $isWeak ? 'border-yellow-300 bg-cream/40 shadow-sm shadow-yellow-200/40' : 'border-blue-100 bg-blue-50/40' }}">

                        {{-- Tópico header --}}
                        <div class="flex items-start gap-3 p-4">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 shadow-sm
                                {{ $isWeak ? 'bg-yellow-400' : 'bg-amalfi' }}">
                                <i class="{{ $skillIcons[$skill] }} text-xs text-white"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-0.5">
                                    <p class="text-[10px] font-black uppercase tracking-widest
                                       {{ $isWeak ? 'text-yellow-700' : 'text-amalfi' }}">
                                        {{ $skillLabels[$skill] }}
                                    </p>
                                    @if ($isWeak)
                                        <span class="text-[8px] font-bold uppercase px-1.5 py-0.5
                                             rounded-full bg-yellow-400 text-white">
                                            Por mejorar
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-600 leading-relaxed">{{ $topic }}</p>
                            </div>
                        </div>

                        {{-- Recursos del tópico --}}
                        @if ($skillResources->count())
                            <div class="bg-white/70 divide-y divide-gray-100 px-4 py-3 space-y-2 m-2 rounded-xl">
                                @foreach ($skillResources as $resource)
                                    <a href="{{ $resource['url'] }}" target="_blank"
                                        class="group flex items-center justify-between gap-3
                                          hover:bg-blue-50 rounded-xl px-3 py-2 transition-all">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <i class="fa-solid fa-arrow-up-right text-[9px] text-gray-300
                                                  group-hover:text-amalfi transition-colors shrink-0"></i>
                                            <div class="min-w-0">
                                                <p class="text-xs font-semibold text-gray-700
                                                      group-hover:text-amalfi transition-colors truncate">
                                                    {{ $resource['title'] }}
                                                </p>
                                                <p class="text-[10px] text-gray-400 leading-tight truncate">
                                                    {{ $resource['description'] ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                        @if (!empty($resource['level']))
                                            <span class="text-[9px] font-bold px-2 py-0.5 rounded-lg
                                                     bg-amalfi/10 text-amalfi shrink-0">
                                                {{ $resource['level'] }}
                                            </span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>
        </div>

        {{-- Empty state --}}
        @if (empty($resources))
            <div class="bg-white border-2 border-dashed border-amalfi/20 rounded-3xl p-16 text-center mb-6">
                <i class="fa-solid fa-folder-open text-4xl text-gray-200 mb-4 block"></i>
                <p class="font-bold text-gray-400 mb-2">No se pudo cargar el plan.</p>
                <a href="{{ route('portal.placement') }}" class="text-amalfi font-bold hover:underline text-sm">
                    Vuelve a hacer el diagnóstico
                </a>
            </div>
        @endif

        {{-- ── BOTONES FINALES ── --}}
        <div class="flex flex-col sm:flex-row gap-3 mt-6">
            <a href="{{ route('portal.challenges') }}"
                class="group flex-1 flex items-center justify-center gap-2
                  bg-amalfi hover:bg-blue-800 text-white font-black text-sm
                  py-4 rounded-2xl transition-all shadow-lg shadow-amalfi/20
                  hover:-translate-y-0.5">
                <i class="fa-solid fa-bullseye text-sm"></i>
                Ver mis retos
            </a>
            <a href="{{ route('portal.placement') }}"
                class="group flex-1 flex items-center justify-center gap-2
                  bg-white hover:bg-gray-50 text-gray-400 hover:text-gray-600
                  border-2 border-gray-100 hover:border-gray-200
                  font-bold text-sm py-4 rounded-2xl transition-all">
                <i class="fa-solid fa-rotate-right text-sm"></i>
                Repetir diagnóstico
            </a>
        </div>

    </div>

@endsection