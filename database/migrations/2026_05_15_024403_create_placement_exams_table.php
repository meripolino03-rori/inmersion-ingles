<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('placement_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->integer('attempt')->default(1); // intento 1,2,3...
            $table->json('answers');                // respuestas del estudiante
            $table->string('assigned_level');       // A1, A2, B1...
            $table->json('strengths');              // habilidades fuertes
            $table->json('weaknesses');             // habilidades débiles
            $table->text('ai_analysis');            // análisis completo de la IA
            $table->timestamp('taken_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('placement_exams');
    }
};
