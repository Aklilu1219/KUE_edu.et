<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle   = 'Admission';
$pageHeading = 'Admission';
$bannerImage = 'images/students.jpg';
$activeNav   = 'admission';

$user = current_user();
$appMessage = '';
$appMessageType = 'error';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'submit_application') {
    if (!$user) {
        $appMessage = "Please log in (or create an account) before submitting.";
    } else {
        $name    = trim($_POST['app_name'] ?? '');
        $email   = trim($_POST['app_email'] ?? '');
        $phone   = trim($_POST['app_phone'] ?? '');
        $degree  = trim($_POST['app_degree'] ?? '');
        $program = trim($_POST['app_program'] ?? '');
        $terms   = isset($_POST['app_terms']);

        if ($name === '') {
            $appMessage = "Please enter your full name.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $appMessage = "Please enter a valid email address.";
        } elseif (!preg_match('/^[0-9]{9,}$/', $phone)) {
            $appMessage = "Please enter a valid phone number (digits only, at least 9 digits).";
        } elseif ($degree === '') {
            $appMessage = "Please select a degree level.";
        } elseif ($program === '') {
            $appMessage = "Please select a program.";
        } elseif (!$terms) {
            $appMessage = "Please confirm the information provided is accurate and complete.";
        } else {
            $fullProgram = $degree . ' - ' . $program;
            $stmt = $conn->prepare(
                "INSERT INTO applications (user_id, program, applicant_name, applicant_email, applicant_phone)
                 VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->bind_param("issss", $user['id'], $fullProgram, $name, $email, $phone);
            if ($stmt->execute()) {
                $appMessage = "Application submitted! Track its status from your dashboard.";
                $appMessageType = 'success';
            } else {
                $appMessage = "Something went wrong submitting your application. Please try again.";
            }
            $stmt->close();
        }
    }
}

require __DIR__ . '/includes/header.php';
?>


  <section>
    <div class="container">
      <p class="label">How To Apply</p>
      <h2>Four steps to enrollment</h2>
      <div class="cards">
        <div class="card"><h3>1. Choose your program</h3><p>Review programs and entry requirements.</p></div>
        <div class="card"><h3>2. Prepare documents</h3><p>Transcripts, exam results and identification.</p></div>
        <div class="card"><h3>3. Submit application</h3><p>Apply online in four short steps below.</p></div>
        <div class="card"><h3>4. Register</h3><p>Complete registration ahead of the semester.</p></div>
      </div>
    </div>
  </section>

  <section class="section-alt">
    <div class="container" style="max-width:720px;" id="admissionWizard">
      <p class="label">Apply Now</p>
      <h2>Submit your application</h2>
      <p>Complete every step below - your progress is saved automatically in this browser, so you can safely close the tab and pick up later.</p>

      <!-- Shown only if nobody is logged in -->
      <?php if (!$user): ?>
      <div class="notice-box" id="admissionLoginNotice">
        You need an account to submit an application.
        <a href="login.php">Log in</a> or <a href="register.php">create account</a> first.
      </div>
      <?php endif; ?>

      <!-- Resume-draft banner, shown by enhanced.js if a saved draft exists -->
      <div class="draft-banner hidden" id="draftBanner">
        <span>We found a saved draft application from earlier.</span>
        <div>
          <button type="button" id="draftRestoreBtn">Resume draft</button>
          &nbsp;&middot;&nbsp;
          <button type="button" id="draftDiscardBtn">Discard</button>
        </div>
      </div>

      <!-- Step progress indicator -->
      <ul class="step-progress" id="admissionProgress">
        <li data-step="1">Personal Info</li>
        <li data-step="2">Program</li>
        <li data-step="3">Documents</li>
        <li data-step="4">Review</li>
      </ul>

      <!-- The real, validated form - now handled server-side in PHP
           at the top of this file (checks login, validates each
           field, and saves the application to the database).
           enhanced.js only adds step navigation, live per-field
           styling, the dropzone, and draft autosave; it no longer
           owns the actual submission. -->
      <form class="contact-form" id="admissionForm" method="POST" action="admission.php" novalidate>
        <input type="hidden" name="action" value="submit_application">

        <!-- STEP 1: Personal information -->
        <div class="form-step active">
          <div class="form-row">
            <div>
              <label for="appName">Full name</label>
              <input type="text" id="appName" name="app_name" data-required autocomplete="name" value="<?php echo h($user['full_name'] ?? ''); ?>">
              <p class="field-error" id="appNameError"></p>
            </div>
            <div>
              <label for="appDob">Date of birth</label>
              <input type="date" id="appDob" data-required>
            </div>
          </div>
          <div class="form-row">
            <div>
              <label for="appEmail">Email address</label>
              <input type="email" id="appEmail" name="app_email" data-required autocomplete="email">
              <p class="field-error" id="appEmailError"></p>
            </div>
            <div>
              <label for="appPhone">Phone number</label>
              <input type="tel" id="appPhone" name="app_phone" placeholder="e.g. 0911234567" data-required data-pattern="^[0-9]{9,}$">
              <p class="field-error" id="appPhoneError"></p>
            </div>
          </div>
          <label for="appNationality">Nationality</label>
          <input type="text" id="appNationality" placeholder="e.g. Ethiopian" data-required>

          <div class="step-nav">
            <span></span>
            <button type="button" class="btn" data-next>Next: Program &rarr;</button>
          </div>
        </div>

        <!-- STEP 2: Program & degree selection -->
        <div class="form-step">
          <label for="appDegreeLevel">Degree level</label>
          <select id="appDegreeLevel" name="app_degree" data-required>
            <option value="">-- Select a degree level --</option>
            <option value="Certificate">Certificate</option>
            <option value="Diploma">Diploma</option>
            <option value="Undergraduate">Undergraduate (BA/BEd/BSc)</option>
            <option value="Postgraduate">Postgraduate (MA/MEd/MSc)</option>
            <option value="PhD">PhD</option>
          </select>

          <label for="appProgram">Program / College</label>
          <select id="appProgram" name="app_program" data-required>
            <option value="">-- Select a program --</option>
            <option value="Educational Sciences">Faculty of Educational Sciences</option>
            <option value="Science & Mathematics Education">College of Science &amp; Mathematics Education</option>
            <option value="Languages Education">Faculty of Languages Education</option>
            <option value="Business, Technology & Vocational Education">College of Business, Technology &amp; Vocational Education</option>
            <option value="Social Sciences & Law">Faculty of Social Sciences &amp; Law</option>
          </select>
          <p class="field-error" id="appProgramError"></p>

          <label for="appIntake">Intake term</label>
          <select id="appIntake" data-required>
            <option value="">-- Select an intake --</option>
            <option value="September 2026">September 2026</option>
            <option value="February 2027">February 2027</option>
          </select>

          <div class="step-nav">
            <button type="button" class="btn-outline-dark" data-prev>&larr; Back</button>
            <button type="button" class="btn" data-next>Next: Documents &rarr;</button>
          </div>
        </div>

        <!-- STEP 3: Document upload -->
        <div class="form-step">
          <p class="field-hint mt-0">Required documents - upload each one below (drag &amp; drop or click to browse). Files stay in your browser only; nothing is uploaded to a server in this demo.</p>
          <div class="doc-required-list">
            <span class="doc-chip" data-doc="Transcript">Academic Transcript</span>
            <span class="doc-chip" data-doc="ID / Passport">National ID / Passport</span>
            <span class="doc-chip" data-doc="Passport Photo">Passport Photo</span>
          </div>

          <div class="dropzone" id="docDropzone">
            <svg viewBox="0 0 24 24" width="34" height="34" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="M7 8l5-5 5 5"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
            <p><strong>Click to upload</strong> or drag files here</p>
            <p>PDF, JPG or PNG - up to 10MB each</p>
          </div>
          <input type="file" id="docFileInput" multiple hidden accept=".pdf,.jpg,.jpeg,.png">
          <ul class="file-list" id="docFileList"></ul>

          <div class="step-nav">
            <button type="button" class="btn-outline-dark" data-prev>&larr; Back</button>
            <button type="button" class="btn" data-next>Next: Review &rarr;</button>
          </div>
        </div>

        <!-- STEP 4: Review & submit -->
        <div class="form-step">
          <p class="field-hint mt-0">Review your details, then submit. You can still go back and change anything first.</p>
          <dl class="review-grid" id="reviewSummary"></dl>
          <p id="reviewDocs" style="font-size:13.5px;color:var(--kue-text-soft);"></p>

          <label style="display:flex;align-items:center;gap:8px;font-weight:normal;margin-top:18px;">
            <input type="checkbox" id="appTerms" name="app_terms" data-required style="width:auto;">
            I confirm the information provided is accurate and complete.
          </label>

          <div class="step-nav">
            <button type="button" class="btn-outline-dark" data-prev>&larr; Back</button>
            <button type="submit" class="btn">Submit Application</button>
          </div>
        </div>

        <?php if ($appMessage): ?>
          <p id="applicationMessage" style="color:<?php echo $appMessageType === 'success' ? 'green' : '#c0392b'; ?>;"><?php echo h($appMessage); ?></p>
        <?php else: ?>
          <p id="applicationMessage"></p>
        <?php endif; ?>
      </form>
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
