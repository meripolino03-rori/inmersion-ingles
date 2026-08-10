<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\Cycle;
use App\Models\Unit;
use App\Models\Rubric;
use App\Models\Criterion;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cycle = Cycle::create([
            'name' => '2025-I',
            'year' => 2025,
            'semester' => 'I',
        ]);

        // Units
        for ($i = 1; $i <= 4; $i++) {
            Unit::create([
                'cycle_id' => $cycle->id,
                'name' => "Unit $i",
                'number' => $i,
            ]);
        }

        // Rubric Writing
        $rubric = Rubric::create([
            'type' => 'writing',
        ]);

        Criterion::insert([
            ['rubric_id' => $rubric->id, 'name' => 'Organización'],
            ['rubric_id' => $rubric->id, 'name' => 'Gramática'],
            ['rubric_id' => $rubric->id, 'name' => 'Vocabulario'],
            ['rubric_id' => $rubric->id, 'name' => 'Ortografía'],
            ['rubric_id' => $rubric->id, 'name' => 'Adecuación'],
        ]);
    }
}
