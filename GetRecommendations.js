
document.addEventListener("DOMContentLoaded", function() {
    fetchRecommendations();

function fetchRecommendations() {
        // Retrieve username from local storage
        const username = localStorage.getItem('username');
        //verify logged in.
        if (!username) {
            console.error('Username not found in local storage');
            return;
        }

            fetch(`GetRecommendations.php?username=${encodeURIComponent(username)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        displayRecommendations(data.data);
                    } else {
                        console.error('Error:', data);
                        alert('Failed to retrieve recommendations');
                        //fetchMoviesAndImages(); //if they have no recommendations, load page as usual.

                    }
                })
                .catch(error => {
                    console.error('Error fetching recommendations:', error);
                    alert('An error occurred while fetching recommendations');
                });
        }

        function displayRecommendations(movies) {
            var galleryContainer = document.querySelector('.rcontainer');
            galleryContainer.innerHTML = '';

            movies.forEach(movie => {
              var movieContainer = document.createElement('div');
              movieContainer.classList.add('movie');
              
            //   var img = document.createElement('img');
            //   img.src = movie.image;
            //   img.alt = 'movie Image';
      
              var movieDetails = document.createElement('div');
              movieDetails.classList.add('movie-details');
              movieDetails.innerHTML = `
                  <h2>${movie.title}</h2>
                  <p><strong>Content Rating: </strong> ${movie.content_rating}</p>
                  <p><strong>Release Date:</strong> ${movie.release_date}</p>
                  <p><strong>Genre:</strong> ${movie.genre}</p>
                  <p><strong>Descriptiom:</strong> ${movie.description}</p>
                  <p><strong>MediaId:</strong> ${movie.id}</p>
                  <div class="add-to-wishlist">
                      <button>Add to Wishlist</button>
                  </div>
              `;
      
              //movieContainer.appendChild(img);
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
    });
    

    
