/*--------------------------------------------------------------
# FETCHING INITIAL MOVIES AND TV SHOWS OF ALL GENRES
--------------------------------------------------------------*/

document.addEventListener("DOMContentLoaded", function() {
function fetchMoviesAndImages() {
  var totalMovies = 0;
  var movies = [];

  function fetchMovies() {
      var xhr = new XMLHttpRequest();
      var url = 'GetTitle.php';
      var params = {
          return: ['title', 'description', 'poster_Url', 'Genre', 'rating', 'release_Date', 'CAST', 'content_rating'],
          limit: 30,
      };

      xhr.onreadystatechange = function() {
          if (xhr.readyState == 4) {
              if (xhr.status == 200) {
                  var response = JSON.parse(xhr.responseText);
                  if (response.status == 'success') {
                      movies = response.data;
                      console.log('Movies:', movies);
                      displayMovies(movies);
                      fetchMovieDetailsForAllMovies();
                  } else {
                      console.error('Error:', response.message);
                  }
              } else {
                  console.error('Error:', xhr.statusText);
              }
          }
      };

      xhr.open('POST', url, true);
      xhr.setRequestHeader('Content-type', 'application/json');
      xhr.send(JSON.stringify(params));
  }

  function displayMovies(movies) {
      var galleryContainer = document.querySelector('.gallery .row');
        galleryContainer.innerHTML = '';
      movies.forEach(movie => {
          var galleryItem = document.createElement('div');
          galleryItem.classList.add('col-xl-3', 'col-lg-4', 'col-md-6');
          galleryItem.innerHTML = `
              <div class="gallery-item h-100">
                  <img src="${movie.image}" class="img-fluid" alt="${movie.title}">
                  <div class="gallery-links d-flex align-items-center justify-content-center">
                      <a href="${movie.image}" title="${movie.title}" class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>
                      <a href="gallery-single.php?title=${encodeURIComponent(movie.title)}" class="details-link"><i class="bi bi-link-45deg"></i></a>
                  </div>
              </div>
          `;
          galleryContainer.appendChild(galleryItem);
      });
  }

  function fetchMovieDetailsForAllMovies() {
      movies.forEach(function(movie) {
          fetchMovieDetails(movie.title);
      });
  }

  function fetchMovieDetails(title) {
      var xhr = new XMLHttpRequest();
      var url = 'GetTitle.php';
      var params = {
          return: ['title', 'description', 'poster_Url', 'Genre', 'rating', 'release_Date', 'CAST', 'content_rating'],
          limit: 1,
          search: { title: title }
      };

      xhr.onreadystatechange = function() {
          if (xhr.readyState == 4) {
              if (xhr.status == 200) {
                  var response = JSON.parse(xhr.responseText);
                  if (response.status == 'success') {
                      var movie = response.data[0];
                      console.log('Movie Details:', movie);
                      displayMovieDetails(movie);
                  } else {
                      console.error('Error:', response.message);
                  }
              } else {
                  console.error('Error:', xhr.statusText);
              }
          }
      };

      xhr.open('POST', url, true);
      xhr.setRequestHeader('Content-type', 'application/json');
      xhr.send(JSON.stringify(params));
  }

  function displayMovieDetails(movie) {
      // Update HTML elements with movie details
      // document.querySelector('.portfolio-description h2').innerText = movie.title;
      // document.querySelector('.portfolio-description p').innerText = movie.description;
      // document.querySelector('.portfolio-info span#movie-genre').innerText = movie.Genre.join(', ');
      // document.querySelector('.portfolio-info span#movie-rating').innerText = movie.rating;
      // document.querySelector('.portfolio-info span#release-date').innerText = movie.release_Date;
      // document.querySelector('.portfolio-info span#movie-cast').innerText = movie.CAST.join(', ');
      // document.querySelector('.portfolio-info span#content-rating').innerText = movie.content_rating;
          // Update HTML elements with movie details
    var portfolioDescription = document.querySelector('.gallery-single .portfolio-description');
    if (portfolioDescription) {
        portfolioDescription.querySelector('h2').innerText = movie.title;
        portfolioDescription.querySelector('p').innerText = movie.description;
        
        // Update genre, rating, release date, cast, and content rating
        var portfolioInfo = document.querySelector('.row .col-lg-3 .portfolio-info');
        if (portfolioInfo) {
            portfolioInfo.querySelector('#movie-genre').innerText = movie.genre.join(', ');
            portfolioInfo.querySelector('#movie-rating').innerText = movie.rating;
            portfolioInfo.querySelector('#release-date').innerText = movie.release_date;
            portfolioInfo.querySelector('#movie-cast').innerText = movie.cast.join(', ');
            portfolioInfo.querySelector('#content-rating').innerText = movie.content_rating;
        } else {
            console.error("Portfolio info not found!");
        }
    } else {
        console.error("Portfolio description not found!");
    }

      // Update swiper slides with movie poster
      var posterSlider = document.querySelector('.swiper-wrapper');
      posterSlider.innerHTML = ''; // Clear existing images
      var slide = document.createElement('div');
      slide.className = 'swiper-slide';
      slide.innerHTML = `<img src="${movie.image}" alt="${movie.title} poster">`;
      posterSlider.appendChild(slide);

      // Re-initialize the Swiper instance
      new Swiper('.swiper', {
          pagination: {
              el: '.swiper-pagination',
              clickable: true,
          },
          navigation: {
              nextEl: '.swiper-button-next',
              prevEl: '.swiper-button-prev',
          },
      });
  }

  fetchMovies();
}

fetchMoviesAndImages();
});
