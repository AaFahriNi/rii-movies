<!-- Movies  -->
<section class="movies" id="movies">
    <h2 class="heading">Opening This Week</h2>
    <!-- Movies container  -->
    <div class="movies-container">
        @foreach ($thisWeekMovies as $movie)
            <!-- Movie box  -->
            <div class="box" data-title="{{ $movie['title'] }}"
                data-description="{{ $movie['runtime'] ?? 'N/A' }} min | {{ $genresMap[$movie['genre_ids'][0]] ?? 'Unknown' }}"
                data-image="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}">
                <a href="{{ route('movie.show', ['id' => $movie['id']]) }}">
                    <div class="box-img">
                        <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}">
                    </div>
                </a>
                <h3>{{ $movie['title'] }}</h3>
                <span>{{ $movie['runtime'] ?? 'N/A' }} min | {{ $genresMap[$movie['genre_ids'][0]] ?? 'Unknown' }}</span>
            </div>
        @endforeach
    </div>
</section>
