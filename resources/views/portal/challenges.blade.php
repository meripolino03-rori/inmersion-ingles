@extends('portal.layout')

@section('content')

<div class="max-w-5xl mx-auto py-8 px-6">

    {{-- HEADER --}}
    <div class="mb-8">
        <h1 class="font-heading font-black text-amalfi text-4xl mb-2">🎯 Mis retos</h1>
        <p class="font-sans text-gray-400 text-base">
            <i class="fa-solid fa-bolt mr-1"></i> Practica tu inglés con ejercicios personalizados según tu nivel
        </p>
    </div>

    {{-- GENERAR NUEVO RETO --}}
    <div class="bg-white border-2 border-amalfi rounded-3xl p-8 mb-8 shadow-sm">
        <h2 class="font-heading font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fa-solid fa-plus-circle text-amalfi"></i> Generar nuevo reto
        </h2>
        
        <form method="POST" action="{{ route('portal.challenges.generate') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Habilidad --}}
                <div class="space-y-2">
                    <label class="text-[11px] font-bold uppercase tracking-widest text-gray-400">Habilidad</label>
                    <select name="skill" class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl p-4 font-semibold text-gray-700 outline-none focus:border-amalfi transition-all">
                        <option value="writing">Writing</option>
                        <option value="reading">Reading</option>
                        <option value="speaking">Speaking</option>
                        <option value="grammar">Grammar</option>
                        <option value="vocabulary">Vocabulary</option>
                    </select>
                </div>

                {{-- Tipo --}}
                <div class="space-y-2">
                    <label class="text-[11px] font-bold uppercase tracking-widest text-gray-400">Tipo de Ejercicio</label>
                    <select name="type" class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl p-4 font-semibold text-gray-700 outline-none focus:border-amalfi transition-all">
                        <option value="writing">Writing challenge</option>
                        <option value="fill_blank">Fill in the blanks</option>
                        <option value="reading_comp">Reading comprehension</option>
                        <option value="true_false">True / False</option>
                        <option value="speaking">Speaking</option>
                    </select>
                </div>

                {{-- Botón --}}
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-amalfi hover:bg-amalfi-dark text-white font-black py-4 rounded-2xl transition-all shadow-lg shadow-amalfi/20">
                        <i class="fa-solid fa-dice mr-2"></i> Generar reto
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- LISTA DE RETOS --}}
    <div class="space-y-4">
        @forelse($challenges as $challenge)
            <div class="bg-white border-2 border-gray-100 rounded-3xl p-6 flex items-center gap-6 hover:border-amalfi/20 transition-all">
                {{-- Icono de habilidad --}}
                <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center text-3xl shrink-0">
                    <i class="{{ match ($challenge->skill) {
                        'writing' => 'fa-solid fa-pen-nib',
                        'reading' => 'fa-solid fa-book-open',
                        'speaking' => 'fa-solid fa-microphone',
                        'grammar' => 'fa-solid fa-spell-check',
                        'vocabulary' => 'fa-solid fa-layer-group',
                        default => 'fa-solid fa-bullseye',
                    } }} text-amalfi"></i>
                </div>

                {{-- Info --}}
                <div class="flex-1">
                    <div class="font-bold text-gray-800 text-sm uppercase tracking-wide">
                        {{ strtoupper($challenge->skill) }} — {{ strtoupper($challenge->level) }}
                    </div>
                    <div class="text-xs text-gray-400 mt-0.5 font-medium">
                        <i class="fa-regular fa-clock mr-1"></i> {{ $challenge->created_at->diffForHumans() }}
                    </div>
                </div>

                {{-- Status --}}
                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest 
                    {{ match ($challenge->status) {
                        'pending' => 'bg-amber-50 text-amber-600',
                        'submitted' => 'bg-blue-50 text-blue-600',
                        'reviewed' => 'bg-green-50 text-green-600',
                        default => 'bg-gray-100 text-gray-600',
                    } }}">
                    {{ match ($challenge->status) {
                        'pending' => 'Pendiente',
                        'submitted' => 'Enviado',
                        'reviewed' => 'Revisado',
                        default => $challenge->status,
                    } }}
                </span>

                {{-- Botón --}}
                <a href="{{ route('portal.challenges.show', $challenge->id) }}" 
                   class="px-8 py-4 bg-gray-50 hover:bg-amalfi hover:text-white text-gray-700 font-black text-xs uppercase tracking-widest rounded-2xl transition-all">
                    {{ $challenge->status === 'pending' ? 'Resolver' : 'Ver' }} →
                </a>
            </div>

        @empty
            <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl p-16 text-center text-gray-400">
                <i class="fa-solid fa-list-check text-4xl mb-4 text-gray-300"></i>
                <p class="font-bold">No tienes retos aún.</p>
                <p class="text-sm">¡Genera tu primer reto usando el formulario de arriba!</p>
            </div>
        @endforelse
    </div>

    {{-- BOTÓN EXTRA --}}
    <div class="mt-10">
        <a href="{{ route('portal.study-plan') }}" class="inline-flex items-center gap-2 text-amalfi font-bold hover:underline text-sm">
            <i class="fa-solid fa-book-open"></i> Ver mi plan de estudio
        </a>
    </div>

</div>

@endsection