@extends('portal.layout')

@section('content')

<div class="py-6">

    {{-- ── ENCABEZADO ── --}}
    <div class="mb-8">
        <h1 class="font-heading font-black text-amalfi text-2xl tracking-tight mb-3">
            Prácticas de refuerzo
        </h1>
        <div class="flex items-center gap-3 flex-wrap">
            <span class="flex items-center gap-1.5 text-xs font-sans font-bold px-3 py-1 rounded-full bg-blue-50 text-amalfi">
                <i class="fa-regular fa-calendar"></i> {{ $student->cycle->name }}
            </span>
            <span class="text-gray-200">·</span>
            <span class="text-sm font-sans text-gray-400">
                Actividades externas recomendadas por el docente
            </span>
        </div>
    </div>

    {{-- ── CARDS POR UNIDAD ── --}}
    @forelse($practices as $unitId => $unitPractices)
        @php $unit = $unitPractices->first()->unit; @endphp

        <div class="bg-white border-2 border-amalfi rounded-2xl overflow-hidden mb-5 transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">

            {{-- Header unidad --}}
            <div class="bg-blue-50/50 px-5 py-4 border-b border-blue-100 flex items-center gap-3">
                <div class="w-7 h-7 rounded-full bg-amalfi flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-layer-group text-white text-[10px]"></i>
                </div>
                <h2 class="font-heading font-bold text-gray-900 text-base leading-tight">
                    {{ $unit->name }}
                </h2>
                <span class="ml-auto text-[10px] font-sans font-bold px-2.5 py-1 rounded-full bg-amalfi/10 text-amalfi">
                    {{ $unitPractices->count() }} {{ $unitPractices->count() === 1 ? 'actividad' : 'actividades' }}
                </span>
            </div>

            {{-- Lista de prácticas --}}
            <div class="divide-y divide-blue-50">
                @foreach($unitPractices as $practice)
                    @php
                        [$platformLabel, $platformBadge, $platformIcon] = match($practice->platform) {
                            'quizizz' => ['Quizizz', 'bg-cream text-yellow-800',      'fa-solid fa-gamepad'],
                            'kahoot'  => ['Kahoot',  'bg-red-50 text-red-600',        'fa-solid fa-bolt'],
                            default   => ['Otro',    'bg-gray-100 text-gray-500',     'fa-solid fa-link'],
                        };
                    @endphp

                    <div class="flex items-center gap-4 px-5 py-4 hover:bg-blue-50/30 transition-colors group">

                        {{-- Ícono plataforma --}}
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0
                            {{ $practice->platform === 'quizizz' ? 'bg-cream' : ($practice->platform === 'kahoot' ? 'bg-red-50' : 'bg-gray-100') }}">
                            <i class="{{ $platformIcon }} text-sm
                                {{ $practice->platform === 'quizizz' ? 'text-yellow-700' : ($practice->platform === 'kahoot' ? 'text-red-500' : 'text-gray-400') }}"></i>
                        </div>

                        {{-- Título + plataforma --}}
                        <div class="flex-1 min-w-0">
                            <p class="font-sans font-medium text-gray-800 text-sm truncate group-hover:text-amalfi transition-colors">
                                {{ $practice->title }}
                            </p>
                            <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full mt-1 inline-block {{ $platformBadge }}">
                                {{ $platformLabel }}
                            </span>
                        </div>

                        {{-- Botón acceso --}}
                        <a href="{{ $practice->url }}"
                           target="_blank"
                           class="shrink-0 flex items-center gap-1.5 text-xs font-sans font-bold px-4 py-2 rounded-xl bg-amalfi text-white hover:bg-amalfi-dark transition-colors">
                            Abrir <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>

                    </div>
                @endforeach
            </div>

        </div>

    @empty
        <div class="text-center py-20 bg-white rounded-2xl border-2 border-amalfi/20">
            <i class="fa-regular fa-folder-open text-5xl text-amalfi opacity-10 mb-4 block"></i>
            <p class="font-heading font-bold text-gray-400 text-base mb-1">Sin prácticas aún</p>
            <p class="font-sans text-gray-300 text-sm italic">
                El docente aún no ha agregado prácticas para este ciclo.
            </p>
        </div>
    @endforelse

</div>

@endsection