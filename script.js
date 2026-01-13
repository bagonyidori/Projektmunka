let movieList = [];
let genreList = [];

const highlightDiv = document.getElementById("highlight-div");
const popularNow = document.getElementById("popular-now");

console.log("highlightDiv:", highlightDiv);
console.log("popularNow:", popularNow);

function getGenres(genreList, genreId){
    const genre = genreList.find(g => g.id === genreId);
    return genre ? genre.name : '';
}

function listAll(){
    const firstMovie = movieList[0];
    if(firstMovie && highlightDiv){
        highlightDiv.innerHTML += `
        <div>
            <h1 class="hero-title">${firstMovie.title}</h1>
            <p class="meta">
                ${firstMovie.release_date} • ${getGenres(genreList, firstMovie.genre_ids ? firstMovie.genre_ids[0] : firstMovie.genre_id)} • ${firstMovie.original_language}
            </p>
        </div>`;
    }
    console.log("1");
    if(popularNow){
        console.log("2");
        movieList.forEach(e => {
            popularNow.innerHTML += `
              <article class="card floating-card">
                <div class="thumb">Poszter</div>
                <div class="card-body">
                  <h3>${e.title}</h3>
                  <p class="meta">
                    ${e.release_date} • ${getGenres(genreList, e.genre_ids ? e.genre_ids[0] : e.genre_id)} • ${e.original_language}
                  </p>
                </div>
              </article>
            `;
            console.log(e.title);
        });
    }
            console.log("3");
}

async function takeGenres() {
    const url = 'https://api.themoviedb.org/3/genre/movie/list';
    const options = {
        method: 'GET',
        headers: {
            accept: 'application/json',
            Authorization: 'Bearer ...'
        }
    }

    try {
        const res = await fetch(url, options);
        const data = await res.json();
        genreList.push(...data.genres);
    } catch(err) {
        console.error(err);
    }
}

async function takeMovies() {
    const url = 'https://api.themoviedb.org/3/movie/popular';
    const options = {
        method: 'GET',
        headers: {
            accept: 'application/json',
            Authorization: 'Bearer ...'
        }
    }

    try {
        const res = await fetch(url, options);
        const data = await res.json();
        movieList.push(...data.results);
        listAll();
    } catch(err) {
        console.error(err);
    }
}

document.addEventListener("DOMContentLoaded", async () => {
    await takeGenres();
    await takeMovies();
});