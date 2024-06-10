<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>

    </style>
</head>
<body>
    @include('layouts.navbar')
    <div class="m-4 ">
        <h1 class="text-center" class="movie-title"></h1>
        <div class="row mt-4">
            <div class="col-md-2 bg-dark m-0">
       
            </div>
            {{-- Movie Player --}}
            <div class="col-md-7 p-0">
                <div class="ratio ratio-16x9 ">
                    <iframe id="moviePlayer" src="" frameborder="0" allowfullscreen></iframe>
                </div>
                <div class="text-center">

                    <h5 class="mt-3">Director: <span id="director"></span></h5>
                    <h5 class="mt-3">Starring: <span id="actors"></span></h5>
                    <h5 class="mt-3">Awards: <span id="awards"></span></h5>
                </div>
            </div>
            {{-- Movie Information --}}
            <div class="col-md-3">
                <img id="movieImage" src="" class="img-fluid h-25" alt="Movie Image">
                <h5 class="mt-3 mb-3"><span class="movie-title"></span></h5>
                {{-- Badges --}}
                <div class="d-flex">
                    <span class="badge  bg-danger" id="rated"></span>
                    <span class="badge mx-1  bg-success" id="movieYear"></span>
                    <span class="badge  bg-primary" id="duration"></span>
                    <span class="mx-1">&#8226;</span>
                    <span class="" id="language"></span>
                </div>
                <p class="mt-3" id="movieDescription"></p>
                <div class="container mt-3 d-flex justify-content-center">
                    <div class="bg-light p-1 rounded">
                        <h5 class=" text-dark">IMDb: 
                            <span class="d-inline-block bg-light text-dark rounded-pill p-2">
                                <span id="movieRating"></span>
                                <i class="fa-solid fa-star fa-xs" ></i>
                            </span>
                        </h5>
                    </div>
                </div>

                
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const apiKey = "{{ config('services.omdb.api_key') }}";
            const imdbId = '{{ $imdbId }}';

            fetch(`https://www.omdbapi.com/?apikey=${apiKey}&i=${imdbId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.Response === "True") {
                        document.querySelectorAll('.movie-title').forEach(el => el.textContent = data.Title);
                        document.getElementById('movieImage').src = data.Poster !== 'N/A' ? data.Poster : 'default_image_url.jpg';
                        document.getElementById('duration').textContent = data.Runtime;
                        document.getElementById('language').textContent = data.Language;
                        document.getElementById('director').textContent= data.Director;
                        document.getElementById('actors').textContent = data.Actors;
                        document.getElementById('rated').textContent = data.Rated;
                        document.getElementById('awards').textContent = data.Awards;
                        document.getElementById('movieYear').textContent = data.Year;
                        document.getElementById('movieRating').textContent = data.imdbRating;
                        document.getElementById('movieDescription').textContent = data.Plot;
                        document.getElementById('moviePlayer').src = `https://vidsrc.to/embed/movie/${imdbId}`;

                   
                    } else {
                        document.body.innerHTML = '<h1 class="text-center">Movie not found</h1>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching the movie details:', error);
                    document.body.innerHTML = '<h1 class="text-center">Error fetching the movie details</h1>';
                });
        });
    </script>
</body>
</html>
