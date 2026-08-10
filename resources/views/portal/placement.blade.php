@extends('portal.layout')

@section('content')
    <form id="quizForm" method="POST" action="{{ route('portal.placement.submit') }}">
        @csrf
        @foreach ($questions as $i => $q)
            <input type="hidden" name="questions[{{ $i }}]" value="{{ $q['question'] }}">
            <input type="hidden" name="answers[{{ $i }}]" id="ans-{{ $i }}">
        @endforeach
    </form>

    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="flex items-center gap-4 mb-6 p-5 bg-white border-2 border-amalfi rounded-2xl">
            <div class="w-12 h-12 rounded-full bg-amalfi flex items-center justify-center text-xl text-white">
                <i class="fa-solid fa-robot text-sm"></i>
            </div>
            <div class="flex-1">
                <div class="font-bold text-gray-900">English AI Tutor</div>
                <div class="text-xs text-gray-500 mt-0.5">Diagnóstico personalizado · {{ count($questions) }} preguntas
                </div>
            </div>
            <div class="text-right text-xs text-gray-500">
                {{ $student->school->name ?? 'Tu carrera' }}<br>
                Nivel: <strong class="text-amalfi">{{ $student->level ?? 'Por determinar' }}</strong>
            </div>
        </div>

        <div class="mb-6">
            <div class="flex justify-between text-xs text-gray-500 mb-2">
                <span id="progressLabel">Listo para comenzar</span>
                <span id="progressCount">0 / {{ count($questions) }}</span>
            </div>
            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                <div id="progressFill"
                    class="h-full bg-amalfi transition-all duration-500 w-0"></div>
            </div>
        </div>

        <div class="bg-gray-50 border-2 border-amalfi rounded-2xl overflow-hidden">
            <div id="chatMessages" class="p-6 min-h-[420px] max-h-[540px] overflow-y-auto flex flex-col gap-6">
                <div id="welcomeMsg" class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-amalfi flex items-center justify-center text-white text-sm">
                        <i class="fa-solid fa-robot text-xs"></i>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-r-2xl rounded-bl-sm p-4 max-w-[85%] text-sm leading-relaxed text-gray-800 shadow-sm">
                        Hello! I'm your <strong>English AI Tutor</strong>.<br><br>
                        I'll evaluate your English level with <strong>{{ count($questions) }} questions</strong>.<br><br>
                        Ready?
                        <button type="button" onclick="startQuiz()"
                            class="mt-4 flex items-center gap-2 px-4 py-2 border-2 border-amalfi text-amalfi font-semibold rounded-lg hover:bg-blue-50 transition">
                            <span class="w-6 h-6 rounded-full bg-amalfi text-white flex items-center justify-center text-xs">
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </span>
                            Yes, let's start!
                        </button>
                    </div>
                </div>
            </div>

            <div id="inputArea" class="hidden border-t border-gray-200 p-4 bg-white">
                <div class="flex gap-2 items-end">
                    <textarea id="chatInput" rows="1" oninput="autoResize(this)" onkeydown="handleKeydown(event)"
                        class="flex-1 bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-amalfi outline-none resize-none min-h-[44px]"
                        placeholder="Write your answer..."></textarea>
                    <button type="button" id="btnMic" onclick="toggleRecording()"
                        class="w-11 h-11 rounded-xl bg-amalfi text-white flex items-center justify-center hover:bg-blue-800 transition">
                        <i class="fa-solid fa-microphone text-sm"></i>
                    </button>
                    <button type="button" id="btnSend" onclick="sendAnswer()"
                        class="w-11 h-11 rounded-xl bg-amalfi text-white flex items-center justify-center hover:bg-blue-800 transition">
                        <i class="fa-solid fa-paper-plane text-sm"></i>
                    </button>
                </div>
                <div id="micStatus" class="text-xs text-gray-400 mt-2 text-center"></div>
            </div>
        </div>
    </div>

    <script>
        const questions = @json($questions);
        const total = questions.length;
        let current = -1;

        function scrollDown() {
            const msgs = document.getElementById('chatMessages');
            msgs.scrollTop = msgs.scrollHeight;
        }

        function appendMessage(text, isUser = false) {
            const msgs = document.getElementById('chatMessages');
            const div = document.createElement('div');
            div.className = `flex items-start gap-3 ${isUser ? 'justify-end' : ''}`;
            div.innerHTML = `
            ${!isUser ? '<div class="w-8 h-8 rounded-full bg-amalfi flex items-center justify-center text-white text-xs"><i class="fa-solid fa-robot text-xs"></i></div>' : ''}
            <div class="${isUser ? 'bg-amalfi text-white' : 'bg-white border border-gray-200'} p-4 rounded-2xl shadow-sm text-sm max-w-[85%]">
                ${text}
            </div>
        `;
            msgs.appendChild(div);
            scrollDown();
        }

        async function startQuiz() {
            document.getElementById('welcomeMsg').remove();
            appendMessage("Yes, let's start!", true);
            showNextQuestion();
        }

        function showNextQuestion() {
            current++;
            if (current >= total) {
                finishQuiz();
                return;
            }

            document.getElementById('btnMic').disabled = false;
            document.getElementById('btnSend').disabled = false;

            const q = questions[current];
            document.getElementById('progressLabel').textContent = `Pregunta ${current + 1} de ${total}`;
            document.getElementById('progressCount').textContent = `${current + 1} / ${total}`;
            document.getElementById('progressFill').style.width = `${((current + 1) / total) * 100}%`;

            let html = `<strong>${q.skill.toUpperCase()}</strong><br>`;

            if (q.skill === 'reading' && q.text) {
                html += `
                <div class="mt-3 p-3 bg-blue-50 border border-blue-100 rounded-xl">
                    <div class="text-xs text-amalfi font-bold mb-1 flex items-center gap-1">
                        <i class="fa-solid fa-book-open text-[10px]"></i> Reading Text
                    </div>
                    <div class="text-gray-700 text-sm leading-relaxed">${q.text}</div>
                </div>
            `;
            }

            if (q.skill === 'listening' && q.audio_text) {
                html += `
                <div class="mt-3 p-3 bg-cream border border-yellow-200 rounded-xl">
                    <div class="text-xs text-yellow-700 font-bold mb-1 flex items-center gap-1">
                        <i class="fa-solid fa-headphones text-[10px]"></i> Listening Text
                    </div>
                    <div class="text-gray-700 text-sm leading-relaxed">${q.audio_text}</div>
                </div>
            `;
            }

            html += `<div class="mt-3 text-gray-800">${q.question}</div>`;

            if (q.instructions) {
                html += `
                <p class="text-xs text-gray-400 mt-2 italic flex items-center gap-1">
                    <i class="fa-solid fa-thumbtack text-[9px]"></i> ${q.instructions}
                </p>
            `;
            }

            if (q.options) {
                html += `<div class="mt-3 flex flex-col gap-2">`;
                q.options.forEach((option, index) => {
                    html += `
                    <button
                        onclick="selectOption('${option.replace(/'/g, "\\'")}')"
                        class="option-btn text-left border border-gray-200 rounded-xl px-3 py-2
                               hover:bg-blue-50 hover:border-amalfi transition text-sm">
                        <span class="font-bold text-amalfi mr-2">${String.fromCharCode(65 + index)}.</span>
                        ${option}
                    </button>
                `;
                });
                html += `</div>`;
            }

            appendMessage(html);

            const inputArea = document.getElementById('inputArea');
            const btnMic = document.getElementById('btnMic');
            const btnSend = document.getElementById('btnSend');
            const chatInput = document.getElementById('chatInput');

            inputArea.classList.remove('hidden');

            if (q.skill === 'speaking') {
                chatInput.classList.add('hidden');
                btnSend.classList.add('hidden');
                btnMic.classList.remove('hidden');
                document.getElementById('micStatus').textContent = 'Presiona el micrófono para responder';
            } else if (q.options) {
                inputArea.classList.add('hidden');
            } else {
                chatInput.classList.remove('hidden');
                btnSend.classList.remove('hidden');
                btnMic.classList.add('hidden');
                chatInput.value = '';
                chatInput.focus();
            }
        }

        function selectOption(value) {
            document.querySelectorAll('.option-btn').forEach(btn => btn.disabled = true);
            appendMessage(value, true);
            document.getElementById(`ans-${current}`).value = value;
            setTimeout(() => showNextQuestion(), 400);
        }

        function sendAnswer() {
            const input = document.getElementById('chatInput');
            if (input.value.trim().length < 3) return;

            document.getElementById('btnSend').disabled = true;
            document.getElementById(`ans-${current}`).value = input.value.trim();
            appendMessage(input.value.trim(), true);
            input.value = '';
            input.style.height = 'auto';

            document.getElementById('inputArea').classList.add('hidden');
            setTimeout(() => showNextQuestion(), 400);
        }

        function handleKeydown(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendAnswer();
            }
        }

        function autoResize(el) {
            el.style.height = 'auto';
            el.style.height = el.scrollHeight + 'px';
        }

        let recognition = null;
        let isRecording = false;
        let finalTranscript = '';
        let silenceTimer = null;

        function toggleRecording() {
            if (!isRecording) startRecording();
            else stopRecording();
        }

        function startRecording() {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            if (!SpeechRecognition) {
                document.getElementById('micStatus').textContent = 'Usa Chrome o Edge para el micrófono';
                return;
            }

            recognition = new SpeechRecognition();
            recognition.lang = 'en-US';
            recognition.continuous = true;
            recognition.interimResults = true;
            finalTranscript = '';

            recognition.onstart = () => {
                isRecording = true;
                resetSilenceTimer();

                const btn = document.getElementById('btnMic');
                btn.innerHTML = '<i class="fa-solid fa-stop text-sm"></i>';
                btn.classList.add('bg-red-500');
                btn.classList.remove('bg-amalfi');
                document.getElementById('micStatus').textContent = 'Grabando... habla en inglés';
            };

            recognition.onresult = (e) => {
                resetSilenceTimer();
                let interim = '';
                for (let i = e.resultIndex; i < e.results.length; i++) {
                    if (e.results[i].isFinal) finalTranscript += e.results[i][0].transcript + ' ';
                    else interim += e.results[i][0].transcript;
                }
                document.getElementById('micStatus').textContent =
                    'Grabando: ' + (finalTranscript + interim).trim();
            };

            recognition.onerror = (e) => {
                document.getElementById('micStatus').textContent = 'Error: ' + e.error;
                stopRecording();
            };

            recognition.onend = () => {
                if (isRecording) recognition.start();
            };

            recognition.start();
        }

        function resetSilenceTimer() {
            if (silenceTimer) clearTimeout(silenceTimer);
            silenceTimer = setTimeout(() => {
                if (isRecording) stopRecording();
            }, 10000);
        }

        function stopRecording() {
            if (silenceTimer) {
                clearTimeout(silenceTimer);
                silenceTimer = null;
            }
            if (recognition) {
                recognition.onend = null;
                recognition.stop();
            }

            isRecording = false;

            const btn = document.getElementById('btnMic');
            btn.innerHTML = '<i class="fa-solid fa-microphone text-sm"></i>';
            btn.classList.remove('bg-red-500');
            btn.classList.add('bg-amalfi');

            if (finalTranscript.trim()) {
                document.getElementById(`ans-${current}`).value = finalTranscript.trim();
                document.getElementById('micStatus').textContent = 'Respuesta registrada';
                appendMessage(
                    '<i class="fa-solid fa-microphone text-[10px] mr-1"></i>' + finalTranscript.trim(),
                    true
                );
                setTimeout(() => {
                    document.getElementById('inputArea').classList.add('hidden');
                    showNextQuestion();
                }, 700);
            } else {
                document.getElementById('micStatus').textContent = 'No se detectó voz. Intenta de nuevo.';
            }
        }

        function speakText(text) {
            if (speechSynthesis.speaking) speechSynthesis.cancel();
            const u = new SpeechSynthesisUtterance(text);
            u.lang = 'en-US';
            u.rate = 0.85;
            speechSynthesis.speak(u);
        }

        async function finishQuiz() {
            document.getElementById('inputArea').classList.add('hidden');
            appendMessage(`
            <div class="font-bold mb-2 flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-amalfi"></i>
                Excellent! You've completed all ${total} questions.
            </div>
            <p class="text-gray-500 text-sm">Analyzing your responses and generating your study plan...</p>
            <p class="text-gray-400 text-xs mt-2 italic">Please wait a moment...</p>
        `);
            setTimeout(() => {
                document.getElementById('quizForm').submit();
            }, 2000);
        }
    </script>
@endsection