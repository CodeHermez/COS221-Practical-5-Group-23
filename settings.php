<!-- addUserGenre.html -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Update Your Information</title>
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
    <link href="assets/css/main.css" rel="stylesheet">

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
          <br>
          <br>
        </div>
      </div>
    </div>
  <!-- ======= LOGGING GENRE ======= -->
 <main>
 <h1>Add User Genre</h1>
    <label for="genre" class="genre-label">Genre:</label>
    <input type="text" id="genre" placeholder="Enter genre...">
    
    <!-- <label for="genre" class="genre-label">Genre:</label>
    <input type="text" id="genre" name="genre"><br><br> -->

    <button id="add-genre-button" >Add Genre</button>
    <br>
    <br>


    <section id="settings" class="settings">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h2>Account Information</h2>
                        <form id="settingsForm">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" >
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" >
                            </div>
                            <div class="mb-3">
                                <label for="age" class="form-label">Age</label>
                                <input type="number" class="form-control" id="age" name="age" >
                            </div>
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">Profile Picture (ID)</label>
                                <input type="number" class="form-control" id="profile_picture" name="profile_picture" >
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                        <div id="responseMessage" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </section>
 </main>
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


    <script src="assets/js/AddUserGenre.js"></script>
    <script src="assets/js/logout.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/settings.js"></script>



</body>
</html>
