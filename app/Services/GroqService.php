<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GroqService
{
  private string $apiKey;
  private string $model;
  private string $baseUrl = 'https://api.groq.com/openai/v1/chat/completions';

  public function __construct()
  {
    $this->apiKey = env('GROQ_API_KEY');
    $this->model  = env('GROQ_MODEL', 'llama3-8b-8192');
  }

  public function ask(string $system, string $prompt): string
  {
    $response = Http::withToken($this->apiKey)
      ->timeout(30) // Increase to 30 seconds
      ->connectTimeout(10) // Give the connection handshake more time
      ->post($this->baseUrl, [
        'model'       => $this->model,
        'temperature' => 0.7,
        'max_tokens'  => 1500,
        'messages'    => [
          ['role' => 'system', 'content' => $system],
          ['role' => 'user',   'content' => $prompt],
        ],
      ]);

    // Debug completo
    info('Groq status: ' . $response->status());
    info('Groq body: ' . $response->body());

    return $response->json('choices.0.message.content') ?? '';
  }

  // Examen diagnóstico
  public function generatePlacementExam(string $career): string
  {
    $system = "Eres un especialista en evaluación diagnóstica de inglés para estudiantes universitarios.
               Tu objetivo es determinar el nivel de inglés del estudiante según el Marco Común Europeo 
               de Referencia para las Lenguas (MCER): A1, A2, B1 o B2.
               
               REGLAS CRÍTICAS:
               - Responde ÚNICAMENTE con JSON válido.
               - No uses markdown, no uses bloques de código, no uses backticks.
               - No agregues texto antes ni después del JSON.
               - Los campos 'question', 'text' y 'options' deben estar SIEMPRE en inglés.
               - El campo 'text' debe contener un párrafo en inglés de 30 a 50 palabras.
               - El campo 'instructions' debe estar SIEMPRE en español.
               - Nunca generes preguntas, opciones ni textos de lectura en español.
               - Las preguntas deben estar contextualizadas a la carrera indicada.
               - El objetivo es evaluar inglés, NO conocimientos técnicos avanzados.
               - La dificultad debe aumentar progresivamente desde A1 hasta B2.
               - Las preguntas deben ser claras, originales y realistas.
               - No revelar respuestas dentro de las preguntas.
               - Las preguntas de Reading deben requerir inferencia y comprensión, no copia literal.
               - Las preguntas de Writing y Speaking deben ser breves y apropiadas para un examen diagnóstico.";

    $prompt = "Genera un examen diagnóstico de inglés de EXACTAMENTE 10 preguntas para un estudiante de {$career}.

               ESTRUCTURA OBLIGATORIA (en este orden exacto):
               Pregunta 1  → skill: writing    → Nivel A1
               Pregunta 2  → skill: writing    → Nivel A2
               Pregunta 3  → skill: reading    → Nivel A2
               Pregunta 4  → skill: reading    → Nivel B1
               Pregunta 5  → skill: grammar    → Nivel A2
               Pregunta 6  → skill: grammar    → Nivel B1
               Pregunta 7  → skill: vocabulary → Nivel A2-B1
               Pregunta 8  → skill: vocabulary → Nivel B1-B2
               Pregunta 9  → skill: listening  → Nivel B1-B2
               Pregunta 10 → skill: speaking   → Nivel B2

               REGLAS POR HABILIDAD:

               WRITING (preguntas 1 y 2):
               - Respuesta esperada entre 15 y 30 palabras.
               - Temas simples relacionados con {$career}.
               - No solicitar explicaciones técnicas complejas.
               - No preguntar sobre datos personales y no repetir las preguntas anteriores.

               READING (preguntas 3 y 4):
               - Generar el texto en el campo 'text' con un párrafo de 30 a 50 palabras en inglés.
               - Las preguntas deben requerir comprensión e inferencia, no copia literal del texto.

               GRAMMAR (preguntas 5 y 6):
               - Incluir campo 'options' con EXACTAMENTE 4 alternativas en inglés.
               - Una sola respuesta correcta.
               - Evaluar estructuras gramaticales progresivas.

               VOCABULARY (preguntas 7 y 8):
               - Incluir campo 'options' con EXACTAMENTE 4 alternativas en inglés.
               - Una sola respuesta correcta.
               - Vocabulario técnico básico relacionado con {$career}.

               LISTENING (pregunta 9):
               - Incluir campo 'audio_text' con una frase o diálogo corto en inglés relacionado con {$career}.
               - El estudiante debe escribir en inglés lo que entendió.
               - instructions: 'Escucha el audio con atención y escribe en inglés lo que entendiste.'

               SPEAKING (pregunta 10):
               - Plantear una situación profesional sencilla relacionada con {$career}.
               - Respuesta oral esperada entre 10 y 20 segundos.
               - instructions: 'Presiona el micrófono y responde en inglés durante 10 a 20 segundos.'

               REGLAS GENERALES:
               - Las primeras preguntas deben poder ser respondidas por estudiantes de nivel A1.
               - Las últimas preguntas deben permitir identificar estudiantes de nivel B2.
               - No generar más ni menos de 10 preguntas.
               - No generar preguntas excesivamente técnicas.
               - Cada pregunta debe ser única, original y contextualizada a {$career}.

               FORMATO JSON OBLIGATORIO (responde SOLO con este JSON):
               {
                 \"questions\": [
                   {
                     \"id\": 1,
                     \"skill\": \"writing\",
                     \"level\": \"A1\",
                     \"question\": \"[pregunta en inglés]\",
                     \"instructions\": \"[instrucción en español]\"
                   },
                   {
                     \"id\": 2,
                     \"skill\": \"writing\",
                     \"level\": \"A2\",
                     \"question\": \"[pregunta en inglés]\",
                     \"instructions\": \"[instrucción en español]\"
                   },
                   {
                     \"id\": 3,
                     \"skill\": \"reading\",
                     \"level\": \"A2\",
                     \"text\": \"[párrafo en inglés de 40 a 80 palabras]\",
                     \"question\": \"[pregunta en inglés]\",
                     \"instructions\": \"[instrucción en español]\"
                   },
                   {
                     \"id\": 4,
                     \"skill\": \"reading\",
                     \"level\": \"B1\",
                     \"text\": \"[párrafo en inglés de 40 a 80 palabras]\",
                     \"question\": \"[pregunta en inglés]\",
                     \"instructions\": \"[instrucción en español]\"
                   },
                   {
                     \"id\": 5,
                     \"skill\": \"grammar\",
                     \"level\": \"A2\",
                     \"question\": \"[pregunta en inglés]\",
                     \"instructions\": \"[instrucción en español]\",
                     \"options\": [\"Option A\", \"Option B\", \"Option C\", \"Option D\"]
                   },
                   {
                     \"id\": 6,
                     \"skill\": \"grammar\",
                     \"level\": \"B1\",
                     \"question\": \"[pregunta en inglés]\",
                     \"instructions\": \"[instrucción en español]\",
                     \"options\": [\"Option A\", \"Option B\", \"Option C\", \"Option D\"]
                   },
                   {
                     \"id\": 7,
                     \"skill\": \"vocabulary\",
                     \"level\": \"A2-B1\",
                     \"question\": \"[pregunta en inglés]\",
                     \"instructions\": \"[instrucción en español]\",
                     \"options\": [\"Option A\", \"Option B\", \"Option C\", \"Option D\"]
                   },
                   {
                     \"id\": 8,
                     \"skill\": \"vocabulary\",
                     \"level\": \"B1-B2\",
                     \"question\": \"[pregunta en inglés]\",
                     \"instructions\": \"[instrucción en español]\",
                     \"options\": [\"Option A\", \"Option B\", \"Option C\", \"Option D\"]
                   },
                   {
                     \"id\": 9,
                     \"skill\": \"listening\",
                     \"level\": \"B1-B2\",
                     \"audio_text\": \"[frase o diálogo corto en inglés relacionado con {$career}]\",
                     \"question\": \"[pregunta en inglés]\",
                     \"instructions\": \"Escucha el audio con atención y escribe en inglés lo que entendiste.\"
                   },
                   {
                     \"id\": 10,
                     \"skill\": \"speaking\",
                     \"level\": \"B2\",
                     \"question\": \"[situación profesional en inglés relacionada con {$career}]\",
                     \"instructions\": \"Presiona el micrófono y responde en inglés durante 10 a 20 segundos.\"
                   }
                 ]
               }

               RECUERDA: Responde SOLO con el JSON. Sin texto adicional. Sin markdown.";

    return $this->ask($system, $prompt);
  }
  // Analizar respuestas y asignar nivel
  public function analyzePlacementExam(
    array $questions,
    array $answers,
    string $career
  ): string {
    $system = "Eres un experto evaluador de inglés para estudiantes 
               universitarios en Perú. Analiza las respuestas del examen 
               y asigna niveles MCER. Responde siempre en formato JSON.";

    $qa = collect($questions)->map(
      fn($q, $i) =>
      "P: " . (is_array($q) ? $q['question'] : $q)
        . "\nR: " . ($answers[$i] ?? 'Sin respuesta')
    )->join("\n\n");

    $prompt = "Analiza estas respuestas de examen de un estudiante de {$career}:

           {$qa}

           Responde ÚNICAMENTE en formato JSON válido usando comillas dobles. 
           No incluyas texto introductorio ni de conclusión.
           Evalúa al estudiante basándote en la escala MCER (A1, A2, B1, B2, C1 o C2).
           El análisis detallado debe estar redactado en español.
           
           Formato JSON:
           {
             \"level\": \"[NIVEL]\",
             \"strengths\": [\"...\"],
             \"weaknesses\": [\"...\"],
             \"analysis\": \"[Análisis detallado en español, máximo 200 palabras]\"
           }";

    return $this->ask($system, $prompt);
  }

  // Generar plan de estudio
  public function generateStudyPlan(
    string $level,
    array $weaknesses,
    string $career
  ): string {
    $weak = implode(', ', $weaknesses);

    $topicsByLevel = [
      'A1' => [
        'writing'    => 'Oraciones simples, presentaciones personales, verbos to be y have',
        'reading'    => 'Textos muy cortos, señales, menús, instrucciones simples',
        'grammar'    => 'Presente simple, artículos, plurales, pronombres personales',
        'vocabulary' => 'Números, colores, días, saludos, objetos cotidianos',
        'listening'  => 'Palabras aisladas, instrucciones simples, diálogos muy cortos',
        'speaking'   => 'Saludos, presentaciones, respuestas sí/no',
      ],
      'A2' => [
        'writing'    => 'Párrafos cortos, emails simples, descripciones de rutinas',
        'reading'    => 'Textos cortos sobre temas familiares, avisos, mensajes',
        'grammar'    => 'Pasado simple, presente continuo, comparativos, preposiciones',
        'vocabulary' => 'Familia, trabajo, transporte, tiempo libre, carrera técnica básica',
        'listening'  => 'Diálogos cotidianos, anuncios simples, conversaciones lentas',
        'speaking'   => 'Describir experiencias pasadas, pedir información, expresar preferencias',
      ],
      'B1' => [
        'writing'    => 'Emails formales, resúmenes, textos de opinión cortos',
        'reading'    => 'Artículos de noticias, manuales técnicos simples, blogs',
        'grammar'    => 'Presente perfecto, condicionales, voz pasiva, conectores',
        'vocabulary' => 'Vocabulario técnico de la carrera, expresiones idiomáticas básicas',
        'listening'  => 'Podcasts cortos, noticias lentas, entrevistas simples',
        'speaking'   => 'Dar opiniones, describir procesos, participar en debates simples',
      ],
      'B2' => [
        'writing'    => 'Reportes técnicos, ensayos argumentativos, resúmenes académicos',
        'reading'    => 'Artículos académicos, papers técnicos, noticias especializadas',
        'grammar'    => 'Condicionales mixtos, subjuntivo, estructuras avanzadas',
        'vocabulary' => 'Vocabulario académico y técnico avanzado, phrasal verbs',
        'listening'  => 'Conferencias, debates, documentales técnicos',
        'speaking'   => 'Presentaciones técnicas, negociaciones, debates académicos',
      ],
    ];

    $topics = $topicsByLevel[$level] ?? $topicsByLevel['A1'];

    // Filtrar solo los tópicos de las debilidades del estudiante
    $weakTopics = '';
    foreach ($weaknesses as $weakness) {
      $key = strtolower(trim($weakness));
      if (isset($topics[$key])) {
        $weakTopics .= "- {$weakness}: {$topics[$key]}\n";
      }
    }

    // Si no hay tópicos específicos, usar todos
    if (empty($weakTopics)) {
      foreach ($topics as $skill => $topic) {
        $weakTopics .= "- {$skill}: {$topic}\n";
      }
    }

    $system = "Eres un experto en enseñanza de inglés para universitarios en Perú.
               Creas planes de estudio personalizados con recursos 100% GRATUITOS.
               Responde SOLO con JSON válido, sin texto adicional, sin markdown.";

    $prompt = "Crea un plan de estudio de inglés personalizado para un estudiante de {$career}.

               Nivel actual: {$level}
               Habilidades a reforzar: {$weak}

               TÓPICOS ESPECÍFICOS A TRABAJAR SEGÚN NIVEL {$level}:
               {$weakTopics}

               INSTRUCCIÓN PRINCIPAL:
               Genera recursos DIRECTAMENTE relacionados a cada habilidad débil.
               Cada recurso debe tener el campo 'skill' indicando a qué habilidad pertenece.
               Las habilidades son: writing, reading, grammar, vocabulary, listening, speaking.

               REGLAS:
               - Todos los recursos deben estar en inglés o caso contrario en español para traducir a inglés.
               - Mínimo 2 recursos por cada habilidad débil: {$weak}
               - Adaptar dificultad exactamente al nivel {$level}
               - Recursos específicos para {$career} donde sea posible
               - URLs reales y verificables y vayan acorde al tema
               - Descripciones en ESPAÑOL
               - Mínimo 10 recursos en total

               Responde SOLO en este JSON:
               {
                   \"level\": \"{$level}\",
                   \"career\": \"{$career}\",
                   \"focus_areas\": [\"tópico 1\", \"tópico 2\", \"tópico 3\"],
                   \"study_tips\": [
                       \"consejo específico para nivel {$level} y habilidad débil\",
                       \"consejo 2 relacionado a {$career}\"
                   ],
                   \"resources\": [
                       {
                           \"title\": \"nombre del recurso\",
                           \"url\": \"https://...\",
                           \"skill\": \"writing|reading|grammar|vocabulary|listening|speaking\",
                           \"topic\": \"tópico específico que trabaja\",
                           \"description\": \"descripción en español\",
                           \"level\": \"{$level}\"
                       }
                   ]
               }";

    $result = $this->ask($system, $prompt);
    info('Study plan raw: ' . $result);
    return $result;
  }

  // Generar reto/práctica
  public function generateChallenge(
    string $skill,
    string $type,
    string $level,
    string $career
  ): string {
    $system = "You are an English practice generator for {$career} 
                   students in Peru. Generate engaging exercises.
                   Always respond in JSON.";

    $prompt = "Generate a {$type} exercise for skill: {$skill}
                   Student level: {$level}
                   Career: {$career}
                   
                   Respond ONLY in this JSON format:
                   {
                     'title': '...',
                     'instructions': '...',
                     'content': '...',
                     'expected': '...',
                     'tips': ['...']
                   }";

    return $this->ask($system, $prompt);
  }

  // Evaluar respuesta del estudiante
  public function evaluateResponse(
    string $challenge,
    string $response,
    string $skill,
    string $level
  ): string {
    $system = "You are an English teacher evaluating student responses.
                   Be encouraging but constructive. Always in JSON.";

    $prompt = "Evaluate this student response:
                   
                   Challenge: {$challenge}
                   Student response: {$response}
                   Skill: {$skill}
                   Level: {$level}
                   
                   Respond ONLY in this JSON format:
                   {
                     'score': 16.5,
                     'feedback': 'Feedback in Spanish...',
                     'corrections': ['correction 1', 'correction 2'],
                     'positive': 'What they did well in Spanish...',
                     'tip': 'One improvement tip in Spanish...'
                   }";

    return $this->ask($system, $prompt);
  }
}
