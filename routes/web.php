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

// Language switch (flag buttons): stores the choice in the session and returns to the same page.
Route::get('/lang/{locale}', function (string $locale) {
    session(['locale' => $locale]);

    // Go back to the page the visitor was on, but only if it is a page of this site.
    $previous = url()->previous();
    $sameSite = parse_url($previous, PHP_URL_HOST) === request()->getHost();

    return redirect()->to($sameSite ? $previous : route('home'));
})->whereIn('locale', \App\Http\Middleware\SetLocale::SUPPORTED)->name('lang.switch');

Route::get('/', [ScholarshipController::class, 'home'])
    ->name('home');

Route::get('/scholarships', [ScholarshipController::class, 'index'])
    ->name('scholarships.index');

Route::get('/scholarships/{scholarship}', [ScholarshipController::class, 'show'])
    ->name('scholarships.show');

Route::get('/scholarships/{scholarship}/request-assistance', [AssistanceRequestController::class, 'create'])
    ->name('assistance.create');

Route::post('/scholarships/{scholarship}/request-assistance', [AssistanceRequestController::class, 'store'])
    ->middleware('throttle:assistance')
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

    // Student documents are private: only admins can open them, through this route.
    Route::get('/admin/documents/{document}', [AdminAssistanceRequestController::class, 'document'])
        ->name('admin.documents.show');

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