<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class MovieController extends Controller
{
    /**
     * Show Inertia view for movies index page.
     */
    public function index()
{
    $localMovies = Movie::all();

    $externalResponse = Http::get('https://hajus.tak23mand.itmajakas.ee/api/favourite/07b4cc44-9042-4944-b1dc-56eac757ca4f');
    $externalMovies = $externalResponse->successful() ? $externalResponse->json() : [];

    return Inertia::render('movies/Index', [
        'movies' => $localMovies,
        'externalMovies' => $externalMovies,
    ]);
}


    /**
     * Show the Inertia view for creating a new movie.
     */
    public function create()
    {
        return Inertia::render('movies/Create');
    }

    /**
     * Store a new movie to the database and redirect.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'image' => 'nullable|string',
            'description' => 'required|string',
            'director' => 'required|string',
            'release_year' => 'required|integer',
        ]);

        Movie::create($validated);

        return redirect()->route('movies.index')->with('success', 'Movie added successfully!');
    }

    /**
     * JSON API endpoint with search, sort, limit and cache support.
     */
    public function api(Request $request)
    {
        $query = Movie::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by, $request->get('sort_order', 'asc'));
        }

        if ($request->has('limit')) {
            $query->limit($request->limit);
        }

        $cacheKey = 'movies_api_' . md5(json_encode($request->all()));

        return response()->json(
            Cache::remember($cacheKey, 60, fn () => $query->get())
        );
    }

    /**
     * External API data fetch and show in Inertia page.
     */
    public function external()
    {
        $response = Http::get('https://hajus.tak23mand.itmajakas.ee/api/favourite/07b4cc44-9042-4944-b1dc-56eac757ca4f');

        return Inertia::render('movies/External', [
            'externalMovies' => $response->json()
        ]);
    }


    public function combined()
    {
        $localMovies = Movie::all();

        $externalResponse = Http::get('https://hajus.tak23mand.itmajakas.ee/api/favourite/07b4cc44-9042-4944-b1dc-56eac757ca4f');
        $externalMovies = $externalResponse->successful() ? $externalResponse->json() : [];

        return Inertia::render('movies/Combined', [
            'localMovies' => $localMovies,
            'externalMovies' => $externalMovies,
    ]);
}

}
