document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registerForm');
  
    form.addEventListener('submit', async function (e) {
      e.preventDefault(); // Prevent the default form submission
  
      // Gather the form data
      const formData = {
        name: document.getElementById('name').value,
        username: document.getElementById('username').value,
        age: document.getElementById('age').value,
        email: document.getElementById('email').value,
        password: document.getElementById('password').value,
      };

      try {
        const response = await fetch('http://localhost/hoop_tshepi/COS221P5/register.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(formData),
        });

        if(response.ok) {
          try {
            const result = JSON.parse(text); // Parse the text as JSON
            window.location.href = 'login.php';
            alert('Registration successful: ' + result.data.username);
          } catch (jsonError) {
            console.error('Error parsing JSON:', jsonError);
            alert('Registration successful, but the response is not valid JSON.');
          }
          // const result = await response.json();
          // alert('Registration successful: ' + result.message);
        } else {
          // const error = await response.json();
          // alert('Registration failed: ' + error.message);
          try {
            const error = JSON.parse(text); // Parse the text as JSON
            alert('Registration failed: ' + error.data);
          } catch (jsonError) {
            console.error('Error parsing JSON:', jsonError);
            alert('Registration failed, and the response is not valid JSON.');
          }
        }
      } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
      }
    });
  });
  