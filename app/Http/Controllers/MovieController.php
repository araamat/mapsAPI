<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class MovieController extends Controller
{
    /**
     * Inertia view for movies index page.
     */
      public function index()
    {
        return Inertia::render('movies/Index', [
            'movies' => Movie::all(),
        ]);
    }

    /**
     * JSON API for fetching movie data (AJAX).
     */
    // public function index(Request $request)
    // {
    //     $query = Movie::query();

    //     if ($request->has('search')) {
    //         $query->where('title', 'like', '%' . $request->search . '%');
    //     }

    //     if ($request->has('sort_by')) {
    //         $query->orderBy($request->sort_by, $request->get('sort_order', 'asc'));
    //     }

    //     if ($request->has('limit')) {
    //         $query->limit($request->limit);
    //     }

    //     $cacheKey = 'movies_' . md5(json_encode($request->all()));

    //     return Cache::remember($cacheKey, 60, fn () => $query->get());
    // }

    /**
     * Store a new movie.
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

        return Movie::create($validated);
    }
}
