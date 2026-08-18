<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle   = 'About';
$pageHeading = 'About KUE';
$bannerImage = 'images/campus.jpg';
$activeNav   = 'about';
require __DIR__ . '/includes/header.php';
?>


  <section>
    <div class="container">
      <p class="label">Our History</p>
      <h2>Nearly 65 years of teacher education</h2>
      <p>KUE's roots trace back to 1959, when a college of education was established within Haile Selassie I University. In 1976, the institution moved to its present site in Kotebe. Over the following decades it evolved through several names until Proclamation No. 1263/2021 established it as Kotebe University of Education (KUE).</p>

      <!-- A simple visual timeline - just a styled list, no images needed -->
      <ol class="timeline">
        <li><span class="timeline-year">1959</span><span class="timeline-text">Founded within Haile Selassie I University</span></li>
        <li><span class="timeline-year">1976</span><span class="timeline-text">Relocated to Kotebe; becomes KCTE</span></li>
        <li><span class="timeline-year">2014</span><span class="timeline-text">Upgraded to Kotebe University College</span></li>
        <li><span class="timeline-year">2016</span><span class="timeline-text">Becomes Kotebe Metropolitan University</span></li>
        <li><span class="timeline-year">2021</span><span class="timeline-text">Re-established as KUE by Proclamation No. 1263/2021</span></li>
      </ol>
    </div>
  </section>

  <section class="section-alt">
    <div class="container">
      <div class="cards">
        <div class="card">
          <div class="icon-badge icon-badge-sm"><svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="5"/><polyline points="8.5 12.5 7 22 12 19 17 22 15.5 12.5"/></svg></div>
          <h3>Our Vision</h3>
          <p>To be a flagship university of education renowned for producing competent and effective professionals to transform education in Ethiopia and beyond.</p>
        </div>
        <div class="card">
          <div class="icon-badge icon-badge-sm"><svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h6a2 2 0 0 1 2 2v14a2 2 0 0 0-2-2H4z"/><path d="M20 4h-6a2 2 0 0 0-2 2v14a2 2 0 0 1 2-2h6z"/></svg></div>
          <h3>Our Mission</h3>
          <p>To produce competent and effective education professionals as a center of excellence and innovation in teaching and leadership.</p>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <p class="label center">Core Values</p>
      <h2 class="center">What guides us</h2>
      <div class="feature-grid">
        <div class="feature-item">
          <div class="icon-badge"><svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="5"/><polyline points="8.5 12.5 7 22 12 19 17 22 15.5 12.5"/></svg></div>
          <h3>Excellence</h3>
          <p>Committed to excellence in every program.</p>
        </div>
        <div class="feature-item">
          <div class="icon-badge"><svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 4v6c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V6z"/><polyline points="9 12 11 14 15 10"/></svg></div>
          <h3>Integrity</h3>
          <p>Transparent and accountable practice.</p>
        </div>
        <div class="feature-item">
          <div class="icon-badge"><svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18h6"/><path d="M10 21h4"/><path d="M12 3a6 6 0 0 0-4 10.5c.7.6 1 1.4 1 2.5h6c0-1.1.3-1.9 1-2.5A6 6 0 0 0 12 3z"/></svg></div>
          <h3>Innovation</h3>
          <p>Sharing innovative teaching practices.</p>
        </div>
        <div class="feature-item">
          <div class="icon-badge"><svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12l4-4 4 2 4-3 4 3 4-2"/><path d="M6 10l4 6 4-3 4 4"/></svg></div>
          <h3>Partnership</h3>
          <p>Collaborating with local and global partners.</p>
        </div>
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
