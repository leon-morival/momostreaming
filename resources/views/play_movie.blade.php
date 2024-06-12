@extends('layouts.app')
@section('title', 'Home - Movie List')

@section('content')
    <div class="container mt-4 text-white">
        <h1 class="text-center" id="movieTitle"></h1>
        <div class="row mt-4">
            <div class="col-md-2">
                <img id="movieImage" src="" class="img-fluid" alt="Movie Image">

            </div>
            <div class="col-md-7">
                <div class="ratio ratio-16x9">
                    <iframe id="moviePlayer" src="" frameborder="0" allowfullscreen></iframe>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h2 class="text-center">Cast</h2>
                        <ul id="movieCast" class="list-unstyled"></ul>
                    </div>
                    <div class="col-md-6">
                        <h2 class="text-center">Directors</h2>
                        <ul id="movieDirectors" class="list-unstyled"></ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                {{-- Movie Information --}}
                <div>
                    <h5 class="mb-3" id="movieTitleInfo"></h5>
                    {{-- Badges --}}
                    <div class="d-flex">
                        <span class="badge bg-danger" id="rated"></span>
                        <span class="badge mx-1 bg-success" id="movieYear"></span>
                        <span class="badge bg-primary" id="duration"></span>
                        <span class="mx-1">&#8226;</span>
                        <span id="language"></span>
                    </div>
                    <p class="mt-3" id="movieDescription"></p>
    
                    <h5 class="">IMDb: 
                       
                            <span id="movieRating"></span>
                            <i class="fa-solid fa-star fa-xs"></i>
                  
                    </h5>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const API_KEY = "{{ config('services.tmdb.api_key') }}";
            const movieId = '{{ $id }}';
            const IMG_URL = 'https://image.tmdb.org/t/p/w500';

            fetch(`https://api.themoviedb.org/3/movie/${movieId}?api_key=${API_KEY}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        document.getElementById('movieTitle').textContent = data.title;
                        document.getElementById('moviePlayer').src = `https://vidsrc.to/embed/movie/${movieId}`;
                        document.getElementById('movieImage').src = data.poster_path ? IMG_URL + data.poster_path : 'http://via.placeholder.com/1080x1580';
                        document.getElementById('movieTitleInfo').textContent = data.title;
                        document.getElementById('rated').textContent = data.adult ? 'R' : 'PG';
                        document.getElementById('movieYear').textContent = new Date(data.release_date).getFullYear();
                        document.getElementById('duration').textContent = data.runtime + ' min';
                        document.getElementById('language').textContent = data.original_language.toUpperCase();
                        document.getElementById('movieDescription').textContent = data.overview;
                        document.getElementById('movieRating').textContent = data.vote_average ? data.vote_average.toFixed(1) : 'N/A';
                        
                        // Fetch movie credits
                        fetch(`https://api.themoviedb.org/3/movie/${movieId}/credits?api_key=${API_KEY}`)
                            .then(response => response.json())
                            .then(credits => {
                                const castList = document.getElementById('movieCast');
                                credits.cast.slice(0, 7).forEach(actor => {
                                    const li = document.createElement('li');
                                    li.classList.add('d-flex', 'align-items-center', 'mb-2');
                                    const img = document.createElement('img');
                                    img.src = actor.profile_path ? IMG_URL + actor.profile_path : 'http://via.placeholder.com/50x50';
                                    img.alt = actor.name;
                                    img.classList.add('person-img', 'me-2');
                                    li.appendChild(img);
                                    li.appendChild(document.createTextNode(`${actor.name} as ${actor.character}`));
                                    castList.appendChild(li);
                                });

                                const directorsList = document.getElementById('movieDirectors');
                                credits.crew.filter(member => member.job === 'Director').forEach(director => {
                                    const li = document.createElement('li');
                                    li.classList.add('d-flex', 'align-items-center', 'mb-2');
                                    const img = document.createElement('img');
                                    img.src = director.profile_path ? IMG_URL + director.profile_path : 'http://via.placeholder.com/50x50';
                                    img.alt = director.name;
                                    img.classList.add('person-img', 'me-2');
                                    li.appendChild(img);
                                    li.appendChild(document.createTextNode(director.name));
                                    directorsList.appendChild(li);
                                });
                            });
                    } else {
                        document.body.innerHTML = '<h1 class="text-center">Movie not found</h1>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching the movie details:', error);
                    document.body.innerHTML = '<h1 class="text-center">Error fetching the movie details</h1>';
                });

            // Prevent iframe redirects
            document.getElementById('moviePlayer').onload = function() {
                const iframe = this;
                const iframeWindow = iframe.contentWindow;

                // Overwrite the window.open method in the iframe
                iframeWindow.open = function() {
                    console.log('Blocked an attempt to open a new window');
                    return null;
                };

                // Overwrite the location property in the iframe
                Object.defineProperty(iframeWindow, 'location', {
                    set: function() {
                        console.log('Blocked an attempt to change location');
                    }
                });
            };
        });
    </script>
        <script>
            // Pass the API key to the script
            const API_KEY = "{{ config('services.tmdb.api_key') }}";
        </script>
        <script src="{{ asset('js/script.js') }}"></script>

        @endsection
