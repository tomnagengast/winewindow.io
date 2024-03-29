<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
//use Laravel\Jetstream\Http\Controllers\Inertia\TeamController;
use Inertia\Inertia;

class WineryController extends Controller
{
    public function index(Request $request)
    {
        $wineries = Team::query()
            ->with('ownedBottles')
            ->where('type', 'winery')
            ->limit(25)
            ->get();

        return Inertia::render('Wineries/Index', [
            'wineries' => $wineries,
        ]);
    }

    public function show(Team $winery)
    {
        return Inertia::render('Wineries/Show', [
            'winery' => $winery,
            'bottles' => $winery->ownedBottles()->get()
        ]);
    }

    public function embed(Team $winery)
    {
        return Inertia::render('Wineries/Embed', [
            'winery' => $winery,
            'bottles' => $winery->ownedBottles()->get()
        ]);
    }
}
