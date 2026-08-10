<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

// Modelos
use App\Models\Cycle;
use App\Models\Unit;
use App\Models\Student;
use App\Models\Evaluation;
use App\Models\Grade;
use App\Models\Practice;
use App\Models\Rubric;
use App\Models\Criterion;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

// Policies
use App\Policies\CyclePolicy;
use App\Policies\UnitPolicy;
use App\Policies\StudentPolicy;
use App\Policies\EvaluationPolicy;
use App\Policies\GradePolicy;
use App\Policies\PracticePolicy;
use App\Policies\RubricPolicy;
use App\Policies\CriterionPolicy;
use App\Policies\UserPolicy;
use App\Policies\RolePolicy;
use App\Policies\PermissionPolicy;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $policies = [
            Cycle::class      => CyclePolicy::class,
            Unit::class       => UnitPolicy::class,
            Student::class    => StudentPolicy::class,
            Evaluation::class => EvaluationPolicy::class,
            Grade::class      => GradePolicy::class,
            Practice::class   => PracticePolicy::class,
            Rubric::class     => RubricPolicy::class,
            Criterion::class  => CriterionPolicy::class,
            User::class       => UserPolicy::class,
            Role::class       => RolePolicy::class,
            Permission::class => PermissionPolicy::class,
        ];

        foreach ($policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
