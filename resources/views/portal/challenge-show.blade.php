@extends('portal.layout')

@section('content')
    @php
        $content = is_array($challenge->content) ? $challenge->content : json_decode($challenge->content, true) ?? [];
    @endphp

    <div class="max-w-3xl mx-auto py-8 px-6">

        {{-- HEADER --}}
        <div class="mb-8">
            <h1 class="font-heading font-black text-amalfi text-4xl mb-2">
                <i class="{{ match ($challenge->skill) {
                    'writing'    => 'fa-solid fa-pen-nib',
                    'reading'    => 'fa-solid fa-book-open',
                    'speaking'   => 'fa-solid fa-microphone',
                    'grammar'    => 'fa-solid fa-spell-check',
                    'vocabulary' => 'fa-solid fa-layer-group',
                    default      => 'fa-solid fa-bullseye',
                } }} mr-3"></i>
                {{ strtoupper($challenge->skill) }} — {{ strtoupper($challenge->level) }}
            </h1>
            <p class="font-sans text-gray-400 text-base">
                <i class="fa-solid fa-tag mr-1"></i> {{ ucfirst($challenge->type) }} challenge
            </p>
        </div>

        {{-- CARD PRINCIPAL --}}
        <div class="bg-white border-2 border-gray-100 rounded-3xl p-8 mb-6 shadow-sm">

            <h2 class="font-heading font-bold text-gray-800 text-xl mb-4">
                {{ $content['title'] ?? 'Challenge' }}
            </h2>

            @if (!empty($content['instructions']))
                <p class="text-gray-400 text-sm mb-6 leading-relaxed">
                    <i class="fa-solid fa-circle-info mr-1 text-amalfi"></i> {{ $content['instructions'] }}
                </p>
            @endif

            @if (!empty($content['content']))
                <div class="bg-gray-50 border-2 border-gray-100 rounded-2xl p-5 mb-6 text-sm leading-relaxed text-gray-700">
                    @if (is_array($content['content']))
                        @foreach ($content['content'] as $item)
                            <div class="mb-2">
                                <i class="fa-solid fa-chevron-right text-amalfi mr-1 text-xs"></i> {{ $item }}
                            </div>
                        @endforeach
                    @else
                        {{ $content['content'] }}
                    @endif
                </div>
            @endif

            @if (!empty($content['tips']))
                <div class="mb-6">
                    <div class="text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-3">
                        <i class="fa-solid fa-lightbulb mr-1 text-amber-400"></i> Tips
                    </div>
                    @foreach ($content['tips'] as $tip)
                        <div class="text-sm text-gray-400 mb-2">
                            <i class="fa-solid fa-arrow-right mr-1 text-xs"></i> {{ $tip }}
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- FORMULARIO --}}
            @if ($challenge->status === 'pending')
                <form method="POST" action="{{ route('portal.challenges.submit', $challenge->id) }}">
                    @csrf

                    @if ($challenge->type === 'speaking')
                        <div class="mb-6">
                            <p class="text-gray-400 text-sm mb-4">
                                <i class="fa-solid fa-microphone mr-1 text-amalfi"></i>
                                Presiona el botón y habla en inglés. Tu voz será convertida a texto.
                            </p>
                            <div class="flex gap-4 items-center mb-4">
                                <button type="button" id="btnRecord"
                                    class="px-6 py-3 bg-amalfi hover:bg-amalfi-dark text-white font-black text-sm rounded-2xl transition-all shadow-lg shadow-amalfi/20">
                                    <i class="fa-solid fa-microphone mr-2"></i> Iniciar grabación
                                </button>
                                <span id="micStatus" class="text-sm text-gray-400"></span>
                            </div>
                            <div id="transcriptBox"
                                class="hidden mt-3 bg-gray-50 border-2 border-gray-100 rounded-2xl p-4 text-sm text-gray-700 min-h-[60px]">
                            </div>
                            <input type="hidden" name="transcript" id="transcriptInput">
                            <input type="hidden" name="response" value="speaking_audio">
                        </div>

                        <script>
                            const btn = document.getElementById('btnRecord');
                            const status = document.getElementById('micStatus');
                            const box = document.getElementById('transcriptBox');
                            const input = document.getElementById('transcriptInput');
                            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                            let isRec = false, recognition, finalT = '';

                            if (!SpeechRecognition) {
                                btn.disabled = true;
                                status.textContent = '⚠️ Usa Chrome o Edge para grabar.';
                            } else {
                                btn.addEventListener('click', () => {
                                    if (!isRec) {
                                        recognition = new SpeechRecognition();
                                        recognition.lang = 'en-US';
                                        recognition.continuous = true;
                                        recognition.interimResults = true;
                                        finalT = '';
                                        recognition.onresult = e => {
                                            let interim = '';
                                            for (let i = e.resultIndex; i < e.results.length; i++) {
                                                if (e.results[i].isFinal) finalT += e.results[i][0].transcript + ' ';
                                                else interim += e.results[i][0].transcript;
                                            }
                                            box.textContent = finalT + interim;
                                            input.value = finalT;
                                        };
                                        recognition.start();
                                        isRec = true;
                                        btn.innerHTML = '<i class="fa-solid fa-stop mr-2"></i> Detener';
                                        btn.classList.replace('bg-amalfi', 'bg-green-500');
                                        status.innerHTML = '<i class="fa-solid fa-circle text-red-500 animate-pulse mr-1"></i> Grabando...';
                                        box.classList.remove('hidden');
                                    } else {
                                        recognition.stop();
                                        isRec = false;
                                        btn.innerHTML = '<i class="fa-solid fa-microphone mr-2"></i> Volver a grabar';
                                        btn.classList.replace('bg-green-500', 'bg-amalfi');
                                        status.innerHTML = '<i class="fa-solid fa-circle-check text-green-500 mr-1"></i> Listo';
                                    }
                                });
                            }
                        </script>

                    @else
                        <div class="mb-6">
                            <label class="text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-2 block">
                                <i class="fa-solid fa-pen mr-1"></i> Tu respuesta
                            </label>
                            <textarea name="response" rows="4"
                                placeholder="Write your answer here in English..."
                                class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl p-4 text-sm text-gray-700 outline-none focus:border-amalfi transition-all resize-none"
                                required></textarea>
                        </div>
                    @endif

                    <div class="flex gap-3 mt-6">
                        <a href="{{ route('portal.challenges') }}"
                            class="px-6 py-3 bg-gray-50 hover:bg-gray-100 text-gray-600 font-black text-xs uppercase tracking-widest rounded-2xl transition-all">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Volver
                        </a>
                        <button type="submit"
                            class="flex-1 py-3 bg-amalfi hover:bg-amalfi-dark text-white font-black text-sm rounded-2xl transition-all shadow-lg shadow-amalfi/20">
                            <i class="fa-solid fa-paper-plane mr-2"></i> Enviar respuesta
                        </button>
                    </div>
                </form>

            {{-- FEEDBACK --}}
            @else
                @php
                    $feedback = session('feedback') ?? [];
                    $aiScore  = $challenge->ai_score;
                @endphp

                {{-- Resultado --}}
                @if ($aiScore >= 14)
                    <div class="flex items-center gap-3 p-4 bg-green-50 border-2 border-green-200 rounded-2xl mb-6">
                        <i class="fa-solid fa-circle-check text-green-500 text-2xl"></i>
                        <div>
                            <div class="font-black text-green-700 text-sm">¡Bien hecho!</div>
                            <div class="text-green-600 text-xs">Tu respuesta es correcta.</div>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-3 p-4 bg-red-50 border-2 border-red-200 rounded-2xl mb-6">
                        <i class="fa-solid fa-circle-exclamation text-red-400 text-2xl"></i>
                        <div>
                            <div class="font-black text-red-600 text-sm">Necesitas mejorar</div>
                            <div class="text-red-400 text-xs">Revisa el feedback de la IA.</div>
                        </div>
                    </div>
                @endif

                {{-- Respuesta del estudiante --}}
                @if ($challenge->speech_transcript)
                    <div class="bg-gray-50 border-2 border-gray-100 rounded-2xl p-4 mb-4">
                        <div class="text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-2">
                            <i class="fa-solid fa-microphone mr-1"></i> Lo que dijiste
                        </div>
                        <p class="italic text-gray-600 text-sm">"{{ $challenge->speech_transcript }}"</p>
                    </div>
                @elseif($challenge->student_response && $challenge->student_response !== 'speaking_audio')
                    <div class="bg-gray-50 border-2 border-gray-100 rounded-2xl p-4 mb-4">
                        <div class="text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-2">
                            <i class="fa-solid fa-pen mr-1"></i> Tu respuesta
                        </div>
                        <p class="text-gray-600 text-sm">{{ $challenge->student_response }}</p>
                    </div>
                @endif

                {{-- Feedback IA --}}
                <div class="bg-gray-50 border-2 border-gray-100 rounded-2xl p-6 mb-4">
                    <div class="text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-4">
                        <i class="fa-solid fa-robot mr-1 text-amalfi"></i> Feedback de la IA
                    </div>

                    @if ($challenge->ai_feedback)
                        <p class="text-sm text-gray-700 leading-relaxed mb-4">{{ $challenge->ai_feedback }}</p>
                    @endif

                    @if (!empty($feedback['corrections']))
                        <div class="mb-4">
                            <div class="text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-2">
                                <i class="fa-solid fa-triangle-exclamation mr-1 text-amber-400"></i> Correcciones
                            </div>
                            @foreach ($feedback['corrections'] as $correction)
                                <div class="text-sm text-amber-600 mb-2">
                                    <i class="fa-solid fa-arrow-right mr-1 text-xs"></i> {{ $correction }}
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if (!empty($feedback['tip']))
                        <div class="p-4 bg-blue-50 border-2 border-blue-100 rounded-2xl">
                            <div class="text-[11px] font-bold uppercase tracking-widest text-blue-400 mb-1">
                                <i class="fa-solid fa-lightbulb mr-1 text-amber-400"></i> Tip
                            </div>
                            <p class="text-sm text-blue-600">{{ $feedback['tip'] }}</p>
                        </div>
                    @endif
                </div>

                <div class="flex gap-3 mt-6">
                    <a href="{{ route('portal.challenges') }}"
                        class="px-6 py-3 bg-gray-50 hover:bg-gray-100 text-gray-600 font-black text-xs uppercase tracking-widest rounded-2xl transition-all">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Volver a retos
                    </a>
                    <a href="{{ route('portal.challenges') }}"
                        class="flex-1 text-center py-3 bg-amalfi hover:bg-amalfi-dark text-white font-black text-sm rounded-2xl transition-all shadow-lg shadow-amalfi/20">
                        <i class="fa-solid fa-bullseye mr-2"></i> Nuevo reto
                    </a>
                </div>
            @endif

        </div>
    </div>
@endsection
