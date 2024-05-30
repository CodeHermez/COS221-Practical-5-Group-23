<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>PhotoFolio Bootstrap Template - Index</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Cardo:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <script src = "assets/js/genrefilter.js"></script>
  <style>
        #fetch-genre-button {
            background-color: black;
            color: darkgreen;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;

            margin-top: 20px; /* Adjust margin as needed */
        }

        #fetch-genre-button:hover {
            background-color: #333;
        }

        #button-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 20px; /* Adjust padding as needed */
        }

        #genre-selector {
            border-radius: 5px;
            padding: 5px;
            margin-right: 10px;

            background-color: black;
            color: darkgreen;
            border: 1px solid darkgreen;
        }
        #genre-selector option {
            background-color: black;
            border-radius: 5px;
            padding: 5px;
            margin-right: 10px;

            color: darkgreen;

        }
        .genre-label {
            color: darkgreen;
            font-size: 16px;
            margin-right: 10px;
        }

        .input-group {
            flex-basis: calc(33.33% - 10px); /* Adjust width and spacing */
            margin-bottom: 15px;
        }

        select, input[type="number"] {
            width: 100%;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
            background-color: black;
            color: darkgreen;
            border: 1px solid darkgreen;
            margin-bottom: 10px;
        }

        select option {
            background-color: black;
            color: darkgreen;
        }

        select:focus, input[type="text"]:focus, input[type="number"]:focus {
            border-color: green;
            outline: none;
        }

        .input-label {
            color: darkgreen;
            font-size: 16px;
            margin-bottom: 5px;
        }
                /* Style the container */
        .logout-container {
            position: absolute;
            top: 50px;
            right: -350px;
        }
        /* Style the button */
        #logout-button {
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        #logout-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center  me-auto me-lg-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <!-- <i class="bi bi-camera"></i> -->
        <h1> &#x26F9;&#xFE0F;&#x200D;&#x2640;&#xFE0F; HOOP</h1>
      </a>
      
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="index.php" class="active">Home</a></li>
          <li><a href="about.php">About</a></li>
            <ul>
              <!-- <li><a href="gallery.php" data-genre="action">Action</a></li>
              <li><a href="gallery.php" data-genre="animation">Animation</a></li>
              <li><a href="gallery.php" data-genre="comedy">Comedy</a></li>
              <li><a href="gallery.php" data-genre="documentation">Documentation</a></li>
              <li><a href="gallery.php" data-genre="drama">Drama</a></li>
              <li><a href="gallery.php" data-genre="european">European</a></li>
              <li><a href="gallery.php" data-genre="family">Family</a></li>
              <li><a href="gallery.php" data-genre="fantasy">Fantasy</a></li>
              <li><a href="gallery.php" data-genre="history">History</a></li>
              <li><a href="gallery.php" data-genre="horror">Horror</a></li>
              <li><a href="gallery.php" data-genre="music">Music</a></li>
              <li><a href="gallery.php" data-genre="reality">Reality</a></li>
              <li><a href="gallery.php" data-genre="romance">Romance</a></li>
              <li><a href="gallery.php" data-genre="scifi">Sci-Fi</a></li>
              <li><a href="gallery.php" data-genre="sport">Sport</a></li>
              <li><a href="gallery.php" data-genre="thriller">Thriller</a></li>
              <li><a href="gallery.php" data-genre="war">War</a></li>
              <li><a href="gallery.php" data-genre="western">Western</a></li> -->
              <!-- <li class="dropdown"> -->
                <!-- <a href="#"><span>VIEW MORE</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a> -->
              </li>
            </ul>
          </li>
          <ul>
          <li><a href="profile.php">View Profile</a><li>
          <li><a href="settings.php">Settings</a><li>
          <li><a href="services.php">Services</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>

        <div class="logout-container">
        <button id="logout-button">Logout</button>
        </div>

      </nav><!-- .navbar -->
      <div class="header-social-links">
        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
      </div>
      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex flex-column justify-content-center align-items-center" data-aos="fade" data-aos-delay="1500">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
          <h2>HOOP&#x1F3CC;&#xFE0F;&#x200D;&#x2640;&#xFE0F;
          </h2>
          <p>Catch the Magic of Every Flick!</p>
          <a href="contact.php" class="btn-get-started">Have any enquiries? Contact Us!</a>
        </div>
      </div>
    </div>

  </section><!-- End Hero Section -->

           <!-- Input Selectors and Button -->
           <div id="button-container">
        <div class="input-group">
            <label for="genre-selector" class="input-label">Genre:</label>
            <select id="genre-selector">
                <option value="action">Action</option>
                <option value="animation">Animation</option>
                <option value="comedy">Comedy</option>
                <option value="documentation">Documentation</option>
                <option value="drama">Drama</option>
                <option value="european">European</option>
                <option value="family">Family</option>
                <option value="fantasy">Fantasy</option>
                <option value="history">History</option>
                <option value="horror">Horror</option>
                <option value="music">Music</option>
                <option value="reality">Reality</option>
                <option value="romance">Romance</option>
                <option value="scifi">Sci-Fi</option>
                <option value="sport">Sport</option>
                <option value="thriller">Thriller</option>
                <option value="war">War</option>
                <option value="western">Western</option>
            </select>
        </div>

        <div class="input-group">
            <label for="type-selector" class="input-label">Type:</label>
            <select id="type-selector">
                <option value="movie">Movie</option>
                <option value="tvshow">TV Show</option>
            </select>
        </div>

        <div class="input-group">
            <label for="type-selector" class="input-label">Sort In:</label>
            <select id="sort-order">
                <option value="ASC">Ascending</option>
                <option value="DESC">Descending</option>
            </select>
        </div>

        <div class="input-group">
            <label for="type-selector" class="input-label">Sort By:</label>
            <select id="sort-selector">
                <option value="title">Title</option>
                <option value="release-date">Release data</option>
                <option value="content_rating">Content Rating</option>
                <option value="rating">Rating</option>
                <option value="genre">Genre</option>
            </select>
        </div>

        <div class="input-group">
            <label for="release-date" class="input-label">Release Date:</label>
            <input type="number" id="release-date" placeholder="YYYY">
        </div>

        <div class="input-group">
            <label for="rating" class="input-label">Rating:</label>
            <input type="number" id="rating" min="1" max="5" step="1">
        </div>

        <div class="input-group">
            <label for="duration" class="input-label">Duration (min):</label>
            <input type="number" id="duration">
        </div>

        <div class="input-group">
            <label for="seasons" class="input-label">Seasons:</label>
            <input type="number" id="seasons" min="1" max="100" step="1">
        </div>

        <button id="fetch-genre-button">Fetch Movies</button>
    </div>

  <main id="main" data-aos="fade" data-aos-delay="1500">

    <!-- ======= Gallery Section ======= -->
    <h2>Your Recommendations!</h2>
<div class="rcontainer">
    <!-- Movie recommendation items will be displayed here -->
    <div class="movie">
                      <img src="img/output_onebedroom.jpg" alt="output_onebedroom">
                      <div class="movie-details">
                        <h2>1 Bedroom House in JHB</h2>
                        <p><strong>Price:</strong> R500,000</p>
                        <p><strong>Location:</strong> Muldersdrift</p>
                        <p><strong>Bedrooms:</strong> 1</p>
                        <p><strong>Bathrooms:</strong> 2</p>
                        <div class="add-to-wishlist">
                          <button>Add to Favorites</button>
                        </div>
                      </div>
                    </div>

                    <div class="movie">
                        <img src="img/output_2bedroom.jpg" alt="output_2bedroom">
                        <div class="movie-details">
                          <h2>2 Bedroom House in Eastern Cape</h2>
                          <p><strong>Price:</strong> R650,000</p>
                          <p><strong>Location:</strong> Papkuilsfontein</p>
                          <p><strong>Bedrooms:</strong> 2</p>
                          <p><strong>Bathrooms:</strong> 2</p>
                          <div class="add-to-wishlist">
                            <button>Add to Favorites</button>
                          </div>
                        </div>
                      </div>

                      <div class="movie">
                        <img src="img/output_3bedroom.jpg" alt="output_3bedroom">
                        <div class="movie-details">
                          <h2>3 Bedroom House in Western Cape</h2>
                          <p><strong>Price:</strong> R4 900,000</p>
                          <p><strong>Location:</strong> Wolvekraal</p>
                          <p><strong>Bedrooms:</strong> 3</p>
                          <p><strong>Bathrooms:</strong> 2</p>
                          <div class="add-to-wishlist">
                            <button>Add to Favorites</button>
                          </div>
                        </div>
                      </div>

    </div>
    <h2>Movies you might like!</h2>

    <div class="moviescontainer">
                    <div class="movie">
                      <img src="img/output_onebedroom.jpg" alt="output_onebedroom">
                      <div class="movie-details">
                        <h2>1 Bedroom House in JHB</h2>
                        <p><strong>Price:</strong> R500,000</p>
                        <p><strong>Location:</strong> Muldersdrift</p>
                        <p><strong>Bedrooms:</strong> 1</p>
                        <p><strong>Bathrooms:</strong> 2</p>
                        <div class="add-to-wishlist">
                          <button>Add to Favorites</button>
                        </div>
                      </div>
                    </div>

                    <div class="movie">
                        <img src="img/output_2bedroom.jpg" alt="output_2bedroom">
                        <div class="movie-details">
                          <h2>2 Bedroom House in Eastern Cape</h2>
                          <p><strong>Price:</strong> R650,000</p>
                          <p><strong>Location:</strong> Papkuilsfontein</p>
                          <p><strong>Bedrooms:</strong> 2</p>
                          <p><strong>Bathrooms:</strong> 2</p>
                          <div class="add-to-wishlist">
                            <button>Add to Favorites</button>
                          </div>
                        </div>
                      </div>

                      <div class="movie">
                        <img src="img/output_3bedroom.jpg" alt="output_3bedroom">
                        <div class="movie-details">
                          <h2>3 Bedroom House in Western Cape</h2>
                          <p><strong>Price:</strong> R4 900,000</p>
                          <p><strong>Location:</strong> Wolvekraal</p>
                          <p><strong>Bedrooms:</strong> 3</p>
                          <p><strong>Bathrooms:</strong> 2</p>
                          <div class="add-to-wishlist">
                            <button>Add to Favorites</button>
                          </div>
                        </div>
                      </div>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>HOOP</span></strong>. All Rights Reserved.
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/photofolio-bootstrap-photography-website-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader">
    <div class="line"></div>
  </div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/filtering.js"></script>
  <script src="assets/js/GetRecommendations.js"></script>


  <script src="assets/js/logout.js"></script>
  <script>
        const typeSelector = document.getElementById('type-selector');
        const seasonsGroup = document.getElementById('seasons-group');
        const seasonsInput = document.getElementById('seasons');

        typeSelector.addEventListener('change', function() {
            if (typeSelector.value === 'tvshow') {
                seasonsGroup.style.display = 'flex';
                seasonsInput.required = true;
            } else {
                seasonsGroup.style.display = 'none';
                seasonsInput.required = false;
            }
        });
    </script>

</body>

</html>