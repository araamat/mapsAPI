<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        Movie::create([
            'title' => 'Inception',
            'image' => 'https://image.tmdb.org/t/p/w500/8tNX8s3j1O0eqilOQkuroRLyOZA.jpg',
            'description' => 'A mind-bending thriller by Christopher Nolan.',
            'director' => 'Christopher Nolan',
            'release_year' => 2010,
        ]);

        Movie::create([
            'title' => 'The Matrix',
            'image' => 'https://image.tmdb.org/t/p/w500/f89U3ADr1oiB1s9GkdPOEpXUk5H.jpg',
            'description' => 'A computer hacker learns about the true nature of reality.',
            'director' => 'Lana & Lilly Wachowski',
            'release_year' => 1999,
        ]);
    }
}
