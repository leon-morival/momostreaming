<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play Movie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .ratio-16x9 {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            height: 0;
        }
        .ratio-16x9 iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    @include('layouts.navbar')
    <div class="container mt-4">
        <h1 class="text-center" id="movieTitle">Play Movie</h1>
        <div class="row mt-4">
            <div class="col-12">
                <div class="ratio ratio-16x9">
                    <iframe id="moviePlayer" src="" frameborder="0" allowfullscreen sandbox="allow-same-origin allow-scripts"></iframe>
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
                        document.getElementById('movieTitle').textContent = data.Title;
                        document.getElementById('moviePlayer').src = `https://vidsrc.to/embed/movie/${imdbId}`;
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
</body>
</html>
