<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Settings - Update Your Information</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <?php include 'header.php'; ?>

    <main id="main" data-aos="fade" data-aos-delay="1500">
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

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/js/main.js"></script>

    <script>
        // Initialize GLightbox
        const lightbox = GLightbox({
            selector: '.glightbox'
        });

        // Initialize Swiper
        var swiper = new Swiper('.swiper-container', {
            speed: 600,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            }
        });

        function updateProfile(data) {
            return new Promise((resolve, reject) => {
                const url = 'http://localhost/221/Prac5/COS221-Practical-5-GROUP-23/hoop/COS221P5/updateProfile.php';

                axios.patch(url, data, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    console.error('Error updating profile:', error); // Log error to console
                    reject(error.response ? error.response.data : error.message);
                });
            });
        }

        document.getElementById('settingsForm').addEventListener('submit', async function (event) {
            event.preventDefault();

            const formData = new FormData(this);
            const jsonData = {};

            // Loop through form data and only include initialized keys
            formData.forEach((value, key) => {
                if (value !== '') { // Check if value is initialized
                    jsonData[key] = value;
                }
            });

            console.log('Submitting updateProfile request with data:', jsonData); // Log request data

            try {
                const response = await updateProfile(jsonData);

                console.log('updateProfile response:', response); // Log response

                const responseMessage = document.getElementById('responseMessage');
                if (response.status === 'success') {
                    responseMessage.innerHTML = `<div class="alert alert-success">${response.message}</div>`;
                } else {
                    responseMessage.innerHTML = `<div class="alert alert-danger">${response.message}</div>`;
                }
            } catch (error) {
                console.error('Error updating profile:', error); // Log error to console
                document.getElementById('responseMessage').innerHTML = `<div class="alert alert-danger">An error occurred: ${error}</div>`;
            }
        });
    </script>
</body>
</html>
