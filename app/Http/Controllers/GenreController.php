<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Genre;

class GenreController extends Controller
{
    //

    public function mainGenres()
    {
        $genres = Genre::orderBy('genre')->limit(10)->get();
        return response()->json($genres);
    }

    public function query($genre)
    {
        $genres = Genre::where('genre', 'LIKE', $genre . '%')
            ->limit(10)
            ->get();

        return response()->json($genres);
    }
    public function topGenres()
    {
        $topGenres = DB::table('genre_movie')
            ->join('genres', 'genres.id', '=', 'genre_movie.genre_id')
            ->select(
                'genre_movie.genre_id',
                'genres.genre',
                DB::raw('count(*) as total_movies')
            )
            ->groupBy('genre_movie.genre_id', 'genres.genre')
            ->orderByDesc('total_movies')
            ->limit(3)
            ->get();

        return response()->json($topGenres);
    }
}
