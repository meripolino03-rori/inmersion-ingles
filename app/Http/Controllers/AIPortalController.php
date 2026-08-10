<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\PlacementExam;
use App\Models\StudyPlan;
use App\Models\Challenge;
use App\Services\GroqService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AIPortalController extends Controller
{
    public function __construct(private GroqService $groq) {}

    private function getStudent(): Student
    {
        return Student::with(['user', 'cycle', 'school'])
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }


    public function generateChallenge(Request $request)
    {
        $student  = $this->getStudent();
        $skill    = $request->input('skill', 'writing');
        $type     = $request->input('type', 'writing');
        $career   = $student->school->name ?? 'Ingeniería de Sistemas';

        $studyPlan = StudyPlan::where('student_id', $student->id)
            ->where('active', true)
            ->latest()
            ->first();

        $raw     = $this->groq->generateChallenge($skill, $type, $student->level ?? 'A1', $career);
        $content = json_decode($raw, true);

        $challenge = Challenge::create([
            'student_id'    => $student->id,
            'study_plan_id' => $studyPlan?->id ?? 1,
            'skill'         => $skill,
            'type'          => $type,
            'level'         => $student->level ?? 'A1',
            'content'       => json_encode($content),
            'status'        => 'pending',
        ]);

        return redirect()->route('portal.challenges.show', $challenge->id);
    }

    // Examen diagnóstico
    public function placement()
    {
        $student = $this->getStudent();

        $lastExam = PlacementExam::where('student_id', $student->id)
            ->latest()
            ->first();

        $studyPlan = StudyPlan::where('student_id', $student->id)
            ->where('active', true)
            ->latest()
            ->first();

        if (request()->has('start')) {
            $career = $student->school->name ?? 'Ingeniería de Sistemas';
            // 1. Obtenemos el resultado crudo de la IA
            $result = $this->groq->generatePlacementExam($career);
            // 2. Limpiamos markdown y espacios
            $clean = trim(preg_replace('/```json|```/i', '', $result));
            // 3. Extraemos JSON correctamente buscando el bloque completo
            //    Str::between rompía el JSON anidado, usamos regex en su lugar
            preg_match('/\{.*\}/s', $clean, $matches);
            $jsonString = $matches[0] ?? '{}';
            // 4. Decodificamos
            $data = json_decode($jsonString, true);
            // 5. Validamos
            $questions = $data['questions'] ?? [];

            if (empty($questions)) {
                logger()->error('Groq JSON vacío o inválido', [
                    'raw'     => $result,
                    'cleaned' => $clean,
                    'parsed'  => $data,
                ]);
            }
            return view('portal.placement', compact('student', 'questions', 'lastExam'));
        }
        return view('portal.placement-welcome', compact('student', 'lastExam', 'studyPlan'));
    }

    // Procesar respuestas del examen
    public function submitPlacement(Request $request)
    {
        $student   = $this->getStudent();
        $answers   = $request->input('answers', []);
        $questions = $request->input('questions', []);
        $career    = $student->school->name ?? 'Ingeniería de Sistemas';

        $raw      = $this->groq->analyzePlacementExam($questions, $answers, $career);
        $clean    = trim(preg_replace('/```json|```/', '', $raw));
        $analysis = json_decode($clean, true);

        $exam = PlacementExam::create([
            'student_id'     => $student->id,
            'attempt'        => PlacementExam::where('student_id', $student->id)->count() + 1,
            'answers'        => $answers,
            'assigned_level' => $analysis['level']     ?? 'A1',
            'strengths'      => $analysis['strengths'] ?? [],
            'weaknesses'     => $analysis['weaknesses'] ?? [],
            'ai_analysis'    => $analysis['analysis']  ?? '',
            'taken_at'       => now(),
        ]);

        $student->update([
            'level'      => $analysis['level']      ?? 'A1',
            'strengths'  => $analysis['strengths']  ?? [],
            'weaknesses' => $analysis['weaknesses'] ?? [],
        ]);

        // Generar plan
        $planRaw = $this->groq->generateStudyPlan(
            $analysis['level']      ?? 'A1',
            $analysis['weaknesses'] ?? [],
            $career
        );

        // CORRECCIÓN AQUÍ: limpiar y validar el JSON
        $planClean = trim(preg_replace('/```json|```/', '', $planRaw));
        $plan      = json_decode($planClean, true);

        // AÑADE ESTO: Validación estricta de JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            logger()->error('Error de formato JSON en el Plan de Estudios: ' . $planRaw);
            $plan = null; // Forzamos a null para que entre al "if" de abajo
        }

        // Si falla usar plan por defecto
        if (!$plan || empty($plan['resources'])) {
            $plan = [
                'level'       => $analysis['level'] ?? 'A1',
                'career'      => $career,
                'focus_areas' => ['Grammar', 'Vocabulary', 'Reading'],
                'study_tips'  => [
                    'Practica 15-20 minutos diarios de inglés',
                    'Lee artículos cortos en inglés sobre tu carrera',
                ],
                'resources' => [
                    ['title' => 'BBC Learning English',       'url' => 'https://www.bbc.co.uk/learningenglish',              'type' => 'video',       'category' => 'Videos',    'description' => 'Lecciones gratuitas de inglés',          'level' => 'A1'],
                    ['title' => 'Duolingo',                   'url' => 'https://www.duolingo.com',                           'type' => 'interactive', 'category' => 'Práctica',  'description' => 'Práctica diaria gamificada',             'level' => 'A1'],
                    ['title' => 'VOA Learning English',       'url' => 'https://learningenglish.voanews.com',                'type' => 'audio',       'category' => 'Listening', 'description' => 'Noticias en inglés simplificado',        'level' => 'A2'],
                    ['title' => 'Breaking News English',      'url' => 'https://breakingnewsenglish.com',                    'type' => 'article',     'category' => 'Artículos', 'description' => 'Lecturas con ejercicios gratis',         'level' => 'A2'],
                    ['title' => 'British Council',            'url' => 'https://learnenglish.britishcouncil.org',            'type' => 'interactive', 'category' => 'Práctica',  'description' => 'Cursos gratuitos British Council',       'level' => 'A2'],
                    ['title' => 'Cambridge English',          'url' => 'https://www.cambridgeenglish.org/learning-english',  'type' => 'interactive', 'category' => 'Práctica',  'description' => 'Recursos oficiales Cambridge',           'level' => 'B1'],
                    ['title' => 'Elllo Listening Lessons',    'url' => 'https://www.elllo.org',                              'type' => 'audio',       'category' => 'Listening', 'description' => 'Listening con hablantes nativos',        'level' => 'A2'],
                    ['title' => 'ESL Fast Reading',           'url' => 'https://www.eslfast.com',                            'type' => 'article',     'category' => 'Artículos', 'description' => 'Lecturas y diálogos gratis',             'level' => 'A1'],
                    ['title' => 'TechCrunch (simplified)',    'url' => 'https://techcrunch.com',                             'type' => 'news',        'category' => 'Noticias',  'description' => 'Noticias de tecnología en inglés',       'level' => 'B1'],
                    ['title' => 'Simple English Wikipedia',   'url' => 'https://simple.wikipedia.org',                       'type' => 'article',     'category' => 'Artículos', 'description' => 'Artículos en inglés simplificado',       'level' => 'A2'],
                ]
            ];
        }

        // Desactivar plan anterior
        StudyPlan::where('student_id', $student->id)
            ->where('active', true)
            ->update(['active' => false]);

        StudyPlan::create([
            'student_id'        => $student->id,
            'placement_exam_id' => $exam->id,
            'level'             => $analysis['level'] ?? 'A1',
            'plan'              => $plan,
            'active'            => true,
        ]);

        return view('portal.placement-results', [
            'student'   => $student,
            'level'     => $analysis['level']      ?? 'A1',
            'strengths' => $analysis['strengths']  ?? [],
            'weaknesses' => $analysis['weaknesses'] ?? [],
            'analysis'  => $analysis['analysis']   ?? '',
        ]);
    }

    // Plan de estudios
    public function studyPlan()
    {
        $student   = $this->getStudent();
        $studyPlan = StudyPlan::where('student_id', $student->id)
            ->where('active', true)
            ->latest()
            ->first(); // first() en lugar de firstOrFail()

        // Si no tiene plan redirige a bienvenida
        if (!$studyPlan) {
            return redirect()->route('portal.placement')
                ->with('info', 'Primero completa el diagnóstico para ver tu plan.');
        }

        return view('portal.study-plan', compact('student', 'studyPlan'));
    }

    // Lista de retos
    public function challenges()
    {
        $student    = $this->getStudent();
        $studyPlan  = StudyPlan::where('student_id', $student->id)
            ->where('active', true)->latest()->first();
        $challenges = Challenge::where('student_id', $student->id)
            ->latest()->get();

        return view('portal.challenges', compact('student', 'challenges', 'studyPlan'));
    }

    // Ver reto específico
    public function showChallenge($id)
    {
        $student   = $this->getStudent();
        $challenge = Challenge::findOrFail($id);

        return view('portal.challenge-show', compact('student', 'challenge'));
    }

    // Enviar respuesta del reto
    public function submitChallenge(Request $request, $id)
    {
        $challenge = Challenge::findOrFail($id);
        $response  = $request->input('response');
        $transcript = $request->input('transcript'); // para speaking

        // Si es speaking usar el transcript
        $finalResponse = $challenge->type === 'speaking'
            ? $transcript
            : $response;

        // IA evalúa la respuesta
        $raw      = $this->groq->evaluateResponse(
            $challenge->content,
            $finalResponse,
            $challenge->skill,
            $challenge->level
        );
        $feedback = json_decode($raw, true);

        $challenge->update([
            'student_response'  => $response,
            'speech_transcript' => $transcript,
            'ai_feedback'       => $feedback['feedback']    ?? '',
            'ai_score'          => $feedback['score']       ?? 0,
            'status'            => 'submitted',
        ]);

        return redirect()->route('portal.challenges.show', $id)
            ->with('feedback', $feedback);
    }
}
