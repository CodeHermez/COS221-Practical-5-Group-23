function openForm() {
    document.getElementById("myForm").style.display = "block";
}

function closeForm() {
    document.getElementById("myForm").style.display = "none";
}

function updateTabContent(tabId, newContent) {
    $(tabId).html(newContent);
}

// Example usage
$(document).ready(function () {


    const username = localStorage.getItem("username");
    const profile = localStorage.getItem("profile");

    $('#username').html(username);
    $('#profile').html(profile);


    $('#pills-profile-tab').on('click', function () {


        updateTabContent('#pills-profile', '<h3>Updated Profile Information</h3><p>New details about the user\'s profile...</p>');
    });

    $('#pills-reviews-tab').on('click', function () {
        updateTabContent('#pills-reviews', '<h3>Updated User Reviews</h3><p>New details about user reviews...</p>');
    });

    $('#pills-morefriends-tab').on('click', function () {

        getALLuser();


    });

    $('#pills-friends-tab').on('click', function () {

        getFriends();

    });



    function getALLuser() {
        const formData = {
            username: $username,
            limit: 20,
            order: "ASC"
        };

        fetch('http://localhost/hoop_tshepi/COS221P5/getUsers.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData),
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
                fetch('http://localhost/hoop_tshepi/COS221P5/RemoveFriend.php', {
                    method: 'POST', // or 'DELETE' depending on your API
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ friendID: friendId })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Handle successful removal, e.g., remove the friend card from the DOM
                            const friendCard = this.closest('.friend-card');
                            friendCard.parentNode.appendChild(friendCard);
                            alert('Friend added successfully');
                        } else {
                            // Handle error
                            alert('Failed to add friend');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while trying to add friend');
                    });
            });


        });
    }



    function getFriends() {


        const formData = {
            username: username
        };

        fetch('http://localhost/hoop_tshepi/COS221P5/getFriends.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    displayFriends(data.data); // Pass the data array to the display function
                } else {
                    alert('Failed to load friends');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while fetching friends');
            });
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
                <img src="./assests/img/${friend.profile_picture}.png" alt="user" class="profile-photo-lg">
                <div class="friend-info">
                  <a href="#" class="pull-right text-green remove-friend"  data-friend-id=${friend.friendID}>Remove Friend</a>
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

                // Perform the HTTP request to remove the friend
                fetch('http://localhost/hoop_tshepi/COS221P5/RemoveFriend.php', {
                    method: 'POST', // or 'DELETE' depending on your API
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ friendID: friendId })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Handle successful removal, e.g., remove the friend card from the DOM
                            const friendCard = this.closest('.friend-card');
                            friendCard.parentNode.removeChild(friendCard);
                            alert('Friend removed successfully');
                        } else {
                            // Handle error
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



    //end of load
});

