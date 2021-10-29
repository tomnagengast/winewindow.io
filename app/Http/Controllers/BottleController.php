<?php

namespace App\Http\Controllers;

use App\Models\Bottle;
use Illuminate\Http\Request;
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
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Bottles/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        Bottle::create($request->all());

        return redirect()->route('bottles.index');
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
            'following' => auth()->user()->currentTeam->followedBottles()->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bottle  $bottle
     */
    public function edit(Bottle $bottle)
    {
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
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        $bottle->update($request->all());

        return redirect()->route('bottles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bottle  $bottle
     */
    public function destroy(Bottle $bottle)
    {
        $bottle->delete();

        return redirect()->route('bottles.index');
    }

    /**
     * Follow the specified resource.
     *
     * @param  \App\Models\Bottle  $bottle
     */
    public function follow(Bottle $bottle)
    {
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
