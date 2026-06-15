<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\AssistanceRequestController;
use App\Http\Controllers\AdminAssistanceRequestController;
use App\Http\Controllers\AdminScholarshipController;
use App\Http\Controllers\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [ScholarshipController::class, 'home'])
    ->name('home');

Route::get('/scholarships', [ScholarshipController::class, 'index'])
    ->name('scholarships.index');

Route::get('/scholarships/{scholarship}', [ScholarshipController::class, 'show'])
    ->name('scholarships.show');

Route::get('/scholarships/{scholarship}/request-assistance', [AssistanceRequestController::class, 'create'])
    ->name('assistance.create');

Route::post('/scholarships/{scholarship}/request-assistance', [AssistanceRequestController::class, 'store'])
    ->name('assistance.store');


/*
|--------------------------------------------------------------------------
| Dashboard Redirect After Login
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('scholarships.index');
})->middleware(['auth'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/assistance-requests', [AdminAssistanceRequestController::class, 'index'])
        ->name('admin.assistance_requests.index');

    Route::get('/admin/assistance-requests/{assistanceRequest}', [AdminAssistanceRequestController::class, 'show'])
        ->name('admin.assistance_requests.show');

    Route::put('/admin/assistance-requests/{assistanceRequest}', [AdminAssistanceRequestController::class, 'update'])
        ->name('admin.assistance_requests.update');

    Route::get('/admin/scholarships', [AdminScholarshipController::class, 'index'])
        ->name('admin.scholarships.index');

    Route::get('/admin/scholarships/create', [AdminScholarshipController::class, 'create'])
        ->name('admin.scholarships.create');

    Route::post('/admin/scholarships', [AdminScholarshipController::class, 'store'])
        ->name('admin.scholarships.store');

    Route::get('/admin/scholarships/{scholarship}/edit', [AdminScholarshipController::class, 'edit'])
        ->name('admin.scholarships.edit');

    Route::put('/admin/scholarships/{scholarship}', [AdminScholarshipController::class, 'update'])
        ->name('admin.scholarships.update');

    Route::delete('/admin/scholarships/{scholarship}', [AdminScholarshipController::class, 'destroy'])
        ->name('admin.scholarships.destroy');
});


/*
|--------------------------------------------------------------------------
| Breeze Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';