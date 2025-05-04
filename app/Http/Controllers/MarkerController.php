<?php

namespace App\Http\Controllers;

use App\Models\Marker;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MarkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        Marker::create([
           
            'name' => $request->title,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,


            // 'name' => 'test',
            // 'description' => 'test',
            // 'latitude' => 0.0,
            // 'longitude' => 0.0,
        ]);
        
        //   Post::create($request->validate([
        //     'title' => 'required|max:255',
        //     'description' => 'required',
        // ]));
            return redirect()-> to(route('markers.index'));
        // //peale postitamist viib avalehele
        // return redirect()-> to(route('posts.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Marker $marker)
    {
    return Inertia::render('Markers/Show', [
        'marker' => $marker
    ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marker $marker)
    {
        return Inertia::render('Markers/Edit', [
            'marker' => $marker,
        ]);
    }

    public function update(Request $request, Marker $marker)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $marker->update([
            'name' => $validated['title'], // ← tõlge!
            'description' => $validated['description'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Marker uuendatud!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marker $marker)
    {
        $marker->delete();
        return redirect()->route('dashboard')->with('success', 'Marker kustutatud!');
    }

}