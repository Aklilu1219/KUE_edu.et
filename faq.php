<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle   = 'FAQ';
$pageHeading = 'Frequently Asked Questions';
$bannerImage = 'images/campus.jpg';
$activeNav   = 'faq';
require __DIR__ . '/includes/header.php';
?>


  <section>
    <div class="container" style="max-width:760px;">
      <p class="label center">Frequently Asked Questions</p>
      <h2 class="center">Have a question?</h2>

      <!-- Type here and js/script.js hides any question that doesn't
           match - same pattern as the college search on faculties.html -->
      <input type="text" id="faqSearch" placeholder="Search questions (e.g. 'apply', 'login')...">

      <!-- Each .faq-item starts collapsed. Clicking the question
           button toggles an "open" class - see the FAQ ACCORDION
           section in script.js. -->
      <div id="faqList">

        <div class="faq-item">
          <button class="faq-question" type="button">
            How do I apply to KUE?
            <span class="faq-icon">+</span>
          </button>
          <div class="faq-answer"><p>Create a free account (or log in), then go to the Admission page and fill out the application form with your chosen program. You can track its status afterwards from your Dashboard.</p></div>
        </div>

        <div class="faq-item">
          <button class="faq-question" type="button">
            What colleges does KUE have?
            <span class="faq-icon">+</span>
          </button>
          <div class="faq-answer"><p>Five colleges: Educational Sciences, Science &amp; Mathematics Education, Languages Education, Business/Technology/Vocational Education, and Social Sciences &amp; Law - plus the Science Shared Campus institute. See the Faculties page for details.</p></div>
        </div>

        <div class="faq-item">
          <button class="faq-question" type="button">
            How do I create an account or log in?
            <span class="faq-icon">+</span>
          </button>
          <div class="faq-answer"><p>Click "Login" in the top menu. If you're new, use "Create one" on that page to register - new accounts start with the Student role.</p></div>
        </div>

        <div class="faq-item">
          <button class="faq-question" type="button">
            How can I check my application status?
            <span class="faq-icon">+</span>
          </button>
          <div class="faq-answer"><p>Log in and open your Dashboard. Students see every application they've submitted along with its current status (Pending, Accepted, or Rejected).</p></div>
        </div>

        <div class="faq-item">
          <button class="faq-question" type="button">
            What are the tuition fees?
            <span class="faq-icon">+</span>
          </button>
          <div class="faq-answer"><p>Fees vary by program and modality. Please contact the Registrar's Office directly - see the Contact page for phone, email and our campus map.</p></div>
        </div>

        <div class="faq-item">
          <button class="faq-question" type="button">
            Where is the university located?
            <span class="faq-icon">+</span>
          </button>
          <div class="faq-answer"><p>KUE's main campus is in Kotebe, Yeka Sub-City, Addis Ababa, Ethiopia. See the live map and directions on the Contact page.</p></div>
        </div>

        <div class="faq-item">
          <button class="faq-question" type="button">
            Can I access library resources online?
            <span class="faq-icon">+</span>
          </button>
          <div class="faq-answer"><p>Yes - the Services page lists our library offices and links to e-journal databases available to students and staff.</p></div>
        </div>

      </div>

      <p id="faqNoResults" style="display:none;">No questions match your search.</p>
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
