<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Genre;
use App\Models\Movie;

class HomeController extends Controller
{
    public function featuredHero()
    {
        $randomMovie = Movie::inRandomOrder()->first();
        return response()->json($randomMovie);
    }

    public function featuredGenres()
    {
        $topGenres = DB::table('genre_movie')
            ->join('genres', 'genres.id', '=', 'genre_movie.genre_id')
            ->select(
                'genre_movie.genre_id',
                'genres.genre',
                DB::raw('count(*) as total_movies')
            )
            ->groupBy('genre_movie.genre_id', 'genres.genre')
            ->having('total_movies', '>', 10)
            ->orderByDesc('total_movies')
            ->limit(3)
            ->get();

        return response()->json($topGenres);
    }
}
