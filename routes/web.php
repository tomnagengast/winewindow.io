<?php

use App\Http\Controllers\BottleController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\WineryController;
use App\Models\Team;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('landing');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $team = auth()->user()->currentTeam;
    // Testing for Cypress
    if (!$team) {
        $team = Team::factory()->make([
            'user_id' => auth()->user()->id,
            'name' => explode(' ', auth()->user()->name, 2)[0]."'s Team",
            'personal_team' => true,
            'type' => 'cellar'
        ]);
        auth()->user()->ownedTeams()->save($team);
        auth()->user()->switchTeam($team);
    }
    return Inertia::render('Dashboard', [
        'team' => $team,
        'bottles' => $team->isWinery()
            ? $team->ownedBottles()->get()
            : $team->followedBottles()->get()
    ]);
})->name('dashboard');

// Bottles
Route::get('bottles/{bottle}', [BottleController::class, 'show'])->name('bottles.show');
Route::middleware(['auth:sanctum', 'verified'])->post('bottles/{bottle}/follow', [BottleController::class, 'follow'])->name('bottles.follow');
Route::middleware(['auth:sanctum', 'verified'])->post('bottles/{bottle}/unfollow', [BottleController::class, 'unfollow'])->name('bottles.unfollow');
Route::middleware(['auth:sanctum', 'verified'])->get('bottles/{bottle}/edit', [BottleController::class, 'edit'])->name('bottles.edit');
Route::middleware(['auth:sanctum', 'verified'])->post('bottles/{bottle}/update', [BottleController::class, 'update'])->name('bottles.update');
Route::middleware(['auth:sanctum', 'verified'])->get('wineries/{winery}/bottles/create', [BottleController::class, 'create'])->name('bottles.create');
Route::middleware(['auth:sanctum', 'verified'])->post('wineries/{winery}/bottles/store', [BottleController::class, 'store'])->name('bottles.store');
Route::middleware(['auth:sanctum', 'verified'])->get('bottles/{bottle}/destroy', [BottleController::class, 'destroy'])->name('bottles.destroy');

// Wineries
Route::get('wineries', [WineryController::class, 'index'])->name('wineries.index');
Route::get('wineries/{winery}', [WineryController::class, 'show'])->name('wineries.show');

// Collections
Route::get('collections', [CollectionController::class, 'index'])->name('collections.index');
Route::get('collections/{collection}', [CollectionController::class, 'show'])->name('collections.show');

Route::get('debug', function () {
//    Bugsnag::notifyException(new RuntimeException("Test error"));

//    $bottle = App\Models\Bottle::find(8);
//    App\Jobs\NotifyBottleUpdated::dispatch($bottle);
//    return $bottle;

//    return Inertia::render('Debug', []);
});
