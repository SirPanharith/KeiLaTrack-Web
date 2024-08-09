<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SessionGameDetailsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlayerNoteController;
use App\Http\Controllers\ForgotPasswordController;

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot_password.show');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('forgot_password.post');
Route::get('/otp', [ForgotPasswordController::class, 'showOtpForm'])->name('otp.form');
Route::post('/otp', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset.post');
// Route::get('/reset-password', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('password.reset.show');
// Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset.post');

// Middleware protected routes
Route::middleware(['authplayer'])->group(function () {
    Route::get('/home', [PlayerController::class, 'showPlayerSessions'])->name('home');
    Route::get('/playerinformation', [PlayerController::class, 'getPlayerInfo'])->name('player.information');
    Route::get('/sessionhistory/{sessionId}/{playerId}', [SessionGameDetailsController::class, 'getSessionGame'])->name('sessionhistory');
    Route::post('/save-note', [SessionGameDetailsController::class, 'savePlayerNote'])->name('saveNote');
    Route::post('/create-note', [SessionGameDetailsController::class, 'createPlayerNote'])->name('createNote');
    Route::get('/api/player-notes/{sessionId}/{playerId}', [PlayerNoteController::class, 'getNoteBySessionAndPlayer']);
    Route::post('/api/update-player-info', [PlayerController::class, 'updatePlayerInfo']);
    // Route::post('/playersinfo/update/{id}', [PlayerController::class, 'updatePlayerImage']);
    Route::post('/api/update-player-image', [PlayerController::class, 'uploadPlayerImage'])->name('player.updateImage');

});

// Default fallback for undefined routes
Route::fallback(function () {
    return redirect('/home');
});

