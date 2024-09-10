<section class="coming" id="coming">
    <h2 class="heading">Coming Soon</h2>
    <!-- coming container  -->
    <div class="coming-container swiper">
        <div class="swiper-wrapper">
            @foreach($upcomingMovies as $movie)
                <div class="swiper-slide box">
                    <a href="{{ route('movie.show', ['id' => $movie['id']]) }}">
                        <div class="box-img">
                            <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="{{ $movie['original_title'] }}">
                        </div>
                        <h3>{{ $movie['original_title'] }}</h3>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>