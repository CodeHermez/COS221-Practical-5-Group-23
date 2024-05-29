document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
  
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

  
    const data = {
      email: email,
      password: password,
    };
    console.log('Form submitted'); // Debugging statement
    console.log('Data to send:', data); // Debugging statement
  
    fetch('login.php', {//API ENDPOINT
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
    .then(response => {
      console.log('Response status:', response.status); // Debugging statement
      return response.json();
    })
    .then(data => {
      console.log('Response data:', data); // Debugging statement
      if (data.status === 'success') {
        //alert('Login successful!');
      // Store username and profile picture in local storage
      localStorage.setItem('username', data.data.username);
      localStorage.setItem('profile', data.data.profile_picture);
        // Redirect to home page
        window.location.href= 'index.php';
      } else {
        alert('Login failed: ' + data.data || "Unknown error");
        //redirect back to login.
        window.location.href = 'loginpage.php';
      }
    })
    .catch((error) => {
      console.error('Error:', error);
      alert('An error occurred. Please try again later.');
    });
  });
  