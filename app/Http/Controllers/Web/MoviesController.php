<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MoviesController extends Controller
{
    public function index()
    {
        $apiKey = env('TMDB_API_KEY');

        // Ambil daftar genre dengan cache
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



        // Ambil data film Populer dengan cache
        $popularMovies = Cache::remember('popular_movies', 60, function () use ($apiKey) {
            $response = Http::get("https://api.themoviedb.org/3/movie/popular", [
                'api_key' => $apiKey,
            ]);
            return $response->json()['results'];
        });



        // Ambil data opening this week (now playing) dengan cache
        $thisWeekMovies = Cache::remember('this_week_movies', 60, function () use ($apiKey) {
            $thisWeekResponse = Http::get("https://api.themoviedb.org/3/movie/now_playing", [
                'api_key' => $apiKey,
            ]);
            $thisWeekMovies = $thisWeekResponse->json()['results'];

            // Loop melalui setiap film untuk mendapatkan runtime
            foreach ($thisWeekMovies as &$movie) {
                $movieDetailResponse = Http::get("https://api.themoviedb.org/3/movie/{$movie['id']}", [
                    'api_key' => $apiKey,
                ]);
                
                // Ambil runtime dari response detail movie
                $movieDetail = $movieDetailResponse->json();
                $movie['runtime'] = $movieDetail['runtime'] ?? null; // Simpan runtime dalam array movie
            }

            return $thisWeekMovies;
        });



        // Ambil data trending movies dengan cache
        $trendingMovies = Cache::remember('trending_movies', 60, function () use ($apiKey) {
            $trendingResponse = Http::get("https://api.themoviedb.org/3/trending/movie/week", [
                'api_key' => $apiKey
            ]);
            return $trendingResponse->json()['results'];
        });



        // Ambil data upcoming movies dengan cache
        $upcomingMovies = Cache::remember('upcoming_movies', 60, function () use ($apiKey) {
            $upcomingResponse = Http::get("https://api.themoviedb.org/3/movie/upcoming", [
                'api_key' => $apiKey,
            ]);
            return $upcomingResponse->json()['results'];
        });

        

        // Kirim semua data ke view
        return view('movies.home', [
            'genresMap' => $genresMap,
            'popularMovies' => $popularMovies,
            'thisWeekMovies' => $thisWeekMovies,
            'trendingMovies' => $trendingMovies,
            'upcomingMovies' => $upcomingMovies,
        ]);
    }
}
