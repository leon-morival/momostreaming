@extends('layouts.app')
@section('title', 'Home - Movie List')

@section('content')
    <div class="container mt-5">



        <div id="carousels">
            <h1 class="text-white text-3xl mb-3">Popular Movies</h1>
            <div id="popularMoviesCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner" id="popularMoviesList"></div>
                <button class="carousel-control-prev" type="button" data-bs-target="#popularMoviesCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#popularMoviesCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <h2 class="text-white mt-4 text-3xl mb-3">Action Movies</h2>
            <div id="ActionMovieCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner" id="actionMoviesList"></div>
                <button class="carousel-control-prev" type="button" data-bs-target="#ActionMovieCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#ActionMovieCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <h2 class="text-white mt-4 text-3xl mb-3">Comedy Movies</h2>
            <div id="ComedyMovieCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner" id="comedyMoviesList"></div>
                <button class="carousel-control-prev" type="button" data-bs-target="#ComedyMovieCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#ComedyMovieCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <h2 class="text-white mt-4 text-3xl mb-3">Science-Fiction Movies</h2>
            <div id="SciFiMovieCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner" id="sciFiMoviesList"></div>
                <button class="carousel-control-prev" type="button" data-bs-target="#SciFiMovieCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#SciFiMovieCarousel"
                    data-bs-slide="next">
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
@endsection
