<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Details</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=abeezee:400|abril-fatface:400" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body>
    @include('layouts.navbar')
    <div class="container mt-4">
        <h1 class="text-center" id="movieTitle">Movie Title</h1>
        <div class="row mt-4">
            <div class="col-md-6">
                <img id="movieImage" src="" class="img-fluid" alt="Movie Image">
            </div>
            <div class="col-md-6">
                <h5 class="mt-3">Year: <span id="movieYear"></span></h5>
                <h5 class="mt-3">Duration: <span id="duration"></span></h5>
                <h5 class="mt-3">Rating: <span id="movieRating"></span></h5>
                <h5 class="mt-3">Language: <span id="language"></span></h5>
                <h5 class="mt-3">Director: <span id="director"></span></h5>
                <h5 class="mt-3">Staring: <span id="actors"></span></h5>
                <h5 class="mt-3">Country: <span id="country"></span></h5>
                <h5 class="mt-3">Rated: <span id="rated"></span></h5>
                <h5 class="mt-3">Awards: <span id="awards"></span></h5>

                <p class="mt-3" id="movieDescription"></p>
                <button class="btn btn-success" id="playMovieBtn">Play Movie</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const apiKey = "{{ config('services.omdb.api_key') }}"  // Replace with your actual OMDb API key
            const imdbId = '{{ $imdbId }}';

            fetch(`https://www.omdbapi.com/?apikey=${apiKey}&i=${imdbId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.Response === "True") {
                        document.getElementById('movieTitle').textContent = data.Title;
                        document.getElementById('movieImage').src = data.Poster !== 'N/A' ? data.Poster : 'default_image_url.jpg';
                        document.getElementById('duration').textContent = data.Runtime;
                        document.getElementById('language').textContent = data.Language;
                         document.getElementById('director').textContent= data.Director;
                         document.getElementById('actors').textContent = data.Actors;
                         document.getElementById('country').textContent = data.Country;
                         document.getElementById('rated').textContent = data.Rated;
                         document.getElementById('awards').textContent = data.Awards;
                        document.getElementById('movieYear').textContent = data.Year;
                        document.getElementById('movieRating').textContent = data.imdbRating;
                        document.getElementById('movieDescription').textContent = data.Plot;

                        document.getElementById('playMovieBtn').onclick = function() {
                            window.location.href = `/play/${imdbId}`;
                        };
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
