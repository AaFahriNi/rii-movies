<!-- Background Image with Blur and Brightness -->
<div class="background-image" style="background-image: url('{{ asset('img/c9.png') }}');"></div>

<!-- Content Container -->
<div class="container movie-details content-container d-flex vh-100 justify-content-center align-items-center">
    <!-- Movie Poster -->
    <div class="movie-poster-wrapper d-flex justify-content-center">
        <img src="{{ asset('img/c9.png') }}" alt="Poster" class="movie-poster">
    </div>

    <!-- Movie Details -->
    <div class="d-flex flex-column justify-content-center">
        <h1 class="font-weight-bold mb-1">Deadpool 3</h1>

        <!-- Movie Genres -->
        <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2 mb-1">
            <span class="genre-badge">Action</span>
            <span class="genre-badge">Drama</span>
        </div>

        <!-- Movie Overview -->
        <p class="overview-text">Deadpool & Wolverine is a 2024 American superhero film based on the Marvel Comics character of the same name, co-produced by Marvel Studios, Maximum Effort, and 21 Laps Entertainment, and distributed by Walt Disney Studios Motion Pictures.</p>
    </div>
</div>