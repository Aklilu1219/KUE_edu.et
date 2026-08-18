  <footer>
    <div class="container footer-columns">

        <div class="footer-about">
          <p>Kotebe University of Education &mdash; committed to excellence in education since 1959.</p>

          <div class="social-icons">
            <a href="#" aria-label="Facebook">
              <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M13 22v-8h3l1-4h-4V7.5C13 6.4 13.4 6 14.6 6H17V2.1C16.6 2 15.3 2 13.9 2 11 2 9 3.8 9 7v3H6v4h3v8h4z"/></svg>
            </a>
            <a href="#" aria-label="Twitter">
              <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M22 5.9c-.7.3-1.5.6-2.4.7.8-.5 1.5-1.3 1.8-2.3-.8.5-1.7.8-2.6 1a4.1 4.1 0 0 0-7 3.7A11.6 11.6 0 0 1 3.4 4.6a4.1 4.1 0 0 0 1.3 5.5c-.7 0-1.3-.2-1.9-.5v.1c0 2 1.4 3.6 3.3 4a4.2 4.2 0 0 1-1.9.1c.5 1.6 2 2.8 3.8 2.9A8.3 8.3 0 0 1 2 18.4a11.6 11.6 0 0 0 6.3 1.9c7.5 0 11.7-6.4 11.7-11.9v-.5c.8-.6 1.5-1.3 2-2z"/></svg>
            </a>
            <a href="#" aria-label="YouTube">
              <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M22 12s0-3.2-.4-4.6a2.8 2.8 0 0 0-2-2C17.9 5 12 5 12 5s-5.9 0-7.6.4a2.8 2.8 0 0 0-2 2C2 8.8 2 12 2 12s0 3.2.4 4.6a2.8 2.8 0 0 0 2 2C6.1 19 12 19 12 19s5.9 0 7.6-.4a2.8 2.8 0 0 0 2-2C22 15.2 22 12 22 12zM10 15.5v-7l6 3.5z"/></svg>
            </a>
          </div>
        </div>

        <div>
          <h4>Quick Links</h4>
          <ul>
            <li><a href="<?php echo $base; ?>academics.php">Academics</a></li>
            <li><a href="<?php echo $base; ?>admission.php">Admission</a></li>
            <li><a href="<?php echo $base; ?>services.php">Services</a></li>
            <li><a href="<?php echo $base; ?>faq.php">FAQ</a></li>
            <li><a href="<?php echo $base; ?>contact.php#feedback">Feedback</a></li>
          </ul>
        </div>

        <div>
          <h4>University</h4>
          <ul>
            <li><a href="<?php echo $base; ?>about.php">About Us</a></li>
            <li><a href="<?php echo $base; ?>faculties.php">Faculties</a></li>
            <li><a href="<?php echo $base; ?>research.php">Research</a></li>
          </ul>
        </div>

        <div>
          <h4>Contact</h4>
          <ul class="footer-contact">
            <li>Kotebe, Addis Ababa, Ethiopia</li>
            <li>info@kue.edu.et</li>
            <li>+251 11 833 2827</li>
          </ul>
        </div>

    </div>

    <div class="container footer-bottom">
      <p>&copy; 2026 KUE - Kotebe University of Education</p>
    </div>
  </footer>

  <!-- ============ HELP DESK CHATBOT ============ -->
  <div id="chatWindow" class="chat-window">
    <div class="chat-header">
      <span>KUE Help Desk <span class="chat-powered-by">Powered by Gemini</span></span>
      <div class="chat-header-actions">
        <button id="chatSettingsBtn" aria-label="Chat settings">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
        </button>
        <button id="chatCloseBtn" aria-label="Close chat">&times;</button>
      </div>
    </div>

    <div id="chatSettingsPanel" class="chat-settings-panel">
      <label for="chatApiKeyInput">Google Gemini API key</label>
      <input type="password" id="chatApiKeyInput" placeholder="AIza...">
      <p class="chat-settings-note">
        Stored only in your browser (localStorage) - never sent anywhere except directly to Google's Gemini API.
        Get a free key at <a href="https://aistudio.google.com/app/apikey" target="_blank" rel="noopener">aistudio.google.com</a>.
        Leave empty to use the built-in FAQ matcher instead of real AI.
      </p>
      <div class="chat-settings-buttons">
        <button type="button" id="chatSaveKeyBtn" class="btn">Save</button>
        <button type="button" id="chatClearKeyBtn" class="btn btn-outline-dark">Clear Key</button>
      </div>
      <p id="chatSettingsStatus"></p>
    </div>

    <div id="chatMessages" class="chat-messages"></div>
    <div class="chat-quick-replies" id="chatQuickReplies">
      <button type="button" data-question="How do I apply?">How do I apply?</button>
      <button type="button" data-question="What colleges do you have?">Our colleges</button>
      <button type="button" data-question="How do I contact the university?">Contact info</button>
      <button type="button" data-question="How do I log in?">Login help</button>
    </div>
    <form id="chatForm" class="chat-form">
      <input type="text" id="chatInput" placeholder="Ask a question..." autocomplete="off">
      <button type="submit" aria-label="Send">&rarr;</button>
    </form>
  </div>

  <button id="chatToggleBtn" aria-label="Open help desk chat">
    <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.4 8.4 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7a8.4 8.4 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.4 8.4 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
  </button>

  <button id="backToTop" aria-label="Back to top">&uarr;</button>

  <script src="<?php echo $base; ?>js/script.js"></script>
  <script src="<?php echo $base; ?>js/enhanced.js"></script>
</body>
</html>
