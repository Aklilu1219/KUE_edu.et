<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <!-- Link your CSS stylesheet here if you have one -->
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- Optional Header Section (previously included via PHP) -->
  <header>
    <!-- Add your navigation or header elements here -->
  </header>

  <section>
    <div class="container" style="max-width:420px;">
      <p class="label">Login</p>
      <h2>Log in to your account</h2>

      <!-- Static placeholder for errors (can be controlled via JavaScript later if needed) -->
      <!-- 
      <p style="background:#fdeaea; color:#a12626; padding:12px 16px; border-radius:6px; display:none;" id="error-message"></p> 
      -->

      <!-- Form points to your backend processor (e.g., login.php or an API endpoint) -->
      <form class="contact-form" method="POST" action="login-process.php">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <br><br>
        <button type="submit" class="btn">Log In</button>
      </form>

      <p style="margin-top:16px; font-size:14px;">
        Don't have an account? <a href="register.html" class="card-link">Create one</a>
      </p>
    </div>
  </section>

  <!-- Optional Footer Section (previously included via PHP) -->
  <footer>
    <!-- Add your footer elements here -->
  </footer>

</body>
</html>
