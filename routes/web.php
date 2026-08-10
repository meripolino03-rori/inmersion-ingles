<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentPortalController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AIPortalController;

//Route::get('/', function () {
//   return view('welcome'); //welcome
//});

// Pagina inicio
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->hasRole('student')) {
            return redirect()->route('portal.home');
        }
        return redirect('/admin'); // panel Filament
    }
    return redirect()->route('login');
    //return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/reports/group-excel', [ReportController::class, 'groupExcel'])
        ->name('reports.group-excel');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'role:student'])->prefix('portal')->name('portal.')->group(function () {
    Route::get('/',          [StudentPortalController::class, 'index'])->name('home');
    Route::get('/progress',  [StudentPortalController::class, 'progress'])->name('progress');
    Route::get('/practices', [StudentPortalController::class, 'practices'])->name('practices');

    // Rutas nuevas de IA
    // Examen diagnóstico
    Route::get('/placement',         [AIPortalController::class, 'placement'])->name('placement');
    Route::post('/placement',        [AIPortalController::class, 'submitPlacement'])->name('placement.submit');

    // Plan de estudios
    Route::get('/study-plan',        [AIPortalController::class, 'studyPlan'])->name('study-plan');

    // Retos
    Route::get('/challenges',           [AIPortalController::class, 'challenges'])->name('challenges');
    Route::post('/challenges/generate', [AIPortalController::class, 'generateChallenge'])->name('challenges.generate'); //agregado
    Route::get('/challenges/{id}',      [AIPortalController::class, 'showChallenge'])->name('challenges.show');
    Route::post('/challenges/{id}',     [AIPortalController::class, 'submitChallenge'])->name('challenges.submit');
}); //panel estudiante
