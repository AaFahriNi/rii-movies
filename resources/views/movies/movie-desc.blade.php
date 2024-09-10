<!-- Background Image with Blur and Brightness -->
<div class="background-image" style="background-image: url('https://image.tmdb.org/t/p/w500{{ $movie['backdrop_path'] }}');"></div>

<!-- Content Container -->
<div class="container movie-details content-container d-flex vh-100 justify-content-center align-items-center">
    <!-- Movie Poster -->
    <div class="movie-poster-wrapper d-flex justify-content-center">
        <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="Poster" class="movie-poster">
    </div>

    <!-- Movie Details -->
    <div class="d-flex flex-column justify-content-center">
        <h1 class="font-weight-bold mb-1">{{ $movie['title'] }}</h1>

    <!-- Movie Genres -->
    <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2 mb-1">
        @foreach ($movie['genres'] as $genre)
            <span class="genre-badge">{{ $genre['name'] ?? 'Unknown' }}</span>
        @endforeach
    </div>
        <!-- Movie Overview -->
        <p class="overview-text">{{ $movie['overview'] }}</p>
    </div>
</div>