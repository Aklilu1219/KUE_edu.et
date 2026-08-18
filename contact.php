<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle   = 'Contact & Feedback Portal';
$pageHeading = 'Contact & Feedback Portal';
$bannerImage = 'images/campus.jpg';
$activeNav   = 'contact';
require __DIR__ . '/includes/header.php';
?>


  <section>
    <div class="container">
      <div class="portal-tabs" id="portalTabs">
        <button type="button" class="portal-tab active" data-pane="contact">Contact Us</button>
        <button type="button" class="portal-tab" data-pane="feedback">Share Feedback</button>
        <button type="button" class="portal-tab" data-pane="track">Track My Feedback</button>
      </div>

      <!-- ---------------- CONTACT PANE ---------------- -->
      <div class="portal-pane active" id="pane-contact">
        <div class="contact-grid">
          <div>
            <p class="label">Get In Touch</p>
            <h2>Send us a message</h2>

            <!-- This form doesn't send data anywhere by itself.
                 js/script.js listens for the "submit" event and
                 shows a thank-you message instead. -->
            <form class="contact-form" id="contactForm">
              <label for="name">Full name</label>
              <input type="text" id="name" required>

              <label for="email">Email address</label>
              <input type="email" id="email" required>

              <label for="message">Message</label>
              <textarea id="message" rows="5" required></textarea>

              <br><br>
              <button type="submit" class="btn">Send Message</button>
              <p id="formMessage"></p>
            </form>
          </div>

          <div class="contact-info-card">
            <p class="label">University Contact</p>
            <ul class="contact-details">
              <li>
                <div class="icon-badge icon-badge-sm"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 12-9 12s-9-5-9-12a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
                <div><strong>Address</strong><span>Kotebe, Yeka Sub-City, Addis Ababa, Ethiopia</span></div>
              </li>
              <li>
                <div class="icon-badge icon-badge-sm"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3.1-8.7A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .3 2 .7 3a2 2 0 0 1-.4 2.1L8 10.3a16 16 0 0 0 6 6l1.5-1.5a2 2 0 0 1 2-.4c1 .3 2 .5 3 .7a2 2 0 0 1 1.5 2.1z"/></svg></div>
                <div><strong>Phone</strong><span>+251 11 833 2827</span></div>
              </li>
              <li>
                <div class="icon-badge icon-badge-sm"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 6 10-6"/></svg></div>
                <div><strong>Email</strong><span>info@kue.edu.et</span></div>
              </li>
            </ul>
          </div>
        </div>

        <!-- ============ LIVE MAP ============ -->
        <div style="margin-top:60px;">
          <p class="label center">Find Us</p>
          <h2 class="center">Visit our campus</h2>
          <div class="map-embed">
            <iframe
              src="https://www.openstreetmap.org/export/embed.html?bbox=38.8274%2C9.0301%2C38.8474%2C9.0501&amp;layer=mapnik&amp;marker=9.0401%2C38.8374"
              loading="lazy"
              title="Map showing Kotebe University of Education location">
            </iframe>
          </div>
          <p class="center map-directions">
            <a href="https://www.openstreetmap.org/?mlat=9.0401&amp;mlon=38.8374#map=16/9.0401/38.8374" target="_blank" rel="noopener" class="card-link">View larger map</a>
            &nbsp;&middot;&nbsp;
            <a href="https://www.google.com/maps/place/Kotebe+University+of+Education/@9.0383594,38.8372519,17z" target="_blank" rel="noopener" class="card-link">Get directions &rarr;</a>
          </p>
        </div>
      </div>

      <!-- ---------------- FEEDBACK PANE ---------------- -->
      <div class="portal-pane" id="pane-feedback">
        <div style="max-width:600px;margin:0 auto;">
          <p class="label center">Feedback</p>
          <h2 class="center">Tell us what you think</h2>
          <p class="center">Your feedback is stored in your own browser only (this is a demo site, not connected to a live server).</p>

          <div class="draft-banner hidden" id="newTicketBanner">
            <span>Thanks! Your tracking ID is <strong id="newTicketId"></strong> - save it to check your status later.</span>
          </div>

          <!-- The star rating: 5 buttons script.js wires up so clicking
               a star highlights it and every star before it - see the
               STAR RATING section in script.js. -->
          <form class="contact-form" id="feedbackForm">
            <label>Your rating</label>
            <div class="star-rating" id="starRating">
              <button type="button" class="star" data-value="1">&#9733;</button>
              <button type="button" class="star" data-value="2">&#9733;</button>
              <button type="button" class="star" data-value="3">&#9733;</button>
              <button type="button" class="star" data-value="4">&#9733;</button>
              <button type="button" class="star" data-value="5">&#9733;</button>
            </div>
            <p class="field-error" id="ratingError"></p>

            <label for="feedbackName">Your name</label>
            <input type="text" id="feedbackName" required>

            <label for="feedbackComment">Your comment</label>
            <textarea id="feedbackComment" rows="4" required></textarea>

            <br><br>
            <button type="submit" class="btn">Submit Feedback</button>
            <p id="feedbackMessage"></p>
          </form>
        </div>

        <div style="max-width:700px;margin:50px auto 0;">
          <p class="label center">From the Community</p>
          <h2 class="center" id="feedbackAverage">Average rating: -</h2>
          <div id="feedbackList"></div>
        </div>
      </div>

      <!-- ---------------- TRACK STATUS PANE ---------------- -->
      <div class="portal-pane" id="pane-track">
        <div class="tracker-box">
          <p class="label center">Live Status Tracker</p>
          <h2 class="center">Track your feedback ticket</h2>
          <p>Enter the tracking ID you received after submitting feedback (e.g. <strong>KUE-FB-1234</strong>) to see a simulated live status update.</p>

          <form class="tracker-form" id="trackForm">
            <input type="text" id="trackInput" placeholder="KUE-FB-1234">
            <button type="submit" class="btn">Check Status</button>
          </form>

          <div id="trackResult"></div>
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
