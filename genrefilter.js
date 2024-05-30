/*--------------------------------------------------------------
# FETCHING INITIAL MOVIES AND TV SHOWS OF ALL GENRES
--------------------------------------------------------------*/

// document.addEventListener("DOMContentLoaded", function() {
//     function fetchMoviesAndImages() {
//       var totalMovies = 0;
//       var movies = [];
    
//       function fetchMovies() {
//           var xhr = new XMLHttpRequest();
//           var url = 'GetTitle.php';
//           var params = {
//               return: '*',
//               limit: 30,
//           };
    
//           xhr.onreadystatechange = function() {
//               if (xhr.readyState == 4) {
//                   if (xhr.status == 200) {
//                       var response = JSON.parse(xhr.responseText);
//                       if (response.status == 'success') {
//                           movies = response.data;
//                           console.log('Movies:', movies);
//                           displayMovies(movies);
//                           //fetchMovieDetailsForAllMovies();
//                       } else {
//                           console.error('Error:', response.message);
//                       }
//                   } else {
//                       console.error('Error:', xhr.statusText);
//                   }
//               }
//           };
    
//           xhr.open('POST', url, true);
//           xhr.setRequestHeader('Content-type', 'application/json');
//           xhr.send(JSON.stringify(params));
//       }
    
//       function displayMovies(movies) {
//           var galleryContainer = document.querySelector('.moviescontainer');
//             galleryContainer.innerHTML = '';
//           movies.forEach(movie => {
//             var movieContainer = document.createElement('div');
//             movieContainer.classList.add('movie');
            
//             var img = document.createElement('img');
//             img.src = movie.image;
//             img.alt = 'movie Image';
    
//             var movieDetails = document.createElement('div');
//             movieDetails.classList.add('movie-details');
//             movieDetails.innerHTML = `
//                 <h2>${movie.title}</h2>
//                 <p><strong>Content Rating: </strong> ${movie.content_rating}</p>
//                 <p><strong>Release Date:</strong> ${movie.release_date}</p>
//                 <p><strong>Genre:</strong> ${movie.genre}</p>
//                 <p><strong>Descriptiom:</strong> ${movie.description}</p>
//                 <p><strong>MediaId:</strong> ${movie.id}</p>
//                 <div class="add-to-wishlist">
//                     <button>Add to Wishlist</button>
//                 </div>
//             `;
    
//             movieContainer.appendChild(img);
//             movieContainer.appendChild(movieDetails);
//             galleryContainer.appendChild(movieContainer);

//             var addToWishlistButton = movieContainer.querySelector('.add-to-wishlist button');
//             addToWishlistButton.addEventListener('click', function() {
//                 addToWishlist(movie.title);
//             });
            
//           });
//       }

//       function addToWishlist(title) {
//         const username = localStorage.getItem('username');

//         if (!username) {
//             console.error('Username not found in local storage');
//             alert('You must be logged in to add to wishlist');
//             return;
//         }

//         var data = {
//             username: username,
//             title: title
//         };

//         fetch('AddWishList.php', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json'
//             },
//             body: JSON.stringify(data)
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.status === 'success') {
//                 alert('Wishlist added successfully');
//                 console.log('Movie added to wishlist');
//             } else {
//                 console.error('Error:', data);
//                 alert('Failed to add to wishlist');
//             }
//         })
//         .catch(error => {
//             console.error('Error adding to wishlist:', error);
//             alert('An error occurred while adding to wishlist');
//         });
//     }

    
    
//       fetchMovies();
//     }
    
//     fetchMoviesAndImages();
//     });
    


/*--------------------------------------------------------------
# FETCHING INITIAL MOVIES AND TV SHOWS OF ALL GENRES
--------------------------------------------------------------*/

document.addEventListener("DOMContentLoaded", function() {
    function fetchMoviesAndImages() {
        function fetchMovies() {
            var xhr = new XMLHttpRequest();
            var url = 'GetTitle.php';
            var params = {
                return: '*',
                limit: 30,
            };

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.status == 'success') {
                            var movies = response.data;
                            console.log('Movies:', movies);
                            displayMovies(movies);
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
            var galleryContainer = document.querySelector('.moviescontainer');
            galleryContainer.innerHTML = '';
            movies.forEach(movie => {
                var movieContainer = document.createElement('div');
                movieContainer.classList.add('movie');
                
                var img = document.createElement('img');
                img.src = movie.image;
                img.alt = 'movie Image';

                var movieDetails = document.createElement('div');
                movieDetails.classList.add('movie-details');
                movieDetails.innerHTML = `
                    <h2>${movie.title}</h2>
                    <p><strong>Content Rating: </strong> ${movie.content_rating}</p>
                    <p><strong>Release Date:</strong> ${movie.release_date}</p>
                    <p><strong>Genre:</strong> ${movie.genre}</p>
                    <p><strong>Description:</strong> ${movie.description}</p>
                    <p><strong>MediaId:</strong> ${movie.id}</p>
                    <div class="add-to-wishlist">
                        <button>Add to Wishlist</button>
                    </div>
                `;

                movieContainer.appendChild(img);
                movieContainer.appendChild(movieDetails);
                galleryContainer.appendChild(movieContainer);

                var addToWishlistButton = movieContainer.querySelector('.add-to-wishlist button');
                addToWishlistButton.addEventListener('click', function() {
                    addToWishlist(movie.title);
                });
            });
        }

        function addToWishlist(title) {
            const username = localStorage.getItem('username');

            if (!username) {
                console.error('Username not found in local storage');
                alert('You must be logged in to add to wishlist');
                return;
            }

            var data = {
                username: username,
                title: title
            };

            fetch('AddWishList.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Wishlist added successfully');
                    console.log('Movie added to wishlist');
                } else {
                    console.error('Error:', data);
                    alert('Failed to add to wishlist');
                }
            })
            .catch(error => {
                console.error('Error adding to wishlist:', error);
                alert('An error occurred while adding to wishlist');
            });
        }

        fetchMovies();
    }
    
    fetchMoviesAndImages();
});

    /*----------------------------------------------------------------------------
    # FETCHING  MOVIES AND OR TV SHOWS OF SPECIFIC GENRES AND EVERYTHING ELSE
    -----------------------------------------------------------------------------*/

    
    