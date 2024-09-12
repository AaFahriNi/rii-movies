<!-- Navbar  -->
<header>
    <a href="{{ route('/') }}" class="logo">
        <i class='bx bxs-movie'></i>Rii`Movies
    </a>
      <!-- Form pencarian -->
      <div class="search-container">
        <form action="{{ route('movie.search') }}" method="GET" class="search-form">
            <div class="input-container">
                <i class='bx bx-search search-icon'></i>
                <input type="text" name="query" id="search-input" placeholder="Search..." class="search-input">
            </div>
        </form>
    </div>
</header>
