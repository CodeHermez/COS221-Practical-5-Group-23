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
          const text = await response.text();
        console.log('Response body:', text);
          const result = await response.json();
          alert('Registration successful: ' + result.message);
        } else {
          const error = await response.json();
          alert('Registration failed: ' + error.message);
        }
      } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
      }
    });
  });
  