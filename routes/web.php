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
Route::get('{winery}', [WineryController::class, 'show'])->name('wineries.show');

Route::get('{winery}/embed', [WineryController::class, 'embed'])->name('wineries.show.embed');
Route::get('{winery}/{bottle}/embed', [BottleController::class, 'embed'])->name('bottles.show.embed');

Route::get('{winery}/{bottle}', [BottleController::class, 'show'])->name('bottles.show');
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('{winery}/bottles/create', [BottleController::class, 'create'])->name('bottles.create');
    Route::post('{winery}/bottles/store', [BottleController::class, 'store'])->name('bottles.store');
    Route::post('{winery}/{bottle}/follow', [BottleController::class, 'follow'])->name('bottles.follow');
    Route::post('{winery}/{bottle}/unfollow', [BottleController::class, 'unfollow'])->name('bottles.unfollow');
    Route::get('{winery}/{bottle}/edit', [BottleController::class, 'edit'])->name('bottles.edit');
    Route::post('{winery}/{bottle}/update', [BottleController::class, 'update'])->name('bottles.update');
    Route::get('{winery}/{bottle}/destroy', [BottleController::class, 'destroy'])->name('bottles.destroy');
});

Route::get('{winery}/collections', [CollectionController::class, 'index'])->name('collections.index');
Route::get('{winery}/{collection}', [CollectionController::class, 'show'])->name('collections.show');

Route::get('debug', function () {
    //
});
