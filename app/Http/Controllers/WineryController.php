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
            ->with('bottles')
            ->where('type', '=', 'winery')
            ->limit(25)
            ->get();

        return Inertia::render('Wineries/Index', [
            'wineries' => $wineries,
        ]);
    }
}
