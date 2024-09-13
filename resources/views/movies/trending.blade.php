<section class="coming" id="trending">
    <h2 class="heading">Trending Movies</h2>
    <!-- coming container -->
    <div class="coming-container swiper">
        <div class="swiper-wrapper">
            @foreach($trendingMovies as $movie)
                <div class="swiper-slide box">
                    <a href="{{ route('movie.show', ['id' => $movie['id']]) }}">
                        <div class="box-img">
                            <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}">
                        </div>
                        <h3>{{ $movie['title'] }}</h3>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>