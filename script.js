/* =========================================================
   KUE WEBSITE SCRIPT - basic JS
   Read the comments - they explain what each part does.

   NOTE ON ACCOUNTS/LOGIN: real accounts, applications and news
   posts now live in the MySQL database and are handled by PHP
   (see login.php, register.php, admin/index.php, dashboard.php
   and news.php). This file only handles page-level UI behavior
   that doesn't need the server: the mobile menu, contact form
   feedback, search filters, counters, the chatbot, etc.
   ========================================================= */
/* -----------------------------------------------------
   1. MOBILE MENU TOGGLE
   We grab the hamburger button and the nav list by their
   IDs, then listen for a click on the button. Every time
   it's clicked, we toggle (add/remove) a class on each:
   "open" on the button (turns the bars into an X, see CSS)
   and "show" on the nav list (reveals the dropdown menu).
   ----------------------------------------------------- */
const menuButton = document.getElementById("menuButton");
const navLinks = document.getElementById("navLinks");

if (menuButton && navLinks) {
  menuButton.addEventListener("click", function () {
    menuButton.classList.toggle("open");
    navLinks.classList.toggle("show");
  });

  // Close the menu automatically after tapping a link, so it doesn't
  // stay open covering the page you just navigated to.
  navLinks.querySelectorAll("a").forEach(function (link) {
    link.addEventListener("click", function () {
      menuButton.classList.remove("open");
      navLinks.classList.remove("show");
    });
  });
}


/* -----------------------------------------------------
   2. CONTACT FORM
   The contact page has a form with id="contactForm".
   Normally submitting a form reloads the page and sends
   the data to a server. Since we don't have a server here,
   we stop that default behavior with e.preventDefault(),
   show a simple thank-you message instead, and clear the
   form fields.
   ----------------------------------------------------- */
const contactForm = document.getElementById("contactForm");

if (contactForm) {
  contactForm.addEventListener("submit", function (e) {
    e.preventDefault(); // stop the form from reloading the page

    const statusMessage = document.getElementById("formMessage");
    statusMessage.textContent = "Thanks! Your message has been sent.";

    contactForm.reset(); // clears all the input fields
  });
}


/* =========================================================
   9. SEARCH FILTER (faculties.html)
   As the user types in the search box, instantly hide any
   college card whose text doesn't match what they typed.
   ========================================================= */

const collegeSearch = document.getElementById("collegeSearch");

if (collegeSearch) {
  const collegeCards = document.querySelectorAll("#collegeCards .card");
  const noResults = document.getElementById("noResults");

  collegeSearch.addEventListener("input", function () {
    const searchTerm = collegeSearch.value.toLowerCase();
    let matchCount = 0;

    collegeCards.forEach(function (card) {
      const cardText = card.textContent.toLowerCase();

      if (cardText.includes(searchTerm)) {
        card.style.display = "block";
        matchCount++;
      } else {
        card.style.display = "none";
      }
    });

    noResults.style.display = matchCount === 0 ? "block" : "none";
  });
}


/* =========================================================
   10. ANIMATED STAT COUNTERS (homepage stats strip)
   Each <span class="stat-number" data-count="65" data-suffix="+">
   starts at 0 and counts up to its data-count value once it
   scrolls into view, instead of just appearing as static text.
   ========================================================= */

const statNumbers = document.querySelectorAll(".stat-number");

function animateCount(el) {
  const target = parseInt(el.dataset.count, 10);
  const suffix = el.dataset.suffix || "";
  const duration = 1200; // milliseconds
  const startTime = performance.now();

  function step(now) {
    const progress = Math.min((now - startTime) / duration, 1);
    const currentValue = Math.round(target * progress);
    el.textContent = currentValue.toLocaleString() + suffix;

    if (progress < 1) {
      requestAnimationFrame(step); // schedule the next frame
    }
  }

  requestAnimationFrame(step);
}

if (statNumbers.length > 0) {
  // IntersectionObserver tells us when an element scrolls into view,
  // so the counting animation only starts once someone can see it.
  const observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        animateCount(entry.target);
        observer.unobserve(entry.target); // only animate once
      }
    });
  }, { threshold: 0.5 });

  statNumbers.forEach(function (el) {
    observer.observe(el);
  });
}


/* =========================================================
   11. NEWSLETTER SIGNUP (footer strip on every page)
   ========================================================= */

const newsletterForm = document.getElementById("newsletterForm");

if (newsletterForm) {
  newsletterForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const email = document.getElementById("newsletterEmail").value;
    const message = document.getElementById("newsletterMessage");

    message.textContent = "Thanks! " + email + " has been subscribed.";
    newsletterForm.reset();
  });
}


/* =========================================================
   12. BACK TO TOP BUTTON
   Hidden until the page has been scrolled down a bit, then
   fades in. Clicking it smoothly scrolls back to the top.
   ========================================================= */

const backToTopButton = document.getElementById("backToTop");

if (backToTopButton) {
  window.addEventListener("scroll", function () {
    if (window.scrollY > 400) {
      backToTopButton.classList.add("visible");
    } else {
      backToTopButton.classList.remove("visible");
    }
  });

  backToTopButton.addEventListener("click", function () {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
}


/* =========================================================
   13. HELP DESK CHATBOT - now powered by the real Gemini API
   ========================================================= */

const chatToggleBtn = document.getElementById("chatToggleBtn");
const chatWindow = document.getElementById("chatWindow");

if (chatToggleBtn && chatWindow) {
  const chatCloseBtn = document.getElementById("chatCloseBtn");
  const chatMessages = document.getElementById("chatMessages");
  const chatForm = document.getElementById("chatForm");
  const chatInput = document.getElementById("chatInput");
  const chatQuickReplies = document.getElementById("chatQuickReplies");
  const chatSettingsBtn = document.getElementById("chatSettingsBtn");
  const chatSettingsPanel = document.getElementById("chatSettingsPanel");
  const chatApiKeyInput = document.getElementById("chatApiKeyInput");
  const chatSaveKeyBtn = document.getElementById("chatSaveKeyBtn");
  const chatClearKeyBtn = document.getElementById("chatClearKeyBtn");
  const chatSettingsStatus = document.getElementById("chatSettingsStatus");

  // --- API key storage (saved only in this browser) ---
  function getApiKey() {
    return localStorage.getItem("kueGeminiApiKey") || "";
  }

  // Keep a running conversation so the AI has context across turns,
  // the same way any chat app remembers what was said earlier.
  // Gemini expects each turn as { role: "user" | "model", parts: [{text: "..."}] }
  // - note it's "model" for the AI's turn, not "assistant" like some
  // other APIs use.
  let conversationHistory = [];

  // --- Fallback keyword-matching FAQ bot (used if no API key is set) ---
  const knowledgeBase = [
    { keywords: ["apply", "admission", "how do i apply", "join"], reply: "You can apply on our Admission page. You'll need to create an account (or log in) first, then fill out the application form with your program choice - go to admission.html to get started." },
    { keywords: ["college", "faculty", "faculties", "department", "program", "programs"], reply: "KUE has five colleges: Educational Sciences, Science & Mathematics Education, Languages Education, Business/Technology/Vocational Education, and Social Sciences & Law - plus the Science Shared Campus institute. See the Faculties page for details." },
    { keywords: ["contact", "phone", "email", "address", "reach", "call"], reply: "You can reach KUE at info@kue.edu.et, +251 11 833 2827, or visit us in Kotebe, Addis Ababa. There's a contact form and a live map on the Contact page." },
    { keywords: ["login", "log in", "sign in", "account", "password"], reply: "Click \"Login\" in the top menu. If you don't have an account yet, use \"Create one\" on that page to register - new accounts start as Students." },
    { keywords: ["register", "sign up", "create account"], reply: "Head to the Register page (linked from the Login page) to create a free Student account - full name, username, email and password." },
    { keywords: ["news", "event", "events", "announcement"], reply: "Check the News & Events page for the latest updates from the university." },
    { keywords: ["fee", "tuition", "cost", "price", "scholarship"], reply: "For up-to-date tuition and scholarship details, please contact the Registrar's Office directly - fees can vary by program and modality." },
    { keywords: ["library", "e-journal", "book", "research paper"], reply: "The Services page lists our library offices and how to access e-journals for research." },
    { keywords: ["dashboard", "application status", "my application"], reply: "Once logged in, click \"Dashboard\" in the menu. Students can see their submitted applications and status there." },
    { keywords: ["faq"], reply: "Check out the FAQ page for quick answers to common questions." },
    { keywords: ["map", "location", "where", "directions"], reply: "KUE's main campus is in Kotebe, Yeka Sub-City, Addis Ababa. There's a live map with directions on the Contact page." },
    { keywords: ["hello", "hi", "hey", "good morning", "good afternoon"], reply: "Hello! I'm the KUE Help Desk bot. Ask me about admissions, colleges, login, or contact info - or tap one of the quick questions below." },
    { keywords: ["thank", "thanks", "appreciate"], reply: "You're welcome! Let me know if there's anything else you'd like to know about KUE." }
  ];
  const fallbackReply = "I'm not totally sure about that one - try asking about admissions, colleges, login, or contact info, or reach out directly at info@kue.edu.et. (Tip: add a real Gemini API key in chat settings for full AI answers.)";

  function findKeywordReply(userMessage) {
    const lowerMessage = userMessage.toLowerCase();
    for (let i = 0; i < knowledgeBase.length; i++) {
      const matched = knowledgeBase[i].keywords.some(function (k) { return lowerMessage.includes(k); });
      if (matched) return knowledgeBase[i].reply;
    }
    return fallbackReply;
  }

  // --- Real AI call to Google's Gemini API, directly from the browser ---
  // Gemini's standard generateContent endpoint supports direct browser
  // calls with just an API key - no special access header needed. The
  // key is passed as a URL query parameter, which is the simplest and
  // most broadly-compatible way to authenticate from a plain fetch()
  // call. Same tradeoff as any client-side API key: it lives in THIS
  // browser's storage and is visible to anyone using dev tools on THIS
  // device - fine for your own key on your own machine, but not
  // something to ship to the public without a real backend proxy in
  // front of it.
  async function askGemini(userMessage) {
    const apiKey = getApiKey();

    const systemPrompt =
      "You are the KUE Help Desk assistant for Kotebe University of Education (KUE), " +
      "a real university in Addis Ababa, Ethiopia, founded in 1959, specializing in " +
      "teacher education. Facts you can rely on: five colleges (Educational Sciences; " +
      "Science & Mathematics Education; Languages Education; Business, Technology & " +
      "Vocational Education; Social Sciences & Law) plus the Science Shared Campus " +
      "institute for gifted secondary students. Contact: info@kue.edu.et, " +
      "+251 11 833 2827, campus in Kotebe, Yeka Sub-City, Addis Ababa (see the " +
      "live map on the Contact page). The site has pages for Academics, Faculties, " +
      "Research, Admission, Student Life, News, Services, FAQ, Feedback, Login, " +
      "Register and Dashboard. Keep answers short (2-4 sentences) and friendly, " +
      "suited to a small chat widget. If you don't know a specific fact (like exact " +
      "tuition fees or deadlines), say so honestly and suggest contacting the " +
      "Registrar's Office rather than guessing.";

    conversationHistory.push({ role: "user", parts: [{ text: userMessage }] });

    const model = "gemini-3.5-flash";
    const url = "https://generativelanguage.googleapis.com/v1beta/models/" + model + ":generateContent?key=" + encodeURIComponent(apiKey);

    const response = await fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        contents: conversationHistory,
        systemInstruction: { parts: [{ text: systemPrompt }] },
        generationConfig: { maxOutputTokens: 300 }
      })
    });

    if (!response.ok) {
      const errorBody = await response.json().catch(function () { return {}; });
      const errorMessage = (errorBody.error && errorBody.error.message) || ("HTTP " + response.status);
      throw new Error(errorMessage);
    }

    const data = await response.json();
    const replyText = data.candidates[0].content.parts
      .map(function (part) { return part.text; })
      .join("\n");

    conversationHistory.push({ role: "model", parts: [{ text: replyText }] });
    return replyText;
  }

  // --- Chat UI plumbing ---

  function addMessage(text, sender) {
    const bubble = document.createElement("div");
    bubble.className = "chat-bubble " + sender; // "bot" or "user"
    bubble.textContent = text;
    chatMessages.appendChild(bubble);
    chatMessages.scrollTop = chatMessages.scrollHeight;
    return bubble;
  }

  // Shows animated "..." dots while we wait for a reply, then removes
  // itself once the real message is ready to replace it
  function addTypingIndicator() {
    const typing = document.createElement("div");
    typing.className = "chat-typing";
    typing.innerHTML = "<span></span><span></span><span></span>";
    chatMessages.appendChild(typing);
    chatMessages.scrollTop = chatMessages.scrollHeight;
    return typing;
  }

  async function sendUserMessage(text) {
    if (text.trim() === "") return;

    addMessage(text, "user");
    const typingIndicator = addTypingIndicator();

    const apiKey = getApiKey();

    if (!apiKey) {
      // No key set - use the instant local keyword matcher
      window.setTimeout(function () {
        typingIndicator.remove();
        addMessage(findKeywordReply(text), "bot");
      }, 350);
      return;
    }

    // A real key is set - call the actual Gemini API
    try {
      const reply = await askGemini(text);
      typingIndicator.remove();
      addMessage(reply, "bot");
    } catch (err) {
      typingIndicator.remove();
      addMessage("Sorry, I couldn't reach the AI service (" + err.message + "). Falling back to quick answers: " + findKeywordReply(text), "bot");
    }
  }

  // Open Gemini's own web app in a new tab instead of the in-page widget
  chatToggleBtn.addEventListener("click", function () {
    window.open("https://gemini.google.com/app", "_blank", "noopener");
  });

  chatCloseBtn.addEventListener("click", function () {
    chatWindow.classList.remove("open");
  });

  // Handle the text input form
  chatForm.addEventListener("submit", function (e) {
    e.preventDefault();
    sendUserMessage(chatInput.value);
    chatInput.value = "";
  });

  // Handle the quick-reply buttons
  chatQuickReplies.addEventListener("click", function (e) {
    if (e.target.tagName === "BUTTON") {
      sendUserMessage(e.target.dataset.question);
    }
  });

  // --- Settings panel: entering/saving/clearing the API key ---

  chatSettingsBtn.addEventListener("click", function () {
    chatApiKeyInput.value = getApiKey();
    chatSettingsPanel.classList.toggle("open");
  });

  chatSaveKeyBtn.addEventListener("click", function () {
    const key = chatApiKeyInput.value.trim();
    if (key) {
      localStorage.setItem("kueGeminiApiKey", key);
      conversationHistory = []; // start fresh once real AI is enabled
      chatSettingsStatus.textContent = "Saved! Real AI answers are now on.";
    } else {
      chatSettingsStatus.textContent = "Enter a key first, or use Clear Key to remove one.";
    }
  });

  chatClearKeyBtn.addEventListener("click", function () {
    localStorage.removeItem("kueGeminiApiKey");
    chatApiKeyInput.value = "";
    conversationHistory = [];
    chatSettingsStatus.textContent = "Key cleared - back to quick-answer mode.";
  });

  // Greet the visitor as soon as the chat opens for the first time
  addMessage("Hi! I'm the KUE Help Desk bot, powered by Google's Gemini API. Add your API key (gear icon) to get real AI answers - without one, I can only answer a few basic questions.", "bot");
}



/* =========================================================
   14. PHOTO GALLERY LIGHTBOX (student-life.html)
   Clicking any thumbnail in #galleryGrid opens a full-screen
   popup (#lightbox) showing that same image larger, with its
   caption. Closing works via the X button, clicking the dark
   background, or pressing the Escape key.
   ========================================================= */

const galleryGrid = document.getElementById("galleryGrid");
const lightbox = document.getElementById("lightbox");

if (galleryGrid && lightbox) {
  const lightboxImage = document.getElementById("lightboxImage");
  const lightboxCaption = document.getElementById("lightboxCaption");
  const lightboxClose = document.getElementById("lightboxClose");

  function openLightbox(imgEl) {
    lightboxImage.src = imgEl.src;
    lightboxImage.alt = imgEl.alt;
    lightboxCaption.textContent = imgEl.dataset.caption || imgEl.alt;
    lightbox.classList.add("open");
  }

  function closeLightbox() {
    lightbox.classList.remove("open");
  }

  // Event delegation: one click listener on the grid catches clicks
  // on any thumbnail inside it, current or future
  galleryGrid.addEventListener("click", function (e) {
    if (e.target.tagName === "IMG") {
      openLightbox(e.target);
    }
  });

  lightboxClose.addEventListener("click", closeLightbox);

  // Clicking the dark background (but not the image itself) also closes it
  lightbox.addEventListener("click", function (e) {
    if (e.target === lightbox) {
      closeLightbox();
    }
  });

  // Pressing Escape closes it too
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      closeLightbox();
    }
  });
}


/* =========================================================
   15. FAQ ACCORDION + SEARCH (faq.html)
   ========================================================= */

const faqList = document.getElementById("faqList");

if (faqList) {
  const faqItems = document.querySelectorAll(".faq-item");
  const faqSearch = document.getElementById("faqSearch");
  const faqNoResults = document.getElementById("faqNoResults");

  // Clicking a question toggles that item's "open" class. Other items
  // are left alone, so more than one can be open at once.
  faqItems.forEach(function (item) {
    const questionButton = item.querySelector(".faq-question");
    questionButton.addEventListener("click", function () {
      item.classList.toggle("open");
    });
  });

  if (faqSearch) {
    faqSearch.addEventListener("input", function () {
      const searchTerm = faqSearch.value.toLowerCase();
      let matchCount = 0;

      faqItems.forEach(function (item) {
        const itemText = item.textContent.toLowerCase();
        if (itemText.includes(searchTerm)) {
          item.style.display = "block";
          matchCount++;
        } else {
          item.style.display = "none";
        }
      });

      faqNoResults.style.display = matchCount === 0 ? "block" : "none";
    });
  }
}


/* =========================================================
   16. STAR RATING + FEEDBACK WALL (feedback.html)
   Same localStorage pattern as news/applications: everything
   submitted here is saved as JSON text under "kueFeedback" and
   shown back to anyone who visits this page in this browser.
   ========================================================= */

const starRating = document.getElementById("starRating");

if (starRating) {
  const stars = document.querySelectorAll("#starRating .star");
  const feedbackForm = document.getElementById("feedbackForm");
  const feedbackList = document.getElementById("feedbackList");
  const feedbackAverage = document.getElementById("feedbackAverage");
  let selectedRating = 0;

  // Highlight every star up to and including the one clicked
  function highlightStars(rating) {
    stars.forEach(function (star) {
      const starValue = Number(star.dataset.value);
      star.classList.toggle("selected", starValue <= rating);
    });
  }

  stars.forEach(function (star) {
    star.addEventListener("click", function () {
      selectedRating = Number(star.dataset.value);
      highlightStars(selectedRating);
    });
  });

  function loadFeedback() {
    const saved = localStorage.getItem("kueFeedback");
    if (saved) return JSON.parse(saved);
    // A couple of starting examples, just like the news page does
    return [
      { name: "Selam G.", rating: 5, comment: "Really clear information about the admission process.", date: "7/1/2026" },
      { name: "Yonas K.", rating: 4, comment: "Wish the tuition fee page had more specifics, but overall great site.", date: "6/20/2026" }
    ];
  }

  function saveFeedback(list) {
    localStorage.setItem("kueFeedback", JSON.stringify(list));
  }

  function renderFeedback(list) {
    feedbackList.innerHTML = "";

    list.forEach(function (item) {
      const card = document.createElement("div");
      card.className = "feedback-card";
      card.innerHTML =
        '<div class="feedback-card-header">' +
          '<span class="feedback-card-name">' + item.name + '</span>' +
          '<span class="feedback-card-date">' + item.date + '</span>' +
        '</div>' +
        '<div class="feedback-card-stars">' + "\u2605".repeat(item.rating) + "\u2606".repeat(5 - item.rating) + '</div>' +
        '<p>' + item.comment + '</p>';
      feedbackList.appendChild(card);
    });

    if (list.length > 0) {
      const total = list.reduce(function (sum, item) { return sum + item.rating; }, 0);
      const average = (total / list.length).toFixed(1);
      feedbackAverage.textContent = "Average rating: " + average + " / 5 (" + list.length + " reviews)";
    } else {
      feedbackAverage.textContent = "No feedback yet - be the first!";
    }
  }

  let currentFeedback = loadFeedback();
  renderFeedback(currentFeedback);

  feedbackForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const ratingError = document.getElementById("ratingError");
    const feedbackMessage = document.getElementById("feedbackMessage");

    if (selectedRating === 0) {
      ratingError.textContent = "Please pick a star rating.";
      return;
    }
    ratingError.textContent = "";

    const newEntry = {
      name: document.getElementById("feedbackName").value.trim(),
      rating: selectedRating,
      comment: document.getElementById("feedbackComment").value.trim(),
      date: new Date().toLocaleDateString()
    };

    currentFeedback.unshift(newEntry);
    saveFeedback(currentFeedback);
    renderFeedback(currentFeedback);

    feedbackMessage.style.color = "green";
    feedbackMessage.textContent = "Thanks for your feedback!";
    feedbackForm.reset();
    selectedRating = 0;
    highlightStars(0);
  });
}
