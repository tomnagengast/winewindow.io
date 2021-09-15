<?php

use App\Http\Controllers\BottleController;
use App\Http\Controllers\CollectionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    function setData($bottles)
    {
        if ($bottles->isEmpty()) {
            return collect([
                0 => ['rating' => 'NA', 'id' => '#']
            ]);
        }

        return $bottles->map(function ($bottle) {
            return [
                'rating' => $bottle->rating,
                'id' => $bottle->id,
                'bottle' => "{$bottle->vintage} {$bottle->varietal}",
            ];
        });
    }

    $team = auth()->user()->currentTeam->load('bottles');
    $vintages = $team->bottles->pluck('vintage')->unique()->sort();
    $varietals = $team->bottles->pluck('varietal')->unique()->sort();
    $groups = $team->bottles->groupBy('varietal');

    $data = $groups->map(function ($groups) use ($vintages) {
        return $vintages->map(function ($vintage) use ($groups) {
            $nullBottles = $groups->filter(function ($group) use ($vintage) {
                return $group->vintage == $vintage;
            });
            return setData($nullBottles)->keyBy('rating');
        });
    });

    $chart = [
        'header' => $vintages,
        'body' => $data,
    ];

    return Inertia::render('Dashboard', [
        'team' => $team,
        'chart' => $chart,
        'vintages' => $vintages,
        'varietals' => $varietals,
    ]);
})->name('dashboard');

//Route::get('wineries/{wineryId}/bottles/{bottleId}', fn() => 'hello there')->name('bottles.show'); // testing
Route::get('bottles/{bottle}', [BottleController::class, 'show'])->name('bottles.show');

// Collections
Route::get('collections', [CollectionController::class, 'index'])->name('collections.index');
Route::get('collections/{collection}', [CollectionController::class, 'show'])->name('collections.show');
