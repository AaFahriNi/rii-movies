<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $apiKey = config('services.tmdb.api_key');

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


        // Kembalikan view dengan data film yang ditemukan
        return view('movies.home')->with('genresMap', $genresMap)
                                  ->with('popularMovies', $popularMovies)
                                  ->with('thisWeekMovies', $thisWeekMovies)
                                  ->with('trendingMovies', $trendingMovies)
                                  ->with('upcomingMovies', $upcomingMovies);
    }


    public function search(Request $request)
    {
        $query = $request->input('query');
        $apiKey = config('services.tmdb.api_key');

        // Cek apakah query ada
        if (!$query) {
            return redirect()->back()->with('error', 'Please enter a search query.');
        }

        // Cek cache untuk hasil pencarian berdasarkan query
        $cacheKey = 'search_' . md5($query);
        $movies = Cache::remember($cacheKey, 60, function () use ($apiKey, $query) {
            // Panggil API TMDB untuk mencari film berdasarkan query
            $response = Http::get("https://api.themoviedb.org/3/search/movie", [
                'api_key' => $apiKey,
                'query' => $query,
            ]);

            // Jika API berhasil dipanggil, ambil hasil pencarian
            if ($response->successful()) {
                $movies = $response->json()['results'];

                // Untuk setiap film, ambil detail termasuk durasi
                foreach ($movies as &$movie) {
                    $movieDetailsResponse = Http::get("https://api.themoviedb.org/3/movie/{$movie['id']}", [
                        'api_key' => $apiKey,
                        'language' => 'en-US',
                    ]);

                    if ($movieDetailsResponse->successful()) {
                        $movieDetails = $movieDetailsResponse->json();
                        $movie['runtime'] = $movieDetails['runtime'] ?? 'N/A'; // Tambahkan durasi film ke data film
                    } else {
                        $movie['runtime'] = 'N/A'; // Jika tidak dapat mengambil detail, tetapkan 'N/A'
                    }
                }

                // Urutkan hasil pencarian berdasarkan release_date
                usort($movies, function ($a, $b) {
                    return strtotime($a['release_date'] ?? '0') <=> strtotime($b['release_date'] ?? '0');
                });

                return $movies; // Kembalikan data film
            }

            return []; // Kembalikan array kosong jika gagal
        });

        // Kembalikan view dengan data film yang ditemukan
        return view('movies.search-result') ->with('movies', $movies)
                                            ->with('query', $query);
    }


    public function show($id)
    {
        $apiKey = config('services.tmdb.api_key');
        
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


    // public function searchSuggestions(Request $request)
    // {
    //     $query = $request->input('query');
    //     $apiKey = config('services.tmdb.api_key');

    //     // Cek apakah query ada
    //     if (!$query) {
    //         return response()->json([]);
    //     }

    //     // Panggil API TMDB untuk mencari film berdasarkan query
    //     $response = Http::get("https://api.themoviedb.org/3/search/movie", [
    //         'api_key' => $apiKey,
    //         'query' => $query,
    //     ]);

    //     // Cek apakah respons dari API berhasil
    //     if ($response->successful()) {
    //         $movies = $response->json()['results'];

    //         // Kembalikan hanya beberapa saran (misalnya, 5 saran)
    //         return response()->json(array_slice($movies, 0, 5));
    //     }

    //     return response()->json([]);
    // }
}
