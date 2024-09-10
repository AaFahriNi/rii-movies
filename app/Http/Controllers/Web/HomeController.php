<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function show($id)
    {
        $apiKey = env('TMDB_API_KEY');
        
        // Cache movie details
        $movie = Cache::remember("movie_{$id}", 60, function () use ($id, $apiKey) {
            $movieResponse = Http::get("https://api.themoviedb.org/3/movie/{$id}", [
                'api_key' => $apiKey,
                'language' => 'en-US',
            ]);
            return $movieResponse->json();
        });

        // Cache genre list
        $genresMap = Cache::remember('genres_map', 60, function () use ($apiKey) {
            $genresResponse = Http::get("https://api.themoviedb.org/3/genre/movie/list", [
                'api_key' => $apiKey,
                'language' => 'en-US',
            ]);
            $genres = $genresResponse->json()['genres'];

            $genresMap = [];
            foreach ($genres as $genre) {
                $genresMap[$genre['id']] = $genre['name'];
            }
            return $genresMap;
        });

        return view('movies.desc', [
            'movie' => $movie,
            'genresMap' => $genresMap,
        ]);
    }
}
