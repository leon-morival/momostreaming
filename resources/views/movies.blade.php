<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .movie-card {
            margin-bottom: 30px;
        }
        .movie-card img {
            width: 100%;
            height: auto;
        }
        .movie-info {
            padding: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
        }
        .movie-info h5 {
            margin: 0;
        }
        .movie-info .rating {
            float: right;
            font-size: 1.2rem;
            color: #ffc107;
        }
    </style>
</head>
<body>
    @include('layouts.navbar')
    <div class="container mt-5">
        
   
        
        <div id="carousels">
            <h2 class="text-white">Popular Movies</h2>
            <div id="popularMoviesCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner" id="popularMoviesList"></div>
                <button class="carousel-control-prev" type="button" data-bs-target="#popularMoviesCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#popularMoviesCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <h2 class="text-white mt-4">Action Movies</h2>
            <div id="ActionMovieCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner" id="actionMoviesList"></div>
                <button class="carousel-control-prev" type="button" data-bs-target="#ActionMovieCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#ActionMovieCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>

                <h2 class="text-white mt-4">Comedy Movies</h2>
                <div id="ComedyMovieCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" id="comedyMoviesList"></div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#ComedyMovieCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#ComedyMovieCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <h2 class="text-white mt-4">Science-Fiction Movies</h2>
                <div id="SciFiMovieCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" id="sciFiMoviesList"></div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#SciFiMovieCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#SciFiMovieCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="row mt-4" id="moviesList"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Pass the API key to the script
        const API_KEY = "{{ config('services.tmdb.api_key') }}";
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
