<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SessionGameDetailsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlayerNoteController;

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Middleware protected routes
Route::middleware(['authplayer'])->group(function () {
    Route::get('/home', [PlayerController::class, 'showPlayerSessions'])->name('home');
    Route::get('/playerinformation', [PlayerController::class, 'getPlayerInfo'])->name('player.information');
    Route::get('/sessionhistory/{sessionId}/{playerId}', [SessionGameDetailsController::class, 'getSessionGame'])->name('sessionhistory');
    Route::post('/save-note', [SessionGameDetailsController::class, 'savePlayerNote'])->name('saveNote');
    Route::post('/create-note', [SessionGameDetailsController::class, 'createPlayerNote'])->name('createNote');
    Route::get('/api/player-notes/{sessionId}/{playerId}', [PlayerNoteController::class, 'getNoteBySessionAndPlayer']);
    Route::post('/api/update-player-info', [PlayerController::class, 'updatePlayerInfo']);
    Route::put('/api/playersinfo/{id}', [PlayerController::class, 'updatePlayerInfo']);
});

// Default fallback for undefined routes
Route::fallback(function () {
    return redirect('/home');
});

