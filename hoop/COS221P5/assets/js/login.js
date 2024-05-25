document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
  
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const remember = document.getElementById('remember').checked;
  
    const data = {
      email: email,
      password: password,
      remember: remember
    };
  
    fetch('login.php', {//API ENDPOINT
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        alert('Login successful!');
        // Redirect to home page
        header("Location:index.php");
      } else {
        alert('Login failed: ' + data.message);
        //redirect back to login.
        header("Location:loginpage.php");
      }
    })
    .catch((error) => {
      console.error('Error:', error);
      alert('An error occurred. Please try again later.');
    });
  });
  