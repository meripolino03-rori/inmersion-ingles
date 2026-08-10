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
        Schema::table('students', function (Blueprint $table) {
            $table->enum('level', ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'])
                ->nullable()
                ->after('code');
            $table->json('strengths')->nullable()->after('level');
            $table->json('weaknesses')->nullable()->after('strengths');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            //
        });
    }
};
