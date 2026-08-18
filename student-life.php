<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle   = 'Student Life';
$pageHeading = 'Student Life';
$bannerImage = 'images/students.jpg';
$activeNav   = 'student-life';
require __DIR__ . '/includes/header.php';
?>


  <section>
    <div class="container">
      <p class="label">Campus Community</p>
      <h2>Life on the Kotebe campus</h2>
      <p>Beyond the classroom, KUE students take part in clubs, sports, cultural programs and community service.</p>

      <div class="cards">
        <div class="card"><h3>Housing &amp; Dining</h3><p>On-campus accommodation for eligible students.</p></div>
        <div class="card"><h3>Health Services</h3><p>Campus clinic for student healthcare needs.</p></div>
        <div class="card"><h3>Counseling</h3><p>Academic and personal support services.</p></div>
      </div>
    </div>
  </section>

  <!-- ============ VIRTUAL CAMPUS TOUR & MEDIA HUB ============ -->
  <section class="section-alt">
    <div class="container">
      <p class="label center">Virtual Campus Tour</p>
      <h2 class="center">Explore campus, your way</h2>
      <p class="center">Filter by Facilities, Labs or Sports, or watch the full video tour.</p>

      <div class="hub-tabs" id="hubTabs">
        <button type="button" class="hub-tab active" data-category="All">All Photos</button>
        <button type="button" class="hub-tab" data-category="Facilities">Facilities</button>
        <button type="button" class="hub-tab" data-category="Labs">Labs</button>
        <button type="button" class="hub-tab" data-category="Sports">Sports</button>
        <button type="button" class="hub-tab" data-category="Video">Video Tour</button>
      </div>

      <!-- Photo grid pane -->
      <div id="hubGalleryPane">
        <div class="gallery-grid" id="galleryGrid">
        <figure data-category="Facilities">
          <img src="images/KUE Reg.webp" alt="Main campus">
          <figcaption>Main Campus, Addis Ababa</figcaption>
        </figure>
        <figure data-category="Facilities">
          <img src="images/kue_2.jpg" alt="Administration building">
          <figcaption>Administration Building</figcaption>
        </figure>
        <figure data-category="Facilities">
          <img src="images/library.jpg" alt="Library resources">
          <figcaption>Library &amp; Resources</figcaption>
        </figure>
        <figure data-category="Labs">
          <img src="images/classroom.jpg" alt="Lecture halls">
          <figcaption>Lecture Halls</figcaption>
        </figure>
        <figure data-category="Labs">
          <img src="images/research.jpg" alt="Research and innovation">
          <figcaption>Research &amp; Innovation Labs</figcaption>
        </figure>
        <figure data-category="Sports">
          <img src="images/sports.jpg" alt="Campus sports">
          <figcaption>Campus Sports Grounds</figcaption>
        </figure>
        <figure data-category="Facilities">
          <img src="images/students.jpg" alt="Student community">
          <figcaption>Student Community</figcaption>
        </figure>
        <figure data-category="Facilities">
          <img src="images/graduation.jfif" alt="Graduation day">
          <figcaption>Graduation Day</figcaption>
        </figure>
        </div>
      </div>

      <!-- Video pane (hidden until the "Video Tour" tab is chosen) -->
      <div id="hubVideoPane" class="hidden">
        <div class="video-showcase video-tile" id="videoTile">
          <img src="images/campus-tour-poster.jpg" alt="Campus tour video preview" style="border-radius:10px;">
        </div>
        <p class="center field-hint">Click the preview to play the full campus tour with sound.</p>
      </div>
    </div>
  </section>

  <!-- The lightbox popup itself - one single hidden element, reused
       for whichever image was clicked. Starts hidden (no "open" class). -->
  <div class="lightbox" id="lightbox">
    <button class="lightbox-close" id="lightboxClose" aria-label="Close">&times;</button>
    <img id="lightboxImage" src="" alt="">
    <p id="lightboxCaption"></p>
  </div>

  <!-- Dedicated video lightbox, opened only from the Video Tour tab -->
  <div class="video-lightbox" id="videoLightbox">
    <button class="video-lightbox-close" aria-label="Close video">&times;</button>
    <video controls poster="images/campus-tour-poster.jpg">
      <source src="videos/KUE Vedios.mp4" type="video/mp4">
      Your browser doesn't support embedded video.
    </video>
  </div>

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
