<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN PAGE</title>
  <link rel="stylesheet" href="assets/css/loginstyle.css">
</head>
<body>
  <div class="wrapper">
    <form id="loginForm">
      <h2>Login</h2>
        <div class="input-field">
        <input type="text" id ="email" required>
        <label>Enter your email</label>
      </div>
      <div class="input-field">
        <input type="password" id = "password" required>
        <label>Enter your password</label>
      </div>
      <!-- <div class="forget">
        <label for="remember">
          <input type="checkbox" id="remember">
          <p>Remember me</p>
        </label>
        <a href="#">Forgot password?</a>
      </div> -->
      <button type="submit">Log In</button>
      <div class="register">
        <p>Don't have an account? <a href="registerpage.php">Register</a></p>
      </div>
    </form>
  </div>
  <script src ="assets/js/loginfinal.js"></script>
</body>
</html>