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
    return Inertia::render('Dashboard', [
        'team' => auth()->user()->currentTeam->load('bottles')
    ]);
})->name('dashboard');

// Bottles
Route::get('bottles/{bottle}', [BottleController::class, 'show'])->name('bottles.show');

// Wineries
Route::get('wineries', [WineryController::class, 'index'])->name('wineries.index');
Route::get('wineries/{bottle}', [WineryController::class, 'show'])->name('wineries.show');

// Collections
Route::get('collections', [CollectionController::class, 'index'])->name('collections.index');
Route::get('collections/{collection}', [CollectionController::class, 'show'])->name('collections.show');

Route::get('debug', function () {
    return Inertia::render('Collections/Show', [
        'collection' => $collection->load('bottles'),
        'qrCode' => QrCode::format('svg')
            ->size(100)
            ->style('round')
            ->eye('circle')
            ->encoding('UTF-8')
            ->color(0, 0, 0, 85)
            ->generate(request()->url())
            ->toHtml(),
    ]);
});
