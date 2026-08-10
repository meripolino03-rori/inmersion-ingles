<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Rubric;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ── Roles ──────────────────────────────────────
        $adminRole   = Role::firstOrCreate(['name' => 'admin']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);

        // ── Usuarios base ───────────────────────────────
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'Admin', 'password' => bcrypt('password')]
        );
        $admin->assignRole($adminRole);

        User::firstOrCreate(
            ['email' => 'tester@tester.com'],
            ['name' => 'Tester', 'password' => bcrypt('password')]
        );

        // ── 5 rúbricas fijas ────────────────────────────
        foreach ([
            ['type' => 'writing',  'description' => 'Written expression rubric'],
            ['type' => 'reading',  'description' => 'Reading comprehension rubric'],
            ['type' => 'speaking', 'description' => 'Oral expression rubric'],
            ['type' => 'alp',      'description' => 'ALP unit project rubric'],
            ['type' => 'final',    'description' => 'Final project rubric'],
        ] as $r) {
            Rubric::firstOrCreate(['type' => $r['type']], $r);
        }

        // ── Tus otros seeders ───────────────────────────
        $this->call(InitialSeeder::class);
    }
}