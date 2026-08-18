<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle   = 'Services';
$pageHeading = 'Offices & Services';
$bannerImage = 'images/library.jpg';
$activeNav   = 'services';
require __DIR__ . '/includes/header.php';
?>


  <section>
    <div class="container">
      <p class="label">Student &amp; Staff Services</p>
      <h2>Offices that keep the university running</h2>
      <div class="cards">
        <div class="card"><div class="icon-badge icon-badge-sm"><svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h6a2 2 0 0 1 2 2v14a2 2 0 0 0-2-2H4z"/><path d="M20 4h-6a2 2 0 0 0-2 2v14a2 2 0 0 1 2-2h6z"/></svg></div><h3>Registrar's Office</h3><p>Registration, transcripts and academic records.</p></div>
        <div class="card"><div class="icon-badge icon-badge-sm"><svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15 15 0 0 1 0 20 15 15 0 0 1 0-20"/></svg></div><h3>Library Services</h3><p>Collections and e-journal access.</p></div>
        <div class="card"><div class="icon-badge icon-badge-sm"><svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18h6"/><path d="M10 21h4"/><path d="M12 3a6 6 0 0 0-4 10.5c.7.6 1 1.4 1 2.5h6c0-1.1.3-1.9 1-2.5A6 6 0 0 0 12 3z"/></svg></div><h3>ICT &amp; E-Learning</h3><p>Campus network and technical support.</p></div>
        <div class="card"><div class="icon-badge icon-badge-sm"><svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3"/><path d="M2 21v-1a6 6 0 0 1 12 0v1"/><circle cx="17" cy="9" r="2.5"/><path d="M15 21v-1a5 5 0 0 1 7-4.5"/></svg></div><h3>Student Affairs</h3><p>Housing, counseling and clubs.</p></div>
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
