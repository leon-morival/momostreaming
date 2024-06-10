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
    <div class="container mt-4">
        <h1 class="text-center text-white titles mt-4">Movies</h1>
        <div class="row" id="moviesList"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const API_KEY = '{{ config('services.tmdb.api_key') }}';
        const BASE_URL = 'https://api.themoviedb.org/3';
        const API_URL = `${BASE_URL}/discover/movie?sort_by=popularity.desc&api_key=${API_KEY}`;
        const IMG_URL = 'https://image.tmdb.org/t/p/w500';

        document.addEventListener("DOMContentLoaded", function() {
            fetchMovies(API_URL);
        });

        function fetchMovies(url) {
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.results && data.results.length > 0) {
                        displayMovies(data.results);
                    } else {
                        console.error('No movies found:', data.status_message);
                        showError('No movies found.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching the movies:', error);
                    showError('Error fetching the movies. Please try again later.');
                });
        }

        function displayMovies(movies) {
            const moviesList = document.getElementById('moviesList');
            moviesList.innerHTML = '';

            movies.forEach(movie => {
                const movieCard = `
                    <div class="col-md-3 movie-card">
                        <div class="card h-100">
                            <a href="/play_movie/${movie.id}">
                                <img src="${movie.poster_path ? IMG_URL + movie.poster_path : 'http://via.placeholder.com/1080x1580'}" class="card-img-top" alt="${movie.title}">
                            </a>
                            <div class="card-body movie-info">
                                <h5 class="card-title">${movie.title}</h5>
                                <span class="rating">${ movie.vote_average ? Math.round(movie.vote_average *10)/10: 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                `;
                moviesList.innerHTML += movieCard;
            });
        }

        function showError(message) {
            const moviesList = document.getElementById('moviesList');
            moviesList.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-danger" role="alert">
                        ${message}
                    </div>
                </div>
            `;
        }
    </script>
</body>
</html>
