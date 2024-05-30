document.addEventListener('DocumentLoaded', function(){

    function addToWishlist(title){
    
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
}




