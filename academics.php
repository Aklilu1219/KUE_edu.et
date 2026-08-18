<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle   = 'Academics';
$pageHeading = 'Academic Programs';
$bannerImage = 'images/library.jpg';
$activeNav   = 'academics';
require __DIR__ . '/includes/header.php';
?>


  <section>
    <div class="container">
      <p class="label">Program Levels</p>
      <h2>Certificate through doctoral study</h2>
      <div class="cards">
        <div class="card"><h3>Certificate &amp; Diploma</h3><p>Foundational teacher-training qualifications.</p></div>
        <div class="card"><h3>Undergraduate (BEd)</h3><p>Bachelor's degrees across all five colleges.</p></div>
        <div class="card"><h3>Postgraduate (MEd)</h3><p>Master's-level specialization programs.</p></div>
        <div class="card"><h3>Doctoral (DEd/PhD)</h3><p>Doctoral study in education.</p></div>
      </div>
    </div>
  </section>

  <section class="section-alt">
    <div class="container">
      <p class="label">Academic Calendar (Indicative)</p>
      <h2>2025/2026 Academic Year</h2>
      <table>
        <tr><th>Milestone</th><th>Period</th></tr>
        <tr><td>New student registration</td><td>September</td></tr>
        <tr><td>Semester I instruction</td><td>September - January</td></tr>
        <tr><td>Semester II instruction</td><td>February - June</td></tr>
        <tr><td>Exams &amp; graduation</td><td>June - July</td></tr>
      </table>
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
