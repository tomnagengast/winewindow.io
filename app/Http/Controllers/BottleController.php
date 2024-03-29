<?php

namespace App\Http\Controllers;

use App\Jobs\NotifyBottleUpdated;
use App\Models\Bottle;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class BottleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
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

        return Inertia::render('Bottles/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Team $winery, Request $request)
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

        return redirect()->route('bottles.show', [$winery, $bottle]);
    }

    /**
     * Display the specified resource.
     *
     * @param Bottle $bottle
     */
    public function show(Team $winery, Bottle $bottle)
    {
        $bottle = Bottle::with('team')->where('slug', $bottle->slug)->where('winery', $winery->name)->first();

        return Inertia::render('Bottles/Show', [
            'bottle' => $bottle,
            'following' => auth()->user() ?
                auth()->user()->currentTeam->followedBottles()->get() : null,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Bottle $bottle
     */
    public function embed(Team $winery, Bottle $bottle)
    {
        $bottle = Bottle::with('team')->where('slug', $bottle->slug)->where('winery', $winery->name)->first();

        return Inertia::render('Bottles/Embed', [
            'bottle' => $bottle,
            'following' => auth()->user() ?
                auth()->user()->currentTeam->followedBottles()->get() : null,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Bottle $bottle
     */
    public function edit(Team $winery, Bottle $bottle)
    {
        if (auth()->user()->currentTeam->type === 'cellar') {
            return redirect('dashboard');
        }

        $bottle = Bottle::with('team')->where('slug', $bottle->slug)->where('winery', $winery->name)->first();

        return Inertia::render('Bottles/Edit', [
            'bottle' => $bottle,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Bottle $bottle
     */
    public function update(Request $request, Team $winery, Bottle $bottle)
    {
        $request->validate([
            'varietal' => 'required',
            'vintage' => 'required',
            'rating' => 'required',
            'description' => '',
        ]);

        $bottle = Bottle::with('team')->where('slug', $bottle->slug)->where('winery', $winery->name)->first();

        if ($bottle->rating != $request->rating) {
            NotifyBottleUpdated::dispatch($bottle);
        }

        $bottle->update([
            'varietal' => $request['varietal'],
            'vintage' => $request['vintage'],
            'rating' => $request['rating'],
            'description' => $request['description'],
        ]);

        return redirect()->route('bottles.show', [$winery, $bottle]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Bottle $bottle
     */
    public function destroy(Team $winery, Bottle $bottle)
    {
        if (auth()->user()->currentTeam->id != $bottle->team->id) {
            return redirect('dashboard');
        }

        $bottle = Bottle::with('team')->where('slug', $bottle->slug)->where('winery', $winery->name)->first();

        $bottle->delete();

        return redirect()->route('dashboard');
    }

    /**
     * Follow the specified resource.
     *
     * @param Bottle $bottle
     */
    public function follow(Team $winery, Bottle $bottle)
    {
        if (auth()->user()->currentTeam->type === 'winery') {
            return redirect('dashboard');
        }

        $bottle = Bottle::with('team')->where('slug', $bottle->slug)->where('winery', $winery->name)->first();

        $bottle->follow();

        return redirect()->route('bottles.show', [$winery, $bottle]);
    }

    /**
     * Unfollow the specified resource.
     *
     * @param Bottle $bottle
     */
    public function unfollow(Team $winery, Bottle $bottle)
    {
        $bottle = Bottle::with('team')->where('slug', $bottle->slug)->where('winery', $winery->name)->first();

        $bottle->unfollow();

        return redirect()->route('bottles.show', [$winery, $bottle]);
    }
}
