<?php

use Illuminate\Support\Facades\Route;
use App\Notifications\BottleWasUpdated;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WineryController;
use App\Http\Controllers\BottleController;
use App\Http\Controllers\CollectionController;

Route::get('/', [AuthController::class, 'welcome'])->name('landing');
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

Route::get('/auth/google/redirect', [AuthController::class, 'googleRedirect'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'googleCallback'])->name('auth.google.callback');

Route::get('wineries', [WineryController::class, 'index'])->name('wineries.index');
Route::get('wineries/{winery}', [WineryController::class, 'show'])->name('wineries.show');

Route::get('bottles/{bottle}', [BottleController::class, 'show'])->name('bottles.show');
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('bottles/{bottle}/follow', [BottleController::class, 'follow'])->name('bottles.follow');
    Route::post('bottles/{bottle}/unfollow', [BottleController::class, 'unfollow'])->name('bottles.unfollow');
    Route::get('bottles/{bottle}/edit', [BottleController::class, 'edit'])->name('bottles.edit');
    Route::post('bottles/{bottle}/update', [BottleController::class, 'update'])->name('bottles.update');
    Route::get('bottles/{bottle}/destroy', [BottleController::class, 'destroy'])->name('bottles.destroy');
    Route::get('wineries/{winery}/bottles/create', [BottleController::class, 'create'])->name('bottles.create');
    Route::post('wineries/{winery}/bottles/store', [BottleController::class, 'store'])->name('bottles.store');
});

Route::get('collections', [CollectionController::class, 'index'])->name('collections.index');
Route::get('collections/{collection}', [CollectionController::class, 'show'])->name('collections.show');

Route::get('debug', function () {
    //
});
