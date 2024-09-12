<header>
    <a href="#home" class="logo">
        <i class='bx bxs-movie'></i>Rii`Movies
    </a>
    <div class="bx bx-menu" id="menu-icon"></div>

    <ul class="navbar">
        <li><a href="#home" class="home-active">Home</a></li>
        <li><a href="#trending">Trending</a></li>
        <li><a href="#movies">Movies</a></li>
        <li><a href="#coming">Coming</a></li>
    </ul>

    <div class="search-container">
        <form action="{{ route('movie.search') }}" method="GET" class="search-form">
            <div class="input-container">
                <i class='bx bx-search search-icon'></i>
                <input type="text" name="query" id="search-input" placeholder="Search..." class="search-input">
            </div>
        </form>
    </div>
</header>