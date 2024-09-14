<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Movies</title>
    <link href="https://moviesriii.up.railway.app/img/icon.png" rel="icon">
    <link rel="stylesheet" href="https://moviesriii.up.railway.app/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
</head>
<body>
    @include('components.sidebar')
    @include('components.header')

    @yield('content')

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="https://moviesriii.up.railway.app/js/main.js"></script>
</body>
</html>