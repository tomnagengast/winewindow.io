<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use Inertia\Inertia;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $collections->bottles->pluck('name');
        return Inertia::render('Collections/Index', [
            'collections' => auth()->user()->currentTeam->collections->load('bottles'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Collection  $collection
     */
    public function show(Collection $collection)
    {
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Collection  $collection
     */
    public function edit(Collection $collection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collection  $collection
     */
    public function update(Request $request, Collection $collection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Collection  $collection
     */
    public function destroy(Collection $collection)
    {
        //
    }
}
