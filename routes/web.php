<?php

use App\Http\Controllers\BottleController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\WineryController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $team = auth()->user()->currentTeam;
    return Inertia::render('Dashboard', [
        'team' => $team,
        'bottles' => $team->isWinery()
            ? $team->ownedBottles()->get()
            : $team->followedBottles()->get()
    ]);
})->name('dashboard');

// Bottles
Route::get('bottles/{bottle}', [BottleController::class, 'show'])->name('bottles.show');

// Wineries
Route::get('wineries', [WineryController::class, 'index'])->name('wineries.index');
Route::get('wineries/{winery}', [WineryController::class, 'show'])->name('wineries.show');

// Collections
Route::get('collections', [CollectionController::class, 'index'])->name('collections.index');
Route::get('collections/{collection}', [CollectionController::class, 'show'])->name('collections.show');

Route::get('debug', function () {
    return Inertia::render('Debug', [
    ]);
});
