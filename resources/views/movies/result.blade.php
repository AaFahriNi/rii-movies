<section class="search-results" id="search-results">
    <h2 class="heading">Search results for "{{ $query }}"</h2>
    <!-- search-results container -->
    <div class="movies-container">
        @if (count($movies) > 0)
            @foreach ($movies as $movie)
                @if (!empty($movie['poster_path'])) <!-- Cek apakah poster_path tidak kosong -->
                    <div class="box" data-title="{{ $movie['title'] }}"
                        data-description="{{ $movie['overview'] ?? 'No description available' }}"
                        data-image="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}">
                        <a href="{{ route('movie.show', ['id' => $movie['id']]) }}">
                            <div class="box-img">
                                <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}"
                                    alt="{{ $movie['title'] }}">
                            </div>
                        </a>
                        <h3>{{ $movie['title'] }}</h3>
                        <span>
                            {{ $movie['runtime'] ?? 'N/A' }} min | 
                            {{ \Carbon\Carbon::parse($movie['release_date'] ?? '0')->format('d F Y') }}
                        </span>
                    </div>
                @endif
            @endforeach
        @else
            <h3 class="heading">No movies found for "{{ $query }}".</h3>
        @endif
    </div>
</section>
