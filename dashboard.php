<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
$user = current_user();

$message = '';
$messageType = 'error'; // or 'success'

// ---- STUDENT: submit a new application ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'submit_application') {
    $program = trim($_POST['program'] ?? '');

    if ($program === '') {
        $message = "Please choose a program before submitting.";
    } elseif (strlen($program) > 150) {
        $message = "Program name is too long.";
    } else {
        // Prevent duplicate pending applications for the same program.
        $stmt = $conn->prepare("SELECT id FROM applications WHERE user_id = ? AND program = ? AND status = 'pending'");
        $stmt->bind_param("is", $user['id'], $program);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $message = "You already have a pending application for \"$program\".";
        } else {
            $stmt2 = $conn->prepare("INSERT INTO applications (user_id, program) VALUES (?, ?)");
            $stmt2->bind_param("is", $user['id'], $program);
            if ($stmt2->execute()) {
                $message = "Application for \"$program\" submitted successfully.";
                $messageType = 'success';
            } else {
                $message = "Something went wrong submitting your application. Please try again.";
            }
            $stmt2->close();
        }
        $stmt->close();
    }
}

// ---- STAFF/ADMIN: update an application's status ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status'
    && in_array($user['role'], ['staff', 'admin'], true)) {

    $appId     = (int) ($_POST['application_id'] ?? 0);
    $newStatus = $_POST['status'] ?? '';
    $allowed   = ['pending', 'under_review', 'accepted', 'rejected'];

    if (!in_array($newStatus, $allowed, true)) {
        $message = "Invalid status selected.";
    } elseif ($appId <= 0) {
        $message = "Invalid application reference.";
    } else {
        $stmt = $conn->prepare("UPDATE applications SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $newStatus, $appId);
        if ($stmt->execute()) {
            $message = "Application #$appId updated to \"" . str_replace('_', ' ', $newStatus) . "\".";
            $messageType = 'success';
        } else {
            $message = "Could not update that application. Please try again.";
        }
        $stmt->close();
    }
}

$pageTitle   = 'Dashboard';
$pageHeading = 'Dashboard';
require __DIR__ . '/includes/header.php';
?>

  <section>
    <div class="container">
      <p class="label">Dashboard</p>
      <h2>Welcome, <?php echo h($user['full_name']); ?>!</h2>
      <p><span class="role-badge role-<?php echo h($user['role']); ?>"><?php echo h(ucfirst($user['role'])); ?></span></p>

      <?php if (isset($_GET['error']) && $_GET['error'] === 'forbidden'): ?>
        <p style="background:#fdeaea; color:#a12626; padding:12px 16px; border-radius:6px;">You don't have permission to view that page.</p>
      <?php endif; ?>

      <?php if ($message): ?>
        <p style="background:<?php echo $messageType === 'success' ? '#e6f6ea' : '#fdeaea'; ?>; color:<?php echo $messageType === 'success' ? '#1c7c3f' : '#a12626'; ?>; padding:12px 16px; border-radius:6px;">
          <?php echo h($message); ?>
        </p>
      <?php endif; ?>

      <?php if ($user['role'] === 'student'): ?>
        <!-- ============ STUDENT VIEW ============ -->
        <h3>Submit an Application</h3>
        <form class="contact-form" method="POST" action="dashboard.php" style="max-width:420px;">
          <input type="hidden" name="action" value="submit_application">
          <label for="program">Program</label>
          <select id="program" name="program">
            <option>Bachelor of Education - Mathematics</option>
            <option>Bachelor of Education - English</option>
            <option>Master of Education - Curriculum Studies</option>
            <option>PhD in Educational Leadership</option>
          </select>
          <br><br>
          <button type="submit" class="btn">Submit Application</button>
        </form>

        <h3 style="margin-top:30px;">My Applications</h3>
        <?php
        $stmt = $conn->prepare("SELECT id, program, status, submitted_at FROM applications WHERE user_id = ? ORDER BY submitted_at DESC");
        $stmt->bind_param("i", $user['id']);
        $stmt->execute();
        $apps = $stmt->get_result();
        if ($apps->num_rows === 0):
        ?>
          <p style="color:#777;">You haven't submitted any applications yet.</p>
        <?php else: ?>
          <table style="width:100%; border-collapse:collapse;">
            <tr style="text-align:left; border-bottom:1px solid #ddd;">
              <th style="padding:8px;">Program</th><th style="padding:8px;">Status</th><th style="padding:8px;">Submitted</th>
            </tr>
            <?php while ($row = $apps->fetch_assoc()): ?>
              <tr style="border-bottom:1px solid #eee;">
                <td style="padding:8px;"><?php echo h($row['program']); ?></td>
                <td style="padding:8px;"><?php echo h(str_replace('_', ' ', ucfirst($row['status']))); ?></td>
                <td style="padding:8px;"><?php echo h($row['submitted_at']); ?></td>
              </tr>
            <?php endwhile; ?>
          </table>
        <?php endif; $stmt->close(); ?>

      <?php else: ?>
        <!-- ============ STAFF & ADMIN VIEW ============ -->
        <h3>All Applications</h3>
        <p style="font-size:14px; color:#777;">Update any application's status below.</p>
        <?php
        $apps = $conn->query(
            "SELECT a.id, a.program, a.status, a.submitted_at, u.full_name, u.username
             FROM applications a JOIN users u ON u.id = a.user_id
             ORDER BY a.submitted_at DESC"
        );
        if ($apps->num_rows === 0):
        ?>
          <p style="color:#777;">No applications have been submitted yet.</p>
        <?php else: ?>
          <table style="width:100%; border-collapse:collapse;">
            <tr style="text-align:left; border-bottom:1px solid #ddd;">
              <th style="padding:8px;">Applicant</th><th style="padding:8px;">Program</th><th style="padding:8px;">Status</th><th style="padding:8px;">Update</th>
            </tr>
            <?php while ($row = $apps->fetch_assoc()): ?>
              <tr style="border-bottom:1px solid #eee;">
                <td style="padding:8px;"><?php echo h($row['full_name']); ?> (<?php echo h($row['username']); ?>)</td>
                <td style="padding:8px;"><?php echo h($row['program']); ?></td>
                <td style="padding:8px;"><?php echo h(str_replace('_', ' ', ucfirst($row['status']))); ?></td>
                <td style="padding:8px;">
                  <form method="POST" action="dashboard.php" style="display:flex; gap:6px;">
                    <input type="hidden" name="action" value="update_status">
                    <input type="hidden" name="application_id" value="<?php echo (int) $row['id']; ?>">
                    <select name="status">
                      <?php foreach (['pending','under_review','accepted','rejected'] as $s): ?>
                        <option value="<?php echo $s; ?>" <?php echo $row['status'] === $s ? 'selected' : ''; ?>><?php echo ucfirst(str_replace('_',' ',$s)); ?></option>
                      <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn" style="padding:6px 12px;">Save</button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          </table>
        <?php endif; ?>

        <?php if ($user['role'] === 'admin'): ?>
          <p style="margin-top:20px;"><a href="admin/index.php" class="btn">Go to Admin Panel &rarr;</a></p>
        <?php endif; ?>
      <?php endif; ?>

      <br>
      <a href="logout.php" class="btn">Log Out</a>
    </div>
  </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
