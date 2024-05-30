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
