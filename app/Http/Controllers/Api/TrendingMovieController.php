<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function getTrendingMovies()
    {
        // Ambil API key dari file .env
        $apiKey = env('TMDB_API_KEY');

        // Panggil API TMDb
        $response = Http::get('https://api.themoviedb.org/3/trending/movie/week', [
            'api_key' => $apiKey,
        ]);

        // Cek jika respon berhasil
        if ($response->successful()) {
            // Ambil hasil respon dari API
            $movies = $response->json()['results'];
        } else {
            // Tangani jika terjadi kesalahan
            $movies = [];
            // Kamu juga bisa menambahkan log atau error handling di sini
        }

        // Kirim data film ke view
        return view('movies.trending', compact('movies'));
    }
}

