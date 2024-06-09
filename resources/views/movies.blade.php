<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies List</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=abeezee:400|aboreto:400|abril-fatface:400" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

   <style>
       
    </style>
</head>
<body>
    @include('layouts.navbar')
    <h1 class="text-center text-white titles mt-4">Movies</h1>
    <div class="container mt-4">
        <div class="row" id="moviesList">
            <!-- Movie cards will be appended here -->
        </div>
        <nav aria-label="Page navigation">
          <ul class="pagination" id="pagination">
            <!-- Pagination items will be appended here -->
          </ul>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let apiKey = "{{ config('services.omdb.api_key') }}";
        let currentPage = 1;
        let currentQuery = '';

        document.addEventListener("DOMContentLoaded", function() {
            const searchForm = document.getElementById('searchForm');
            searchForm.addEventListener('submit', function(event) {
                event.preventDefault();
                currentQuery = document.getElementById('searchInput').value.toLowerCase();
                currentPage = 1;
                fetchMovies(currentQuery, currentPage);
            });

            // Fetch initial set of movies
            currentQuery = 'popular';  // Default search query
            fetchMovies(currentQuery, currentPage);
        });

        function fetchMovies(query, page) {
            fetch(`https://www.omdbapi.com/?apikey=${apiKey}&s=${query}&page=${page}`)
                .then(response => response.json())
                .then(data => {
                    if (data.Response === "True") {
                        fetchMovieDetails(data.Search);
                        setupPagination(data.totalResults, page);
                    } else {
                        console.error('No movies found:', data.Error);
                        showError(`No movies found: ${data.Error}`);
                    }
                })
                .catch(error => {
                    console.error('Error fetching the movies:', error);
                    showError('Error fetching the movies. Please try again later.');
                });
        }

        function fetchMovieDetails(movies) {
            const moviesList = document.getElementById('moviesList');
            moviesList.innerHTML = '';

            movies.forEach(movie => {
                fetch(`https://www.omdbapi.com/?apikey=${apiKey}&i=${movie.imdbID}`)
                    .then(response => response.json())
                    .then(details => {
                        if (details.Response === "True") {
                            const movieCard = `
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <img src="${details.Poster !== 'N/A' ? details.Poster : 'default_image_url.jpg'}" class="card-img-top" alt="${details.Title}">
                                        <div class="card-body text-white">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title">${details.Title}</h5>
                                                    <h6 class="card-subtitle mb-2 text-muted">${details.Year}</h6>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="position-absolute text-white">
                                                        <i class="fa-solid fa-star"></i><span>${details.imdbRating ? details.imdbRating : 'N/A'}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="/movies/${details.imdbID}" class="btn btn-danger mt-2">More Info</a>
                                        </div>
                                    </div>
                                </div>
                            `;
                            moviesList.innerHTML += movieCard;
                        } else {
                            console.error('Error fetching movie details:', details.Error);
                        }
                    })
                    .catch(error => console.error('Error fetching movie details:', error));
            });
        }

        function setupPagination(totalResults, currentPage) {
            const totalPages = Math.ceil(totalResults / 10);  // OMDb API returns 10 results per page
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';

            for (let i = 1; i <= totalPages; i++) {
                const paginationItem = `
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="event.preventDefault(); fetchMovies('${currentQuery}', ${i})">${i}</a>
                    </li>
                `;
                pagination.innerHTML += paginationItem;
            }
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
