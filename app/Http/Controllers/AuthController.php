<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function welcome()
    {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    public function dashboard()
    {
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
    }

    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $user = Socialite::driver('google')->user();
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            $existingUser->google_id = $user->id;
            // $existingUser->profile_photo_path = $user->avatar;
            $existingUser->save();
            auth()->login($existingUser, true);
            return redirect()->route('dashboard');
        }

        $newUser = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'google_id' => $user->id,
            'password' => encrypt(''),
            // 'profile_photo_path' => $user->avatar,
        ]);

        $first = explode(' ', $user->name, 2)[0];

        $newTeam = Team::forceCreate([
            'user_id' => $newUser->id,
            'name' => "$first'" . (\Illuminate\Support\Str::endsWith($first, ['s', 'S']) ? '' : 's') . " Cellar",
            'personal_team' => true,
            'type' => 'cellar',
        ]);

        $newTeam->save();
        $newUser->switchTeam($newTeam);

        auth()->login($newUser, true);
        return redirect()->route('dashboard');
    }
}
