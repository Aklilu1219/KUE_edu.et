<?php
require_once __DIR__ . '/includes/auth.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// If the user is already logged in, redirect them
if (current_user()) {
    header("Location: dashboard.php");
    exit;
}

$error    = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = "Please enter both your username and password.";
    } else {
        // Ensure $conn is defined in your auth.php or included config
        $stmt = $conn->prepare("SELECT id, full_name, username, password, role, status FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $error = "No account found with that username.";
        } else {
            $user = $result->fetch_assoc();

            if (!password_verify($password, $user['password'])) {
                $error = "Incorrect password. Please try again.";
            } elseif ($user['status'] === 'pending') {
                $error = "Your staff account is still awaiting administrator approval.";
            } elseif ($user['status'] === 'suspended') {
                $error = "This account has been suspended. Please contact the administrator.";
            } else {
                // Success - regenerate the session ID to guard against session fixation.
                session_regenerate_id(true);
                $_SESSION['kue_user'] = [
                    'id'        => $user['id'],
                    'full_name' => $user['full_name'],
                    'username'  => $user['username'],
                    'role'      => $user['role'],
                ];
                header("Location: dashboard.php");
                exit;
            }
        }
        $stmt->close();
    }
}

$pageTitle   = 'Login';
$pageHeading = 'Login';
require __DIR__ . '/includes/header.php';
?>

  <section>
    <div class="container" style="max-width:420px;">
      <p class="label">Login</p>
      <h2>Log in to your account</h2>

      <?php if ($error): ?>
        <p style="background:#fdeaea; color:#a12626; padding:12px 16px; border-radius:6px;"><?php echo h($error); ?></p>
      <?php endif; ?>

      <?php if (isset($_GET['registered'])): ?>
        <p style="background:#e6f6ea; color:#1c7c3f; padding:12px 16px; border-radius:6px;">Account created - you can log in now.</p>
      <?php endif; ?>

      <form class="contact-form" method="POST" action="login.php">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?php echo h($username); ?>" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <br><br>
        <button type="submit" class="btn">Log In</button>
      </form>

      <p style="margin-top:16px; font-size:14px;">
        Don't have an account? <a href="register.php" class="card-link">Create one</a>
      </p>
    </div>
  </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
Change the login.php into login.hhtml in correct form
