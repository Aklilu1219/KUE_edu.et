<?php
require_once __DIR__ . '/includes/auth.php';

// Already logged in? No need to register again.
if (current_user()) {
    header("Location: dashboard.php");
    exit;
}

$errors  = [];
$success = '';

// Keep submitted values so the form can be redisplayed without
// forcing the person to retype everything after an error.
$old = [
    'full_name'  => '',
    'username'   => '',
    'email'      => '',
    'student_id' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullName  = trim($_POST['full_name'] ?? '');
    $username  = trim($_POST['username'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $password  = $_POST['password'] ?? '';
    $confirm   = $_POST['confirm_password'] ?? '';
    $studentId = trim($_POST['student_id'] ?? '');

    $old['full_name']  = $fullName;
    $old['username']   = $username;
    $old['email']      = $email;
    $old['student_id'] = $studentId;

    // ---- Field-by-field validation, each with its own specific message ----
    if ($fullName === '') {
        $errors[] = "Full name is required.";
    } elseif (!preg_match("/^[A-Za-z' -]{2,100}$/", $fullName)) {
        $errors[] = "Full name should only contain letters, spaces, apostrophes or hyphens.";
    }

    if ($username === '') {
        $errors[] = "Username is required.";
    } elseif (!preg_match('/^[A-Za-z0-9_]{3,30}$/', $username)) {
        $errors[] = "Username must be 3-30 characters and can only contain letters, numbers and underscores.";
    }

    if ($email === '') {
        $errors[] = "Email address is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address (e.g. name@example.com).";
    }

    if ($password === '') {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $errors[] = "Password must include at least one letter and one number.";
    }

    if ($confirm === '') {
        $errors[] = "Please confirm your password.";
    } elseif ($password !== '' && $password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    if ($studentId !== '' && !preg_match('/^[A-Za-z0-9\/-]{2,20}$/', $studentId)) {
        $errors[] = "Student ID looks invalid - use only letters, numbers, / or -.";
    }

    // Only hit the database once the basic form data itself is valid.
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $errors[] = "This username is already taken. Please choose another.";
        }
        $stmt->close();
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $errors[] = "This email address is already registered. Try logging in instead.";
        }
        $stmt->close();
    }

    if (empty($errors)) {
        $hashed    = password_hash($password, PASSWORD_DEFAULT);
        $studentIdVal = $studentId ?: null;

        // Public registration only ever creates Student accounts, active right away.
        $stmt = $conn->prepare(
            "INSERT INTO users (full_name, username, email, password, role, status, student_id)
             VALUES (?, ?, ?, ?, 'student', 'active', ?)"
        );
        $stmt->bind_param("sssss", $fullName, $username, $email, $hashed, $studentIdVal);

        if ($stmt->execute()) {
            $success = "Account created successfully! You can now log in.";
            $old = ['full_name' => '', 'username' => '', 'email' => '', 'student_id' => ''];
        } else {
            $errors[] = "Something went wrong while saving your account. Please try again.";
        }
        $stmt->close();
    }
}

$pageTitle   = 'Create Account';
$pageHeading = 'Create Account';
$activeNav   = 'register';
require __DIR__ . '/includes/header.php';
?>

  <section>
    <div class="container" style="max-width:460px;">
      <p class="label">Student Registration</p>
      <h2>Create Your Student Account</h2>
      <p style="font-size:14px; color:#777;">
        This form creates a <strong>Student</strong>
      </p>

      <?php if ($success): ?>
        <p style="background:#e6f6ea; color:#1c7c3f; padding:12px 16px; border-radius:6px;"><?php echo h($success); ?></p>
      <?php endif; ?>

      <?php if (!empty($errors)): ?>
        <div style="background:#fdeaea; color:#a12626; padding:12px 16px; border-radius:6px;">
          <ul style="margin:0; padding-left:18px;">
            <?php foreach ($errors as $e): ?>
              <li><?php echo h($e); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form class="contact-form" method="POST" action="register.php">
        <label for="full_name">Full name</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo h($old['full_name']); ?>" required>

        <label for="username">Choose a username</label>
        <input type="text" id="username" name="username" value="<?php echo h($old['username']); ?>" required>

        <label for="email">Email address</label>
        <input type="email" id="email" name="email" value="<?php echo h($old['email']); ?>" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirm password</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <label for="student_id">Student ID (optional)</label>
        <input type="text" id="student_id" name="student_id" value="<?php echo h($old['student_id']); ?>">

        <br><br>
        <button type="submit" class="btn">Create Account</button>
      </form>

      <p style="margin-top:16px; font-size:14px;">
        Already have an account? <a href="login.php" class="card-link">Log in</a>
      </p>
      <p style="font-size:14px;">
        Are you Staff or an Administrator? Ask an existing administrator to create your account from the Admin Panel.
      </p>
    </div>
  </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
