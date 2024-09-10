<!-- Home  -->
<section class="home swiper" id="home">
    <div class="swiper-wrapper">
        @foreach (array_slice($popularMovies, 3, 5) as $movie)
        <div class="swiper-slide container">
            <img src="https://image.tmdb.org/t/p/w1280{{ $movie['backdrop_path'] }}" alt="{{ $movie['title'] }}">
            <div class="home-text">
                <span>{{ $genresMap[$movie['genre_ids'][0]] ?? 'Unknown' }}</span>
                <h1>{{ $movie['title'] }}</h1>
            </div>
        </div>
        @endforeach
    </div>
    <div class="swiper-pagination"></div>
</section>
