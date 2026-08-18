<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle   = 'Research';
$pageHeading = 'Research & Innovation';
$bannerImage = 'images/research.jpg';
$activeNav   = 'research';
require __DIR__ . '/includes/header.php';
?>


  <section>
    <div class="container">
      <p class="label">Research Direction</p>
      <h2>Grounded in Ethiopia, informed by global practice</h2>
      <p>KUE's research agenda centers on education: curriculum design, teaching practice, educational leadership and inclusive education. The university draws on partner institutions abroad to shape its own research roadmap.</p>

      <div class="cards">
        <div class="card"><h3>Curriculum &amp; Instruction</h3><p>Research into instructional design and delivery.</p></div>
        <div class="card"><h3>Educational Leadership</h3><p>Policy and leadership research for school systems.</p></div>
        <div class="card"><h3>Inclusive Education</h3><p>Research supporting special-needs education.</p></div>
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
