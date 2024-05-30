function updateTabContent(tabId, newContent) {
    $(tabId).html(newContent);
}

document.getElementById('home-button').addEventListener('click', function () {
    window.location.href = 'index.php';
});

async function addReview() {
    let starRating = 0;

    // Capture star rating from dropdown
    document.querySelectorAll('.rating-item').forEach(item => {
        item.addEventListener('click', function (event) {
            event.preventDefault();
            starRating = this.dataset.value;
            console.log('Selected star rating:', starRating);
        });
    });

    // Handle the Send button click
    document.getElementById('send-review').addEventListener('click', async function () {
        const comment = document.getElementById('textAreaExample').value;
        const title = document.getElementById('form12').value;

        if (!title) {
            alert('Please enter a movie title.');
            return;
        }

        const formdata={
            return: "*", // The string "*" or an array of specific fields to return
            limit: 1,
            search: {
                title: title
            }
        }

        try {
            // Send request to getTitle endpoint
            const titleResponse = await fetch('http://localhost/hoop_tshepi/COS221P5/GetTitle.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formdata)
            });
            console.log(titleResponse.data);
            if (!(titleResponse.statusText === 'OK')) {
                throw new Error('Failed to fetch media data.');
            }


            const titleData = await titleResponse.json();
            const mediaID = titleData.data.id; // Assuming response contains mediaID
            const imageURL = titleData.data.image; // Assuming response contains imageURL

            // Update the review section
            document.getElementById('review-image').src = imageURL;
            document.getElementById('comment-display').textContent = comment;
            document.getElementById('comment-star').html=starRating;

            // Prepare review data to send
            const reviewData = {
                starRating: starRating,
                comment: comment,
                mediaID: mediaID
            };

            // Send review data to addreview endpoint
            const reviewResponse = await fetch('http://localhost/hoop_tshepi/COS221P5/addReview', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(reviewData)
            });

            if (!reviewResponse.ok) {
                throw new Error('Failed to submit review.');
            }

            alert('Review submitted successfully!');
        } catch (error) {
            console.error('Error:', error);
            alert(error.message);
        }
    });
}

// Example usage
$(document).ready(function () {

    addReview();

    const username = localStorage.getItem("username");
    const profile = localStorage.getItem("profile");

    $('#username').html(username);
    $('#profile').html(profile);


    $('#pills-profile-tab').on('click', function () {


        updateTabContent('#pills-profile', '<h3>Updated Profile Information</h3><p>New details about the user\'s profile...</p>');
    });

    $('#pills-reviews-tab').on('click', function () {

    });

    $('#pills-morefriends-tab').on('click', function () {

        getALLuser();


    });

    $('#pills-friends-tab').on('click', async function () {

        await getFriends(username);

    });

    function openForm() {
        document.getElementById("myForm").style.display = "block";
    }

    function closeForm() {
        document.getElementById("myForm").style.display = "none";
    }

    // Expose openForm and closeForm to the global scope
    window.openForm = openForm;
    window.closeForm = closeForm;



    function getALLuser() {
        // const formData = {
        //     username: username,
        //     limit: 20,
        //     order: "ASC"
        // };

        fetch('http://localhost/hoop_tshepi/COS221P5/getUsers.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    displayALLUsers(data.data); // Pass the data array to the display function
                } else {
                    alert('Failed to load Users');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while fetching Users');
            });



    }

    function displayALLUsers(users) {
        const container = document.getElementById('moreFriend');
        container.innerHTML = ''; // Clear any existing content

        users.forEach(user => {
            const UserCard = document.createElement('div');
            UserCard.className = 'col-md-4 col-sm-6';
            UserCard.innerHTML = `
                <div class="friend-card">
                  <img src="./assets/img/cardColour.png" alt="profile-cover" class="img-responsive cover">
                  <div class="card-info">
                  <img src="./assets/img/1.png" alt="user" class="profile-photo-lg">
                    <div class="friend-info">
                      <a href="#" class="pull-right text-green add-friend"  data-friend-id=${user.username}>Add Friend</a>
                      <h5><a href="profilnew.php" class="profile-link">${user.username}</a></h5>
                    </div>
                  </div>
                </div>
              `;
            container.appendChild(UserCard);
        });

        setAddFriendLinks();

    }

    function setAddFriendLinks() {
        const addFriendLinks = document.querySelectorAll('.add-friend');

        addFriendLinks.forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent the default link behavior

                const friendId = this.getAttribute('data-friend-id'); // Get the friend ID

                // Perform the HTTP request to remove the friend
                fetch('http://localhost/hoop_tshepi/COS221P5/addFriend.php', {
                    method: 'POST', // or 'DELETE' depending on your API
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ friendID: friendId})
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Handle successful removal, e.g., remove the friend card from the DOM
                            // const friendCard = this.closest('.friend-card');
                            // friendCard.parentNode.appendChild(friendCard);
                            alert('Friend added successfully');
                        } else {
                            // Handle error
                            alert("failed to add friend");
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while trying to add friend');
                    });
            });


        });
    }



    async function getFriends(username) {

        try {
            const response = await fetch(`http://localhost/hoop_tshepi/COS221P5/getFriends.php?username=${username}`);
            const data = await response.json();
            if (data.status === 'success') {
                displayFriends(data.data); // Pass the data array to the display function
            } else {
                alert('Failed to load friends');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while fetching friends');
        }


        

        // fetch(`http://localhost/hoop_tshepi/COS221P5/getFriends.php?username=${username}`, {
        //     method: 'GET',
        //     headers: {
        //         'Content-Type': 'application/json',
        //     },

        // })
        //     .then(response => response.json())
        //     .then(data => {
        //         if (data.status === 'success') {
        //             displayFriends(data.data); // Pass the data array to the display function
        //         } else {
        //             alert('Failed to load friends');
        //         }
        //     })
        //     .catch(error => {
        //         console.error('Error:', error);
        //         alert('An error occurred while fetching friends');
        //     });
    }

    // Function to create and display friend cards
    function displayFriends(friends) {
        const container = document.getElementById('friend');
        container.innerHTML = ''; // Clear any existing content

        friends.forEach(friend => {
            const friendCard = document.createElement('div');
            friendCard.className = 'col-md-4 col-sm-6';
            friendCard.innerHTML = `
            <div class="friend-card">
              <img src="./assets/img/cardColour.png" alt="profile-cover" class="img-responsive cover">
              <div class="card-info">
                <img src="./assets/img/${friend.profile_picture}.png" alt="user" class="profile-photo-lg">
                <div class="friend-info">
                  <a href="#" class="pull-right text-green remove-friend"  data-friend-id=${friend.friendID}>Remove Friend</a><br>
                  <a href="#" class="pull-right text-green message-friend" data-friend-id="${friend.friendID}">Message</a>
                  <h5><a href="timeline.html" class="profile-link">${friend.friendID}</a></h5>
                </div>
              </div>
            </div>
          `;
            container.appendChild(friendCard);
        });

        setRemoveFriendLinks();
        setMessageLinks();
    }

    function setMessageLinks() {
        const messageLinks = document.querySelectorAll('.message-friend');

        messageLinks.forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                openForm();
            });
        });
    }

    function setRemoveFriendLinks() {
        //remove friends
        const removeFriendLinks = document.querySelectorAll('.remove-friend');

        removeFriendLinks.forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent the default link behavior

                const friendId = this.getAttribute('data-friend-id'); // Get the friend ID
                const formData = {
                        username: username,
                        friendID: friendId
                    };

                // Perform the HTTP request to remove the friend
                fetch('http://localhost/hoop_tshepi/COS221P5/removeFriend.php', {
                    method: 'POST', // or 'DELETE' depending on your API
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success === "success") {
                            // Handle successful removal, e.g., remove the friend card from the DOM
                            const friendCard = this.closest('.friend-card');
                            friendCard.parentNode.removeChild(friendCard);
                            alert('Friend removed successfully');
                        } else {
                            // Handle error
                            console.log(data.message);
                            alert('Failed to remove friend');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while trying to remove friend');
                    });

            });

            //end of remove friend
        });
    }


  const ratings = document.getElementById('rating1'); const rating1 = new CDB.Rating(ratings);
  rating1.getRating;

    
  

    //end of load
});


//GET WISHLIST
document.addEventListener('DOMContentLoaded', function() {
    const username = localStorage.getItem('username');
  
    if (!username) {
      alert('No user is logged in');
      return;
    }
  
    fetch(`GetWishList.php?username=${encodeURIComponent(username)}`)
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          displayWishlist(data.data);
        } else {
          console.error('Error:', data.data);
          alert('Error retrieving wishlist: ' + data.data);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while retrieving the wishlist.');
      });
  });
  
  function displayWishlist(wishlist) {
    const wishlistContainer = document.getElementById('wishlist-container');
    wishlistContainer.innerHTML = '';
  
    wishlist.forEach(item => {
      const wishlistItem = document.createElement('div');
      wishlistItem.classList.add('col-md-6', 'col-lg-4');
  
      wishlistItem.innerHTML = `
        <div class="card hover-img overflow-hidden rounded-2">
          <div class="card-body p-0">
            <img src="${item.image}" alt="${item.title}" class="img-fluid w-100 object-fit-cover" style="height: 220px;">
            <div class="p-4 d-flex align-items-center justify-content-between">
              <div>
                <h6 class="fw-semibold mb-0 fs-4">${item.title}</h6>
                <span class="text-dark fs-2">${new Date(item.release_Date).toDateString()}</span>
                <p>${item.description}</p>
                <p>${item.content_rating}</p>
              </div>
              <div class="dropdown">
                <a class="text-muted fw-semibold d-flex align-items-center p-1"
                  href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="ti ti-dots-vertical"></i>
                </a>
                <ul class="dropdown-menu overflow-hidden">
                  <li><a class="dropdown-item" href="javascript:void(0)">${item.title}</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      `;
  
      wishlistContainer.appendChild(wishlistItem);
    });
  
    // Update the gallery count
    document.getElementById('gallery-count').innerText = wishlist.length;
  }
