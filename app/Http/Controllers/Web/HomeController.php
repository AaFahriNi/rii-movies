<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $apiKey = env('TMDB_API_KEY');

        // Cek apakah query ada
        if (!$query) {
            return redirect()->back()->with('error', 'Please enter a search query.');
        }

        // Panggil API TMDB untuk mencari film berdasarkan query
        $response = Http::get("https://api.themoviedb.org/3/search/movie", [
            'api_key' => $apiKey,
            'query' => $query,
        ]);

        // Cek apakah respons dari API berhasil
        if ($response->successful()) {
            $movies = $response->json()['results']; // Ambil hasil pencarian

            // Untuk setiap film, ambil detail termasuk durasi
            foreach ($movies as &$movie) {
                $movieDetailsResponse = Http::get("https://api.themoviedb.org/3/movie/{$movie['id']}", [
                    'api_key' => $apiKey,
                    'language' => 'en-US',
                ]);

                if ($movieDetailsResponse->successful()) {
                    $movieDetails = $movieDetailsResponse->json();
                    $movie['runtime'] = $movieDetails['runtime']; // Tambahkan durasi film ke data film
                } else {
                    $movie['runtime'] = 'N/A'; // Jika tidak dapat mengambil detail, tetapkan 'N/A'
                }
            }
        } else {
            return redirect()->back()->with('error', 'Error fetching movies from TMDB.');
        }

        // Kembalikan view dengan data film yang ditemukan
        return view('movies.search-resault')->with('movies', $movies)
                                            ->with('query', $query);

    }


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

        // Kembalikan view dengan data film yang ditemukan
        return view('movies.desc')->with('movie', $movie)
                                  ->with('genresMap', $genresMap);
    }
}
