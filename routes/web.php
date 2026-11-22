<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QuizManageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

// Halaman peserta
Route::get('/', [QuizController::class, 'index'])->name('home');
Route::get('/quiz/{slug}', [QuizController::class, 'show'])->name('quiz.show');
Route::post('/quiz/{slug}/submit', [QuizController::class, 'submit'])->name('quiz.submit');

// Halaman mentor
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export-csv', [DashboardController::class, 'exportCsv'])->name('dashboard.export');
    Route::delete('/dashboard/attempts/bulk-delete', [DashboardController::class, 'bulkDestroyAttempts'])->name('dashboard.attempts.bulkDestroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/quizzes', [QuizManageController::class, 'index'])->name('quizzes.index');
        Route::get('/quizzes/create', [QuizManageController::class, 'create'])->name('quizzes.create');
        Route::post('/quizzes', [QuizManageController::class, 'store'])->name('quizzes.store');
        Route::delete('/quizzes/{quiz}', [QuizManageController::class, 'destroy'])->name('quizzes.destroy');

        Route::get('/quizzes/template-csv', [QuizManageController::class, 'downloadTemplate'])->name('quizzes.template');
        Route::post('/quizzes/{quiz}/import-csv', [QuizManageController::class, 'importCsv'])->name('quizzes.import');
        Route::get('/quizzes/{quiz}/import-errors', [QuizManageController::class, 'downloadImportErrors'])->name('quizzes.import.errors');

        Route::get('/quizzes/{quiz}/questions', [QuizManageController::class, 'questions'])->name('quizzes.questions');
        Route::post('/quizzes/{quiz}/questions', [QuizManageController::class, 'storeQuestion'])->name('quizzes.questions.store');
        Route::delete('/questions/{question}', [QuizManageController::class, 'destroyQuestion'])->name('questions.destroy');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
