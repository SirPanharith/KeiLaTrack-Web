<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SessionGameDetailsController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Middleware protected routes
Route::middleware(['checkplayersession'])->group(function () {
    Route::get('/', [PlayerController::class, 'showPlayerSessions']);
    //Route::get('/', [PlayerController::class, 'showPlayerSessions'])->name('player.sessions');
    Route::get('/playerinformation/{playerInfoId}', [PlayerController::class, 'getPlayerInfo'])->name('player.information');
    Route::get('/session-history/{sessionId}/player/{playerId}', [SessionGameDetailsController::class, 'getSessionGame'])->name('sessionhistory');
    Route::post('/save-note', [SessionGameDetailsController::class, 'savePlayerNote'])->name('saveNote');
    Route::post('/create-note', [SessionGameDetailsController::class, 'createPlayerNote'])->name('createNote');
    Route::get('/api/player-notes/{sessionId}/{playerId}', [PlayerNoteController::class, 'getNoteBySessionAndPlayer']);
    Route::post('/api/update-player-info', [PlayerController::class, 'updatePlayerInfo']);
    Route::put('/api/playersinfo/{id}', [PlayerController::class, 'updatePlayerInfo']);

});

// Static pages
Route::view('/login', 'login');
Route::view('/signup', 'signup');
Route::view('/timer', 'timer');
Route::view('/session-history', 'sessionhistory');

// Default fallback for undefined routes
Route::fallback(function () {
    return redirect('/');
});

