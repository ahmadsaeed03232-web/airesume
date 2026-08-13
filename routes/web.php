<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ResumeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::resource('resumes', ResumeController::class);

Route::post('resumes/{resume}/ai/summary', [ResumeController::class, 'aiSummary'])->name('resumes.ai.summary');
Route::post('resumes/{resume}/ai/improve-bullet', [ResumeController::class, 'aiImproveBullet'])->name('resumes.ai.improve-bullet');
Route::post('resumes/{resume}/ai/career-translate', [ResumeController::class, 'aiCareerTranslate'])->name('resumes.ai.career-translate');
Route::post('resumes/{resume}/ai/ats-analyze', [ResumeController::class, 'aiAtsAnalyze'])->name('resumes.ai.ats-analyze');
Route::post('resumes/{resume}/ai/suggestions', [ResumeController::class, 'aiSuggestions'])->name('resumes.ai.suggestions');
Route::post('resumes/{resume}/ai/cover-letter', [ResumeController::class, 'aiGenerateCoverLetter'])->name('resumes.ai.cover-letter');
Route::post('resumes/{resume}/duplicate', [ResumeController::class, 'duplicate'])->name('resumes.duplicate');
Route::get('resumes/{resume}/share', [ResumeController::class, 'share'])->name('resumes.share');

