!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>REGISTER PAGE</title>
  <link rel="stylesheet" href="assets/css/loginstyle.css">
</head>
<body>
  <div class="wrapper">
    <form id = "registerForm" action="register.php">
      <h2>Register</h2>
      <div class="input-field">
        <input type="name" id = "name" required>
        <label>Enter your name</label>
      </div>

      <div class="input-field">
        <input type="username" id = "username" required>
        <label>Enter your username</label>
      </div>

      <div class="input-field">
        <input type="age" id = "age" required>
        <label>Enter your age</label>
      </div>

        <div class="input-field">
        <input type="text" id ="email" required>
        <label>Enter your email</label>
      </div>
      <div class="input-field">
        <input type="password" id = "password" required>
        <label>Enter your password</label>
      </div>
      <button type="submit" id="register">Register</button>
    </form>
  </div>
  <script src ="assets/js/register.js"></script>
</body>
</html>