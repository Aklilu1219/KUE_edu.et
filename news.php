<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle   = 'News & Events';
$pageHeading = 'News & Events';
$bannerImage = 'images/campus.jpg';
$activeNav   = 'news';

$user = current_user();
$canPost = $user && in_array($user['role'], ['staff', 'admin'], true);

$newsMessage = '';
$newsMessageType = 'error';

if ($canPost && $_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'post_news') {
    $title = trim($_POST['news_title'] ?? '');
    $body  = trim($_POST['news_body'] ?? '');

    if ($title === '') {
        $newsMessage = "Please enter a title for the announcement.";
    } elseif (strlen($title) > 150) {
        $newsMessage = "Title is too long (150 characters max).";
    } elseif ($body === '') {
        $newsMessage = "Please enter some details for the announcement.";
    } else {
        $stmt = $conn->prepare("INSERT INTO news (title, body, posted_by) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $title, $body, $user['id']);
        if ($stmt->execute()) {
            $newsMessage = "Announcement posted successfully.";
            $newsMessageType = 'success';
        } else {
            $newsMessage = "Something went wrong while posting. Please try again.";
        }
        $stmt->close();
    }
}

require __DIR__ . '/includes/header.php';
?>


  <section>
    <div class="container">

      <div class="notice-box">
	  <h1>Latest You Need to Know !!!</h1>
      </div>

      <?php if ($canPost): ?>
        <div style="margin-top:30px;">
          <p class="label">Add a News Post</p>
          <h2>Post an announcement</h2>

          <?php if ($newsMessage): ?>
            <p style="background:<?php echo $newsMessageType === 'success' ? '#e6f6ea' : '#fdeaea'; ?>; color:<?php echo $newsMessageType === 'success' ? '#1c7c3f' : '#a12626'; ?>; padding:12px 16px; border-radius:6px;">
              <?php echo h($newsMessage); ?>
            </p>
          <?php endif; ?>

          <form class="contact-form" method="POST" action="news.php">
            <input type="hidden" name="action" value="post_news">
            <label for="newsTitle">Title</label>
            <input type="text" id="newsTitle" name="news_title" required>

            <label for="newsText">Details</label>
            <textarea id="newsText" name="news_body" rows="3" required></textarea>

            <br><br>
            <button type="submit" class="btn">Add News</button>
          </form>
        </div>
      <?php endif; ?>

    </div>
  </section>

  <section class="section-alt">
    <div class="container">
      <h2>News &amp; Events</h2>

      <div class="cards">
        <?php
        $result = $conn->query("SELECT n.title, n.body, n.created_at, u.full_name FROM news n JOIN users u ON u.id = n.posted_by ORDER BY n.created_at DESC LIMIT 20");
        if ($result->num_rows === 0):
        ?>
          <p style="color:#777;">No announcements have been posted yet.</p>
        <?php else: while ($row = $result->fetch_assoc()): ?>
          <div class="card">
            <h3><?php echo h($row['title']); ?></h3>
            <p><?php echo nl2br(h($row['body'])); ?></p>
            <p style="font-size:12px; color:#999; margin-top:10px;">
              Posted by <?php echo h($row['full_name']); ?> &middot; <?php echo h($row['created_at']); ?>
            </p>
          </div>
        <?php endwhile; endif; ?>
      </div>
    </div>
  </section>

  <!-- ============ NEWSLETTER STRIP ============ -->
  <div class="newsletter">
    <div class="container newsletter-inner">
      <div>
        <h3>Stay in the loop</h3>
        <p>Get admission deadlines and campus news in your inbox.</p>
      </div>
      <!-- js/script.js shows a thank-you message on submit - see the
           NEWSLETTER section in script.js. -->
      <form id="newsletterForm" class="newsletter-form">
        <input type="email" id="newsletterEmail" placeholder="you@example.com" required>
        <button type="submit" class="btn">Subscribe</button>
      </form>
      <p id="newsletterMessage"></p>
    </div>
  </div>

  <!-- ============ FOOTER ============ -->

<?php require __DIR__ . '/includes/footer.php'; ?>
