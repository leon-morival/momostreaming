

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

if (hideCarousels) {
// Afficher tous les films trouvés lors de la recherche
movies.forEach((movie) => {
    items += `
        <div class="col-md-3 movie-card">
            <div class="card h-100">
                <a href="/play_movie/${movie.id}">
                    <img src="${movie.poster_path ? IMG_URL + movie.poster_path : 'http://via.placeholder.com/1080x1580'}" class="card-img-top" alt="${movie.title}">
                </a>
                <div class="card-body movie-info">
                    <h5 class="card-title">${movie.title}</h5>
                    <span class="rating">${movie.vote_average ? Math.round(movie.vote_average * 10) / 10 : 'N/A'}</span>
                </div>
            </div>
        </div>
    `;
});
} else {
// Afficher les films en carousels
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
}

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
