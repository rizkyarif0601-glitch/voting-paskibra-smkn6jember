<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VotingController;
use App\Http\Middleware\EnsureValidVotingToken;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| E-Voting Paskibra SMKN 6 Jember — Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke halaman input token
Route::redirect('/', '/voting');

// ── Voting Routes (Publik Pemilih) ────────────────────────────────────────
Route::prefix('voting')->name('voting.')->group(function () {

    Route::get('/', [VotingController::class, 'index'])
        ->name('index');

    Route::post('/authenticate', [VotingController::class, 'authenticateToken'])
        ->name('authenticate');

    // Halaman yang WAJIB memiliki token aktif dan belum pernah memilih
    Route::middleware(EnsureValidVotingToken::class)->group(function () {
        Route::get('/ballot', [VotingController::class, 'showBallot'])
            ->name('ballot');

        Route::post('/submit', [VotingController::class, 'submitVote'])
            ->name('submit');
    });

    Route::get('/thank-you', [VotingController::class, 'thankYou'])
        ->name('thank-you');

});

// ── Admin Routes ──────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    // Login Admin (Guest only)
    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');

    // Protected Admin Routes (Harus Login)
    Route::middleware('auth')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');

        // Dashboard utama — statistik & quick count
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        // Generate token baru (POST)
        Route::post('/tokens/generate', [AdminController::class, 'generateTokens'])
            ->name('tokens.generate');

        // Halaman cetak token (GET) — layout A4
        Route::get('/tokens/print', [AdminController::class, 'printTokens'])
            ->name('tokens.print');

        // Hapus satu token (DELETE)
        Route::delete('/tokens/{voter}', [AdminController::class, 'deleteToken'])
            ->name('tokens.delete');

        // Hapus semua token yang belum digunakan (DELETE)
        Route::delete('/tokens', [AdminController::class, 'deleteUnusedTokens'])
            ->name('tokens.delete-unused');

        // Reset semua hasil pemilihan untuk simulasi (DELETE)
        Route::delete('/results/clear', [AdminController::class, 'clearResults'])
            ->name('results.clear');

        // Update data kandidat (Nama, Foto, Visi, Misi) (POST)
        Route::post('/candidates/{candidate}', [AdminController::class, 'updateCandidate'])
            ->name('candidates.update');

        // Layar Live Perolehan Suara Real-Time (GET)
        Route::get('/realtime', [AdminController::class, 'realtime'])
            ->name('realtime');

        // Data polling JSON perolehan suara (GET)
        Route::get('/realtime/data', [AdminController::class, 'realtimeData'])
            ->name('realtime.data');

    });

});
