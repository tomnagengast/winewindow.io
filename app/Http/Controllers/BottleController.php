<?php

namespace App\Http\Controllers;

use App\Jobs\NotifyBottleUpdated;
use App\Models\Bottle;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BottleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Bottles/Index', [
            'bottles' => Bottle::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Team $winery)
    {
        if (auth()->user()->currentTeam->type === 'cellar') {
            return redirect('dashboard');
        }

        return Inertia::render('Bottles/Create', [
//            'winery' => $bottle->findById()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'varietal' => 'required',
            'vintage' => 'required',
            'rating' => 'required',
            'description' => '',
        ]);
        $request['team_id'] = auth()->user()->currentTeam->id;
        $request['winery'] = auth()->user()->currentTeam->name;

        $bottle = Bottle::create($request->all());

        return redirect()->route('bottles.show', $bottle->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bottle  $bottle
     */
    public function show(Bottle $bottle)
    {
        return Inertia::render('Bottles/Show', [
            'bottle' => $bottle,
            'following' => auth()->user() ?
                auth()->user()->currentTeam->followedBottles()->get() : null,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bottle  $bottle
     */
    public function edit(Bottle $bottle)
    {
        if (auth()->user()->currentTeam->type === 'cellar') {
            return redirect('dashboard');
        }
        // $toUpdate = auth()->user()->currentTeam->bottles()->findOrFail($bottle);
        return Inertia::render('Bottles/Edit', [
            'bottle' => $bottle,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bottle  $bottle
     */
    public function update(Request $request, Bottle $bottle)
    {
        $request->validate([
            'varietal' => 'required',
            'vintage' => 'required',
            'rating' => 'required',
            'description' => 'required',
        ]);

        if ($bottle->rating != $request->rating) {
            NotifyBottleUpdated::dispatch($bottle);
        }

        $bottle->update([
            'varietal' => $request['varietal'],
            'vintage' => $request['vintage'],
            'rating' => $request['rating'],
            'description' => $request['description'],
        ]);

        return redirect()->route('bottles.show', $bottle->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bottle  $bottle
     */
    public function destroy(Bottle $bottle)
    {
        if (auth()->user()->currentTeam->id != $bottle->team->id) {
            return redirect('dashboard');
        }

        $bottle->delete();

        return redirect()->route('dashboard');
    }

    /**
     * Follow the specified resource.
     *
     * @param  \App\Models\Bottle  $bottle
     */
    public function follow(Bottle $bottle)
    {
        if (auth()->user()->currentTeam->type === 'winery') {
            return redirect('dashboard');
        }

        $bottle->follow();

        return redirect()->route('bottles.show', $bottle);
    }

    /**
     * Unfollow the specified resource.
     *
     * @param  \App\Models\Bottle  $bottle
     */
    public function unfollow(Bottle $bottle)
    {
        $bottle->unfollow();

        return redirect()->route('bottles.show', $bottle);
    }
}
