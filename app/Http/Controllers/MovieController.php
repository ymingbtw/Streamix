<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    //
    public function index(Request $request)
    {
        $title = $request->query('title');
        $genre = $request->query('genre');
        $part = max(1, (int) $request->query('part', 1)); // default to 1 if missing

        $query = Movie::with([
            'genres' => fn($q) => $q->select('id', 'genre'),
        ])
            ->when(
                $title,
                fn(Builder $q) => $q->where('title', 'like', $title . '%')
            )
            ->when(
                $genre,
                fn(Builder $q) => $q->whereHas(
                    'genres',
                    fn(Builder $q2) => $q2->where('genre', $genre)
                )
            );

        $total = $query->count();

        $movies = $query
            ->skip(($part - 1) * 10)
            ->take(11)
            ->get();
        $movies = $movies->map(function ($movie) {
            $movie->setRelation(
                'genres',
                collect($movie->genres)->pluck('genre', 'id')
            );
            return $movie;
        });

        $sub_total = $movies->count();
        $next_part = $sub_total > 10 ? $part + 1 : null;

        return response()->json([
            'current_part' => $part,
            'next_part' => $next_part,
            'sub_total' => min(10, $sub_total),
            'total' => $total,
            'movies' => $movies->take(10)->values(), // reset indices
        ]);
    }

    public function movieById($id)
    {
        $movie = Movie::with('genres')->find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        return response()->json([
            'id' => $movie->id,
            'title' => $movie->title,
            'description' => $movie->description,
            'duration' => $movie->duration,
            'release_date' => $movie->release_date,
            'maturity_rating' => $movie->maturity_rating,
            'backdrop' => $movie->backdrop,
            'video' => $movie->video,
            'genres' => $movie->genres->pluck('genre', 'id'),
        ]);
    }
    public function hero()
    {
        $randomMovie = Movie::inRandomOrder()->first();
        return response()->json($randomMovie);
    }

    public function insert(Request $request)
    {
        $validator = Validator::make($request->input('movieForm'), [
            'title' => 'required|string',
            'description' => 'required|string',
            'duration' => 'required|integer',
            'release_date' => 'required|integer',
            'maturity_rating' => 'required|string',
            'backdrop' => 'required|string',
            'video' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'movie' => $request->all(),
                    'errors' => $validator->errors(),
                ],
                422
            );
        }

        $movie = $validator->validated();

        $movieModel = Movie::create([
            'id' => Str::uuid(),
            'title' => $movie['title'],
            'description' => $movie['description'],
            'duration' => $movie['duration'],
            'release_date' => $movie['release_date'],
            'maturity_rating' => $movie['maturity_rating'],
            'backdrop' => $movie['backdrop'],
            'video' => $movie['video'],
        ]);
        $genres = $request->input('movieForm')['genres'];
        $movieModel->genres()->sync($genres);

        return response()->json([
            'success' => true,
            'msg' => 'Movie added successfully.',
            'movie_id' => $movieModel->id,
        ]);
    }

    public function update(Request $request)
    {
        $movieId = $request->input('id'); // The UUID of the movie to update

        // Find the movie by ID
        $movie = Movie::find($movieId);

        if ($movie) {
            // Update fields
            $movie->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'duration' => $request->input('duration'),
                'release_date' => $request->input('release_date'),
                'maturity_rating' => $request->input('maturity_rating'),
                'backdrop' => $request->input('backdrop'),
                'video' => $request->input('video'),
            ]);
            $movie->genres()->sync($request->input('genres'));

            return response()->json([
                'success' => true,
                'msg' => 'movie has been updated',
            ]);
        } else {
            // Handle movie not found
            return response()->json([
                'success' => false,
                'error' => 'movie not found',
            ]);
        }
    }

    public function delete($id)
    {
        $movie = Movie::find($id);

        if ($movie) {
            $movie->delete();

            return response()->json([
                'status' => 204,
                'error' => 'movie has been deleted',
            ]);
        } else {
            return response()->json([
                'status' => 304,
                'error' => 'movie not found',
            ]);
        }
    }
}
