<?php

namespace App\Services;

use GuzzleHttp\Client;

class TMDBService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://api.themoviedb.org/3/']);
        $this->apiKey = config('services.tmdb.api_key');
    }

    public function getTrendingMovies()
    {
        $response = $this->client->get('trending/movie/week', [
            'query' => [
                'api_key' => $this->apiKey,
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true)['results'];
    }
}