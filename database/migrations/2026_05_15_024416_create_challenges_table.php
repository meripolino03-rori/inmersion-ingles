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
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('study_plan_id')->constrained()->cascadeOnDelete();
            $table->enum('skill', [
                'writing',
                'reading',
                'speaking',
                'listening',
                'grammar',
                'vocabulary'
            ]);
            $table->enum('type', [
                'fill_blank',
                'word_match',
                'reading_comp',
                'writing',
                'true_false',
                'speaking'
            ]);
            $table->string('level');                // A1, A2, B1...
            $table->text('content');                // ejercicio generado por IA
            $table->text('student_response')->nullable(); // respuesta del alumno
            $table->text('speech_transcript')->nullable(); // texto del audio
            $table->text('ai_feedback')->nullable();       // feedback de la IA
            $table->decimal('ai_score', 5, 2)->nullable(); // nota sugerida por IA
            $table->enum('status', ['pending', 'submitted', 'reviewed'])
                ->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challenges');
    }
};
