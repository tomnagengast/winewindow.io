<?php

use Inertia\Inertia;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Notifications\BottleWasUpdated;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\WineryController;
use App\Http\Controllers\BottleController;
use App\Http\Controllers\CollectionController;

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
            'name' => explode(' ', auth()->user()->name, 2)[0] . "'s Team",
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

// Google OAuth
// https://codyrigg.medium.com/how-to-add-a-google-login-using-socialite-on-laravel-8-with-jetstream-6153581e7dc9
Route::get('auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('auth.google');

Route::get('auth/google/callback', function () {
    dd($user = Socialite::driver('google')->user());
//    try {
//        // create a user using socialite driver google
//        $user = Socialite::driver('google')->user();
//        // if the user exits, use that user and login
//        $finduser = User::where('google_id', $user->id)->first();
//        if ($finduser) {
//            // if the user exists, login and show dashboard
//            Auth::login($finduser);
//            return redirect('/dashboard');
//        }
//        // user is not yet created, so create first
//        $newUser = User::create([
//            'name' => $user->name,
//            'email' => $user->email,
//            'google_id' => $user->id,
//            'password' => encrypt('')
//        ]);
//        // every user needs a team for dashboard/jetstream to work.
//        // create a personal team for the user
//        $newTeam = Team::forceCreate([
//            'user_id' => $newUser->id,
//            'name' => explode(' ', $user->name, 2)[0] . "'s Team",
//            'personal_team' => true,
//            'type' => 'cellar',
//        ]);
//        // save the team and add the team to the user.
//        $newTeam->save();
//        $newUser->current_team_id = $newTeam->id;
//        $newUser->save();
//        // login as the new user
//        Auth::login($newUser);
//        return redirect('/dashboard');
//    } catch (Exception $e) {
//        dd($e->getMessage());
//    }
});

Route::get('debug', function () {
    $bottle = App\Models\Bottle::find(8);
    auth()->user()->notify(new BottleWasUpdated($bottle));


//    App\Jobs\NotifyBottleUpdated::dispatch($bottle);
//    return $bottle;

//    return Inertia::render('Debug', []);
});
