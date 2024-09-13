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
                <input type="text" name="query" id="search-input" placeholder="Search..." class="search-input" autocomplete="off">
            </div>
            <!-- Container untuk menampilkan hasil saran -->
            {{-- <ul id="suggestions-list" class="suggestions-list"></ul>     --}}
        </form>
    </div>
</header>

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#search-input').on('input', function() {
            let query = $(this).val();

            if (query.length > 2) { // Mulai pencarian jika input lebih dari 2 karakter
                $.ajax({
                    url: "{{ route('movie.searchSuggestions') }}", // Buat route baru untuk saran pencarian
                    method: "GET",
                    data: { query: query },
                    success: function(data) {
                        $('#suggestions-list').empty(); // Kosongkan saran lama
                        if (data.length > 0) {
                            data.forEach(function(movie) {
                                $('#suggestions-list').append('<li>' + movie.title + '</li>');
                            });
                        }
                    }
                });
            } else {
                $('#suggestions-list').empty(); // Hapus saran jika input kurang dari 3 karakter
            }
        });

        // Tambahkan event handler untuk memilih saran
        $(document).on('click', '#suggestions-list li', function() {
            $('#search-input').val($(this).text());
            $('#suggestions-list').empty(); // Kosongkan daftar setelah memilih saran
        });
    });
</script> --}}
