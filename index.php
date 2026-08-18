<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle   = 'Home';
$pageHeading = '';
$noBanner    = true;
$activeNav   = 'home';
require __DIR__ . '/includes/header.php';
?>
  <!-- ============ HERO SECTION ============
       The background is a real generated video (videos/campus-tour.mp4)
       - muted, auto-playing, and looping, with the poster image (a
       still frame from the video) shown while it loads. "playsinline"
       is required for autoplay to work on mobile browsers. -->
  <div class="hero">
    <video class="hero-video" autoplay muted loop playsinline poster="images/campus-tour-poster.jpg">
      <source src="videos/Bacground video.mp4" type="video/mp4">
    </video>
    <div class="hero-overlay"></div>
    <div class="container hero-content">
      <span class="eyebrow">Est. 1959 &middot; Addis Ababa, Ethiopia</span>
      <h1>Shaping Ethiopia's Next Generation of Educators</h1>
      <p>Kotebe University of Education (KUE) is Ethiopia's flagship university dedicated to teacher education, producing competent professionals since 1959.</p>
      <div class="hero-buttons">
        <a href="admission.php" class="btn">Apply Now</a>
        <a href="about.php" class="btn btn-outline">Learn More</a>
      </div>
    </div>
  </div>

  <!-- ============ STATS STRIP ============ -->
  <div class="stats-strip">
    <div class="container stats-grid">
      <div class="stat-item"><span class="stat-number" data-count="5">0</span><span class="stat-label">Faculties</span></div>
      <div class="stat-item"><span class="stat-number" data-count="65" data-suffix="+">0</span><span class="stat-label">Years of Legacy</span></div>
      <div class="stat-item"><span class="stat-number" data-count="12000" data-suffix="+">0</span><span class="stat-label">Students</span></div>
      <div class="stat-item"><span class="stat-number" data-count="98" data-suffix="%">0</span><span class="stat-label">Graduate Placement</span></div>
    </div>
  </div>

  <!-- ============ WHY CHOOSE KUE (icon features) ============ -->
  <section>
    <div class="container">
      <p class="label center">Why Choose KUE</p>
      <h2 class="center">Built for future educators</h2>

      <div class="feature-grid">
        <div class="feature-item">
          <div class="icon-badge"><svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="5"/><polyline points="8.5 12.5 7 22 12 19 17 22 15.5 12.5"/></svg></div>
          <h3>Excellence</h3>
          <p>Committed to excellence in every program, from certificate to doctoral level.</p>
        </div>
        <div class="feature-item">
          <div class="icon-badge"><svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 4v6c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V6z"/><polyline points="9 12 11 14 15 10"/></svg></div>
          <h3>Accredited</h3>
          <p>Nationally recognized programs built on a rigorous, research-based curriculum.</p>
        </div>
        <div class="feature-item">
          <div class="icon-badge"><svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3"/><path d="M2 21v-1a6 6 0 0 1 12 0v1"/><circle cx="17" cy="9" r="2.5"/><path d="M15 21v-1a5 5 0 0 1 7-4.5"/></svg></div>
          <h3>Community</h3>
          <p>A vibrant campus of over 12,000 students, faculty and staff.</p>
        </div>
        <div class="feature-item">
          <div class="icon-badge"><svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18h6"/><path d="M10 21h4"/><path d="M12 3a6 6 0 0 0-4 10.5c.7.6 1 1.4 1 2.5h6c0-1.1.3-1.9 1-2.5A6 6 0 0 0 12 3z"/></svg></div>
          <h3>Innovation</h3>
          <p>Modern teaching practices, informed by international partnerships.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ ABOUT PREVIEW ============ -->
  <section class="section-alt">
    <div class="container about-preview">
      <div class="about-preview-image">
        <img src="images/KUE_1.jfif" alt="KUE students on campus">
      </div>
      <div class="about-preview-text">
        <p class="label">About KUE</p>
        <h2>A specialized mandate, built for teacher education</h2>
        <p>Founded in 1959, KUE has grown over nearly 65 years into Ethiopia's dedicated university of education, training the teachers and education leaders who shape the country's classrooms.</p>
        <a href="about.php" class="btn">Read Our Story</a>
      </div>
    </div>
  </section>

  <!-- ============ COLLEGES PREVIEW (icon cards) ============ -->
  <section>
    <div class="container">
      <p class="label center">Five Faculties</p>
      <h2 class="center">Where future educators are trained</h2>

      <div class="cards">
        <div class="card">
          <div class="icon-badge icon-badge-sm"><svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h6a2 2 0 0 1 2 2v14a2 2 0 0 0-2-2H4z"/><path d="M20 4h-6a2 2 0 0 0-2 2v14a2 2 0 0 1 2-2h6z"/></svg></div>
          <h3>Faculty of Educational Sciences</h3>
          <p>Curriculum studies, educational psychology, leadership and special needs education.</p>
        </div>
        <div class="card">
          <div class="icon-badge icon-badge-sm"><svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 2v6L4 20a1 1 0 0 0 1 2h14a1 1 0 0 0 1-2L15 8V2"/><line x1="8" y1="2" x2="16" y2="2"/><line x1="7" y1="15" x2="17" y2="15"/></svg></div>
          <h3>Faculty of Computational Science</h3>
          <p>Biology, chemistry, physics, mathematics and IT teacher training.</p>
        </div>
        <div class="card">
          <div class="icon-badge icon-badge-sm"><svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15 15 0 0 1 0 20 15 15 0 0 1 0-20"/></svg></div>
          <h3>Faculty of Languages &amp; Literature</h3>
          <p>Amharic, English and Oromo languages and literature programs.</p>
        </div>
      </div>

      <p class="center"><a href="faculties.php" class="card-link">See all Faculties &rarr;</a></p>
    </div>
  </section>

  <!-- ============ TESTIMONIALS ============ -->
  <section class="section-alt">
    <div class="container">
      <p class="label center">Voices from Campus</p>
      <h2 class="center">What our community says</h2>

      <div class="testimonial-grid">
        <div class="testimonial-card">
          <div class="quote-icon"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 7a3 3 0 0 0-3 3v4a2 2 0 0 0 2 2h2v-8H6a1 1 0 0 1 1-1z"/><path d="M17 7a3 3 0 0 0-3 3v4a2 2 0 0 0 2 2h2v-8h-2a1 1 0 0 1 1-1z"/></svg></div>
          <p>"KUE gave me the practical teaching experience I needed before stepping into my own classroom."</p>
          <div class="testimonial-author">
            <span class="avatar">MT</span>
            <div>
              <strong>Meron T.</strong>
              <span>BEd Graduate, 2025</span>
            </div>
          </div>
        </div>
        <div class="testimonial-card">
          <div class="quote-icon"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 7a3 3 0 0 0-3 3v4a2 2 0 0 0 2 2h2v-8H6a1 1 0 0 1 1-1z"/><path d="M17 7a3 3 0 0 0-3 3v4a2 2 0 0 0 2 2h2v-8h-2a1 1 0 0 1 1-1z"/></svg></div>
          <p>"The faculty pushed me to think about education as a system, not just a classroom."</p>
          <div class="testimonial-author">
            <span class="avatar">DA</span>
            <div>
              <strong>Dawit A.</strong>
              <span>MEd Student</span>
            </div>
          </div>
        </div>
        <div class="testimonial-card">
          <div class="quote-icon"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 7a3 3 0 0 0-3 3v4a2 2 0 0 0 2 2h2v-8H6a1 1 0 0 1 1-1z"/><path d="M17 7a3 3 0 0 0-3 3v4a2 2 0 0 0 2 2h2v-8h-2a1 1 0 0 1 1-1z"/></svg></div>
          <p>"Science Shared Campus opened doors I didn't know existed for a student like me."</p>
          <div class="testimonial-author">
            <span class="avatar">HB</span>
            <div>
              <strong>Hana B.</strong>
              <span>Science Shared Campus</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ NEWS PREVIEW ============ -->
  <section>
    <div class="container">
      <p class="label center">Latest News</p>
      <h2 class="center">From the university</h2>

      <div class="cards">
        <div class="card">
          <h3>Class of 2026 graduation</h3>
          <p>Congratulations to our newest graduates across all five colleges.</p>
        </div>
        <div class="card">
          <h3>Science Shared Campus success</h3>
          <p>Gifted high-school students continue to top national exam results.</p>
        </div>
        <div class="card">
          <h3>New partnership discussions</h3>
          <p>KUE meets with international universities to expand research ties.</p>
        </div>
      </div>
      <p class="center"><a href="news.php" class="card-link">Read all news &rarr;</a></p>
    </div>
  </section>

  <!-- ============ CTA BAND ============ -->
  <section class="cta-band">
    <div class="container cta-band-inner">
      <div>
        <h2>Ready to become an educator?</h2>
        <p>Applications for undergraduate, postgraduate and diploma programs are open.</p>
      </div>
      <a href="admission.php" class="btn">Apply Now</a>
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
