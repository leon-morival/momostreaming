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
        const API_KEY = '{{ config('services.tmdb.api_key') }}';
        const BASE_URL = 'https://api.themoviedb.org/3';
        const IMG_URL = 'https://image.tmdb.org/t/p/w500';

        document.addEventListener("DOMContentLoaded", function() {
            fetchMovies(`${BASE_URL}/discover/movie?sort_by=popularity.desc&api_key=${API_KEY}`, 'popularMoviesList');
            fetchMovies(`${BASE_URL}/discover/movie?with_genres=28&sort_by=popularity.desc&api_key=${API_KEY}`, 'actionMoviesList');
            fetchMovies(`${BASE_URL}/discover/movie?with_genres=35&sort_by=popularity.desc&api_key=${API_KEY}`, 'comedyMoviesList');
            fetchMovies(`${BASE_URL}/discover/movie?with_genres=878&sort_by=popularity.desc&api_key=${API_KEY}`, 'sciFiMoviesList');
            
            document.getElementById('searchForm').addEventListener('submit', function(event) {
                event.preventDefault();
                const query = document.getElementById('searchInput').value;
                if (query) {
                    fetchMovies(`${BASE_URL}/search/movie?api_key=${API_KEY}&query=${query}`, 'moviesList', true);
                }
            });
        });

        function fetchMovies(url, listId, hideCarousels = false) {
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.results && data.results.length > 0) {
                        displayMovies(data.results, listId, hideCarousels);
                    } else {
                        showError('No movies found.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching the movies:', error);
                    showError('Error fetching the movies. Please try again later.');
                });
        }

        function displayMovies(movies, listId, hideCarousels) {
            const moviesList = document.getElementById(listId);
            moviesList.innerHTML = '';

            if (hideCarousels) {
                document.getElementById('carousels').style.display = 'none';
                document.getElementById('moviesList').style.display = 'flex';
            }

            let items = '';
            movies.forEach((movie, index) => {
                const movieCard = `
                    <div class="col-md-3 movie-card">
                        <div class="card h-100">
                            <a href="/play_movie/${movie.id}">
                                <img src="${movie.poster_path ? IMG_URL + movie.poster_path : 'http://via.placeholder.com/1080x1580'}" class="card-img-top" alt="${movie.title}">
                            </a>
                            <div class="card-body movie-info">
                                <h5 class="card-title">${movie.title}</h5>
                                <span class="rating">${ movie.vote_average ? Math.round(movie.vote_average *10)/10 : 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                `;

                if (index % 4 === 0) {
                    if (index !== 0) items += '</div></div>';
                    items += `<div class="carousel-item ${index === 0 ? 'active' : ''}"><div class="row">`;
                }
                items += movieCard;
            });
            items += '</div></div>';
            moviesList.innerHTML = items;
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
