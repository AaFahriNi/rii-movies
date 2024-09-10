<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class MoviesController extends Controller
{
    public function index()
    {
        $apiKey = env('TMDB_API_KEY');

        // Ambil daftar genre
        $genresResponse = Http::get("https://api.themoviedb.org/3/genre/movie/list", [
            'api_key' => $apiKey,
            'language' => 'en-US',
        ]);
        $genres = $genresResponse->json()['genres'];

        // Buat array untuk memetakan genre_id ke nama genre
        $genresMap = [];
        foreach ($genres as $genre) {
            $genresMap[$genre['id']] = $genre['name'];
        }

        // ===================================================================================
        
        // Ambil data opening this week (now playing)
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

        // ===================================================================================

        // Ambil data trending movies
        $trendingResponse = Http::get("https://api.themoviedb.org/3/trending/movie/week", [
            'api_key' => $apiKey
        ]);
        $trendingMovies = $trendingResponse->json()['results'];

        // ===================================================================================

        // Ambil data upcoming movies
        $upcomingResponse = Http::get("https://api.themoviedb.org/3/movie/upcoming", [
            'api_key' => $apiKey,
        ]);
        $upcomingMovies = $upcomingResponse->json()['results'];

        // ===================================================================================

        // Kirim semua data ke view
        return view('movies.home', [
            'genresMap' => $genresMap,
            'thisWeekMovies' => $thisWeekMovies,
            'trendingMovies' => $trendingMovies,
            'upcomingMovies' => $upcomingMovies,
        ]);
    }

}
