import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

const BASE_URL = "https://api.themoviedb.org/3";
const IMG_URL = "https://image.tmdb.org/t/p/w500";

document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const searchQuery = urlParams.get("query");

    if (searchQuery) {
        fetchMovies(
            `${BASE_URL}/search/movie?api_key=${API_KEY}&query=${searchQuery}`,
            "moviesList",
            true
        );
    } else {
        fetchMovies(
            `${BASE_URL}/discover/movie?sort_by=popularity.desc&api_key=${API_KEY}`,
            "popularMoviesList"
        );
        fetchMovies(
            `${BASE_URL}/discover/movie?with_genres=28&sort_by=popularity.desc&api_key=${API_KEY}`,
            "actionMoviesList"
        );
        fetchMovies(
            `${BASE_URL}/discover/movie?with_genres=35&sort_by=popularity.desc&api_key=${API_KEY}`,
            "comedyMoviesList"
        );
        fetchMovies(
            `${BASE_URL}/discover/movie?with_genres=878&sort_by=popularity.desc&api_key=${API_KEY}`,
            "sciFiMoviesList"
        );
    }

    document
        .getElementById("searchForm")
        .addEventListener("submit", function (event) {
            event.preventDefault();
            const query = document.getElementById("searchInput").value;
            if (query) {
                window.location.href = `/?query=${query}`;
            }
        });
});

function fetchMovies(url, listId, hideCarousels = false) {
    fetch(url)
        .then((response) => response.json())
        .then((data) => {
            if (data.results && data.results.length > 0) {
                displayMovies(data.results, listId, hideCarousels);
            } else {
                showError("No movies found.");
            }
        })
        .catch((error) => {
            console.error("Error fetching the movies:", error);
            showError("Error fetching the movies. Please try again later.");
        });
}

function displayMovies(movies, listId, hideCarousels) {
    const moviesList = document.getElementById(listId);
    moviesList.innerHTML = "";

    if (hideCarousels) {
        document.getElementById("carousels").style.display = "none";
        document.getElementById("moviesList").style.display = "flex";
    }

    let items = "";

    if (hideCarousels) {
        // Display all found movies for the search
        movies.forEach((movie) => {
            items += `
                <div class="col-3  movie-card">
                    <div class="card h-100">
                        <a href="/play_movie/${movie.id}">
                            <img src="${
                                movie.poster_path
                                    ? IMG_URL + movie.poster_path
                                    : "http://via.placeholder.com/1080x1580"
                            }" class="card-img-top" alt="${movie.title}">
                        </a>
                        <div class="card-body movie-info">
                            <p class="card-title">${movie.title}</p>
                            <span class="rating">${
                                movie.vote_average
                                    ? Math.round(movie.vote_average * 10) / 10
                                    : "N/A"
                            }</span>
                        </div>
                    </div>
                </div>
            `;
        });
    } else {
        // Display movies in carousels
        movies.forEach((movie, index) => {
            const movieCard = `
                <div class="col-3 movie-card p-1">
                    <div class="card h-auto ">
                        <a href="/play_movie/${movie.id}">
                            <img src="${
                                movie.poster_path
                                    ? IMG_URL + movie.poster_path
                                    : "http://via.placeholder.com/1080x1580"
                            }" class="card-img-top" alt="${movie.title}">
                        </a>
                        <div class="card-body movie-info">
                            <h6 class="card-title">${movie.title}</h6>
                            <span class="rating">${
                                movie.vote_average
                                    ? Math.round(movie.vote_average * 10) / 10
                                    : "N/A"
                            }</span>
                        </div>
                    </div>
                </div>
            `;

            if (index % 4 === 0) {
                if (index !== 0) items += "</div></div>";
                items += `<div class="carousel-item ${
                    index === 0 ? "active" : ""
                }"><div class="row">`;
            }
            items += movieCard;
        });
        items += "</div></div>";
    }

    moviesList.innerHTML = items;
}

function showError(message) {
    const moviesList = document.getElementById("moviesList");
    moviesList.innerHTML = `
        <div class="col-12">
            <div class="alert alert-danger" role="alert">
                ${message}
            </div>
        </div>
    `;
}
