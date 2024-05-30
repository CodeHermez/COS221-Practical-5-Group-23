
    /*----------------------------------------------------------------------------
    # FETCHING  MOVIES AND OR TV SHOWS OF SPECIFIC GENRES AND EVERYTHING ELSE
    -----------------------------------------------------------------------------*/
            
    // document.addEventListener("DOMContentLoaded", function() {
    //     // Event listener for the fetch genre button
    //     document.getElementById("fetch-genre-button").addEventListener("click", function() {
    //         // Get values from input fields

    //         var genre = document.getElementById("genre-selector").value;
    //         var type = document.getElementById("type-selector").value;
    //         var sort = document.getElementById("sort-selector").value;
    //         var sortOrder = document.getElementById("sort-order").value;
    //         var releaseDate = document.getElementById("release-date").value;
    //         var rating = document.getElementById("rating").value;
    //         var duration = document.getElementById("duration").value;
    //         var seasons = document.getElementById("seasons").value;
    
    //         // Construct the search object based on user inputs
    //         var searchObj = {
    //             "type": type,
    //             "genre": genre,
    //             "rating": parseInt(rating),
    //             "release_date": parseInt(releaseDate),
    //             "minduration": parseInt(duration), // Assuming duration is in minutes
    //             "minseasons": parseInt(seasons)
    //         };
    
    //         // Construct the request payload
    //         var payload = {
    //             "return": "*",
    //             "limit": 30, 
    //             "sort": sort,
    //             "order": sortOrder,
    //             "search": searchObj
    //         };
    
    //         // Make a POST request to the API endpoint
    //         fetch("GetTitle.php", {
    //             method: "POST",
    //             headers: {
    //                 "Content-Type": "application/json"
    //             },
    //             body: JSON.stringify(payload)
    //         })
    //         .then(response => response.json())
    //         .then(data => {

    //         if (data.status === 'success') {
    //             // Call the function to display movies
    //             displayMovies(data.data);
    //             console.log(data);
    //         }

    //         })
    //         .catch(error => {
    //             console.error("Error:", error);
    //         });

    //         function displayMovies(movies) {
    //             var galleryContainer = document.querySelector('.moviescontainer');
    //               galleryContainer.innerHTML = '';
    //             movies.forEach(movie => {
    //               var movieContainer = document.createElement('div');
    //               movieContainer.classList.add('movie');
                  
    //               var img = document.createElement('img');
    //               img.src = movie.image;
    //               img.alt = 'movie Image';
          
    //               var movieDetails = document.createElement('div');
    //               movieDetails.classList.add('movie-details');
    //               movieDetails.innerHTML = `
    //                   <h2>${movie.title}</h2>
    //                   <p><strong>Content Rating: </strong> ${movie.content_rating}</p>
    //                   <p><strong>Release Date:</strong> ${movie.release_date}</p>
    //                   <p><strong>Genre:</strong> ${movie.genre}</p>
    //                   <p><strong>Descriptiom:</strong> ${movie.description}</p>
    //                   <p><strong>MediaId:</strong> ${movie.id}</p>
    //                   <div class="add-to-wishlist">
    //                       <button>Add to Wishlist</button>
    //                   </div>
    //               `;
          
    //               movieContainer.appendChild(img);
    //               movieContainer.appendChild(movieDetails);
    //               galleryContainer.appendChild(movieContainer);

    //                           // Add event listener to the Add to Wishlist button
    //         var addToWishlistButton = movieContainer.querySelector('.add-to-wishlist button');
    //         addToWishlistButton.addEventListener('click', function() {
    //             addToWishlist(movie.title);
    //             });
    //     });

    // }

    // function addToWishlist(title) {
    //     const username = localStorage.getItem('username');

    //     if (!username) {
    //         console.error('Username not found in local storage');
    //         alert('You must be logged in to add to wishlist');
    //         return;
    //     }

    //     var data = {
    //         username: username,
    //         title: title
    //     };

    //     fetch('AddWishList.php', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json'
    //         },
    //         body: JSON.stringify(data)
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         if (data.status === 'success') {
    //             alert('Wishlist added successfully');
    //             console.log('Movie added to wishlist');
    //         } else {
    //             console.error('Error:', data);
    //             alert('Failed to add to wishlist');
    //         }
    //     })
    //     .catch(error => {
    //         console.error('Error adding to wishlist:', error);
    //         alert('An error occurred while adding to wishlist');
    //     });
    // }

    // });
  
            
            



document.addEventListener("DOMContentLoaded", function() {
    // Event listener for the fetch genre button
    document.getElementById("fetch-genre-button").addEventListener("click", function() {
        // Get values from input fields
        var genre = document.getElementById("genre-selector").value;
        var type = document.getElementById("type-selector").value;
        var sort = document.getElementById("sort-selector").value;
        var sortOrder = document.getElementById("sort-order").value;
        var releaseDate = document.getElementById("release-date").value;
        var rating = document.getElementById("rating").value;
        var duration = document.getElementById("duration").value;
        var seasons = document.getElementById("seasons").value;

        // Construct the search object based on user inputs
        var searchObj = {
            "type": type,
            "genre": genre,
            "rating": parseInt(rating),
            "release_date": parseInt(releaseDate),
            "minduration": parseInt(duration), // Assuming duration is in minutes
            "minseasons": parseInt(seasons)
        };

        // Construct the request payload
        var payload = {
            "return": "*",
            "limit": 30, 
            "sort": sort,
            "order": sortOrder,
            "search": searchObj
        };

        // Make a POST request to the API endpoint
        fetch("GetTitle.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Call the function to display movies
                displayMovies(data.data);
                console.log(data);
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
    });

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

            // Add event listener to the Add to Wishlist button
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
});
