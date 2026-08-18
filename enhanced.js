/* =========================================================
   KUE ENHANCED.JS
   Loaded AFTER js/script.js on every page. Everything here is
   additive: it never redefines a function or re-grabs an ID
   already owned by script.js. Instead it layers UX on top -
   theme, toasts, drawer polish, multi-step form navigation,
   live directory filtering, the media hub tabs/lightbox, and
   a simulated feedback status tracker.
   ========================================================= */

/* ---------------------------------------------------------
   0. TOAST NOTIFICATIONS (used by everything below)
   --------------------------------------------------------- */
(function () {
  let stack = document.getElementById("toastStack");
  if (!stack) {
    stack = document.createElement("div");
    stack.id = "toastStack";
    document.body.appendChild(stack);
  }

  window.showToast = function (message, type) {
    type = type || "info";
    const toast = document.createElement("div");
    toast.className = "toast " + type;

    const icon = document.createElement("span");
    icon.className = "toast-icon";
    icon.textContent = type === "success" ? "\u2713" : type === "error" ? "!" : "i";

    const text = document.createElement("span");
    text.textContent = message;

    const close = document.createElement("button");
    close.className = "toast-close";
    close.setAttribute("aria-label", "Dismiss");
    close.innerHTML = "&times;";

    toast.appendChild(icon);
    toast.appendChild(text);
    toast.appendChild(close);
    stack.appendChild(toast);

    requestAnimationFrame(function () { toast.classList.add("show"); });

    function remove() {
      toast.classList.remove("show");
      window.setTimeout(function () { toast.remove(); }, 300);
    }
    close.addEventListener("click", remove);
    window.setTimeout(remove, 5000);
  };
})();

/* ---------------------------------------------------------
   1. THEME TOGGLE (persisted via localStorage "kueTheme")
   The very first paint is handled by a tiny inline script in
   <head> (see build_expanded_site.py) so there's no flash of
   the wrong theme; this just wires up the button + storage.
   --------------------------------------------------------- */
(function () {
  const root = document.documentElement;
  const toggle = document.getElementById("themeToggle");
  if (!toggle) return;

  function apply(theme) {
    if (theme === "dark") {
      root.setAttribute("data-theme", "dark");
    } else {
      root.removeAttribute("data-theme");
    }
  }

  toggle.addEventListener("click", function () {
    const isDark = root.getAttribute("data-theme") === "dark";
    const next = isDark ? "light" : "dark";
    apply(next);
    try { localStorage.setItem("kueTheme", next); } catch (e) { /* ignore */ }
  });
})();

/* ---------------------------------------------------------
   2. MOBILE DRAWER OVERLAY
   script.js already toggles ".show" on #navLinks and ".open"
   on #menuButton. This adds a dimmed backdrop that appears in
   sync, and closes the drawer when tapped.
   --------------------------------------------------------- */
(function () {
  const menuButton = document.getElementById("menuButton");
  const navLinks = document.getElementById("navLinks");
  let overlay = document.getElementById("navOverlay");

  if (!menuButton || !navLinks) return;

  if (!overlay) {
    overlay = document.createElement("div");
    overlay.id = "navOverlay";
    overlay.className = "nav-overlay";
    document.body.appendChild(overlay);
  }

  function sync() {
    overlay.classList.toggle("show", navLinks.classList.contains("show"));
  }

  menuButton.addEventListener("click", function () {
    window.setTimeout(sync, 0);
  });

  overlay.addEventListener("click", function () {
    menuButton.classList.remove("open");
    navLinks.classList.remove("show");
    overlay.classList.remove("show");
  });
})();

/* ---------------------------------------------------------
   3. GENERIC DRAFT-SAVING HELPER
   Small localStorage wrapper shared by the admission wizard.
   --------------------------------------------------------- */
function kueSaveDraft(key, data) {
  try { localStorage.setItem(key, JSON.stringify(data)); } catch (e) { /* storage full/unavailable */ }
}
function kueLoadDraft(key) {
  try {
    const raw = localStorage.getItem(key);
    return raw ? JSON.parse(raw) : null;
  } catch (e) { return null; }
}
function kueClearDraft(key) {
  try { localStorage.removeItem(key); } catch (e) { /* ignore */ }
}

/* ---------------------------------------------------------
   4. MULTI-STEP ADMISSION WIZARD (admission.html)
   Wraps the EXISTING #admissionForm (still owned/validated by
   script.js on submit) with step navigation, a progress bar,
   live per-field validation styling, a document dropzone, and
   draft autosave of every field script.js doesn't already
   manage itself.
   --------------------------------------------------------- */
(function () {
  const wizard = document.getElementById("admissionWizard");
  if (!wizard) return;

  const DRAFT_KEY = "kueAdmissionDraft";
  const steps = Array.prototype.slice.call(wizard.querySelectorAll(".form-step"));
  const progressItems = Array.prototype.slice.call(document.querySelectorAll("#admissionProgress li"));
  let currentStep = 0;

  function showStep(index) {
    steps.forEach(function (step, i) { step.classList.toggle("active", i === index); });
    progressItems.forEach(function (li, i) {
      li.classList.toggle("active", i === index);
      li.classList.toggle("done", i < index);
    });
    currentStep = index;
    window.scrollTo({ top: wizard.getBoundingClientRect().top + window.scrollY - 110, behavior: "smooth" });
  }

  function validateField(field) {
    if (!field) return true;
    let ok = true;
    if (field.hasAttribute("data-required") && field.value.trim() === "") ok = false;
    if (ok && field.type === "email" && field.value.trim() !== "") {
      ok = /^\S+@\S+\.\S+$/.test(field.value.trim());
    }
    if (ok && field.dataset.pattern) {
      ok = new RegExp(field.dataset.pattern).test(field.value.trim());
    }
    field.classList.toggle("valid", ok && field.value.trim() !== "");
    field.classList.toggle("invalid", !ok);
    return ok;
  }

  function validateStep(index) {
    const fields = steps[index].querySelectorAll("input[data-required], select[data-required], textarea[data-required]");
    let allValid = true;
    fields.forEach(function (f) { if (!validateField(f)) allValid = false; });
    return allValid;
  }

  // Live validation as the visitor types/selects/blurs
  wizard.querySelectorAll("input, select, textarea").forEach(function (field) {
    field.addEventListener("input", function () { validateField(field); saveDraft(); });
    field.addEventListener("blur", function () { validateField(field); });
    field.addEventListener("change", function () { validateField(field); saveDraft(); });
  });

  // ---- Draft autosave / restore (metadata only - never file bytes) ----
  function currentFieldMap() {
    const map = {};
    wizard.querySelectorAll("input[id], select[id], textarea[id]").forEach(function (f) {
      if (f.type === "file") return;
      map[f.id] = f.value;
    });
    return map;
  }

  function saveDraft() {
    kueSaveDraft(DRAFT_KEY, { fields: currentFieldMap(), documents: uploadedDocs.map(function (d) { return { name: d.name, size: d.size, type: d.category }; }), step: currentStep });
  }

  function restoreDraft() {
    const draft = kueLoadDraft(DRAFT_KEY);
    if (!draft) return;
    const banner = document.getElementById("draftBanner");
    if (banner) banner.classList.remove("hidden");

    document.getElementById("draftRestoreBtn").addEventListener("click", function () {
      Object.keys(draft.fields || {}).forEach(function (id) {
        const el = document.getElementById(id);
        if (el) { el.value = draft.fields[id]; validateField(el); }
      });
      if (Array.isArray(draft.documents)) {
        draft.documents.forEach(function (d) { addFileRow(d.name, d.size, true, d.type); });
      }
      showStep(draft.step || 0);
      banner.classList.add("hidden");
      window.showToast("Draft restored - pick up right where you left off.", "success");
    });

    document.getElementById("draftDiscardBtn").addEventListener("click", function () {
      kueClearDraft(DRAFT_KEY);
      banner.classList.add("hidden");
      window.showToast("Draft cleared.", "info");
    });
  }

  // ---- Step navigation ----
  wizard.querySelectorAll("[data-next]").forEach(function (btn) {
    btn.addEventListener("click", function () {
      if (!validateStep(currentStep)) {
        window.showToast("Please complete the highlighted fields before continuing.", "error");
        return;
      }
      if (currentStep < steps.length - 1) {
        if (currentStep === steps.length - 2) renderReview();
        showStep(currentStep + 1);
      }
    });
  });

  wizard.querySelectorAll("[data-prev]").forEach(function (btn) {
    btn.addEventListener("click", function () {
      if (currentStep > 0) showStep(currentStep - 1);
    });
  });

  // ---- Document dropzone ----
  const dropzone = document.getElementById("docDropzone");
  const fileInput = document.getElementById("docFileInput");
  const fileListEl = document.getElementById("docFileList");
  const requiredChips = Array.prototype.slice.call(document.querySelectorAll(".doc-chip"));
  const uploadedDocs = [];

  function refreshRequiredChips() {
    requiredChips.forEach(function (chip) {
      const label = chip.dataset.doc;
      const satisfied = uploadedDocs.some(function (d) { return d.category === label; });
      chip.classList.toggle("satisfied", satisfied);
    });
  }

  function addFileRow(name, size, fromDraft, category) {
    category = category || guessCategory(name);
    uploadedDocs.push({ name: name, size: size, category: category });

    const li = document.createElement("li");
    const meta = document.createElement("div");
    meta.className = "file-meta";
    const nameEl = document.createElement("span");
    nameEl.className = "file-name";
    nameEl.textContent = name;
    const sizeEl = document.createElement("span");
    sizeEl.className = "file-size";
    sizeEl.textContent = (fromDraft ? "restored draft \u00b7 " : "") + formatSize(size);
    meta.appendChild(nameEl);
    meta.appendChild(sizeEl);

    const progressWrap = document.createElement("div");
    progressWrap.className = "file-progress";
    const bar = document.createElement("span");
    progressWrap.appendChild(bar);
    meta.appendChild(progressWrap);

    const remove = document.createElement("button");
    remove.type = "button";
    remove.className = "file-remove";
    remove.setAttribute("aria-label", "Remove file");
    remove.innerHTML = "&times;";
    remove.addEventListener("click", function () {
      const idx = uploadedDocs.findIndex(function (d) { return d.name === name && d.size === size; });
      if (idx > -1) uploadedDocs.splice(idx, 1);
      li.remove();
      refreshRequiredChips();
      saveDraft();
    });

    li.appendChild(meta);
    li.appendChild(remove);
    fileListEl.appendChild(li);

    if (!fromDraft) {
      window.requestAnimationFrame(function () { bar.style.width = "100%"; });
    } else {
      bar.style.width = "100%";
    }
    refreshRequiredChips();
  }

  function guessCategory(name) {
    const lower = name.toLowerCase();
    if (lower.includes("transcript") || lower.includes("grade")) return "Transcript";
    if (lower.includes("id") || lower.includes("passport")) return "ID / Passport";
    if (lower.includes("photo") || /\.(png|jpe?g)$/.test(lower)) return "Passport Photo";
    return "Other Document";
  }

  function formatSize(bytes) {
    if (bytes < 1024) return bytes + " B";
    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + " KB";
    return (bytes / (1024 * 1024)).toFixed(1) + " MB";
  }

  function handleFiles(fileArray) {
    Array.prototype.forEach.call(fileArray, function (file) {
      addFileRow(file.name, file.size, false);
    });
    saveDraft();
    if (fileArray.length) window.showToast(fileArray.length + " document(s) added.", "success");
  }

  if (dropzone && fileInput) {
    dropzone.addEventListener("click", function () { fileInput.click(); });
    fileInput.addEventListener("change", function () { handleFiles(fileInput.files); fileInput.value = ""; });

    ["dragenter", "dragover"].forEach(function (evt) {
      dropzone.addEventListener(evt, function (e) { e.preventDefault(); dropzone.classList.add("dragover"); });
    });
    ["dragleave", "drop"].forEach(function (evt) {
      dropzone.addEventListener(evt, function (e) { e.preventDefault(); dropzone.classList.remove("dragover"); });
    });
    dropzone.addEventListener("drop", function (e) {
      if (e.dataTransfer && e.dataTransfer.files) handleFiles(e.dataTransfer.files);
    });
  }

  // ---- Review step ----
  function renderReview() {
    const reviewEl = document.getElementById("reviewSummary");
    if (!reviewEl) return;
    const fieldsToShow = [
      ["appName", "Full name"], ["appEmail", "Email"], ["appPhone", "Phone"],
      ["appDob", "Date of birth"], ["appDegreeLevel", "Degree level"], ["appProgram", "Program"],
      ["appIntake", "Intake term"]
    ];
    let html = "";
    fieldsToShow.forEach(function (pair) {
      const el = document.getElementById(pair[0]);
      const val = el ? el.value : "";
      if (val) html += "<dt>" + pair[1] + "</dt><dd>" + val + "</dd>";
    });
    reviewEl.innerHTML = html || "<dt>Details</dt><dd>Nothing entered yet</dd>";

    const docsEl = document.getElementById("reviewDocs");
    if (docsEl) {
      docsEl.textContent = uploadedDocs.length
        ? uploadedDocs.length + " document(s) attached: " + uploadedDocs.map(function (d) { return d.name; }).join(", ")
        : "No documents attached yet.";
    }
  }

  // Once script.js successfully saves the application, clear the draft
  // and toast a success message (script.js already writes the inline
  // #applicationMessage text; this just adds the floating toast + cleanup).
  const admissionForm = document.getElementById("admissionForm");
  if (admissionForm) {
    admissionForm.addEventListener("submit", function () {
      window.setTimeout(function () {
        const msg = document.getElementById("applicationMessage");
        if (msg && msg.style.color === "green") {
          kueClearDraft(DRAFT_KEY);
          uploadedDocs.length = 0;
          fileListEl.innerHTML = "";
          refreshRequiredChips();
          window.showToast("Application submitted successfully!", "success");
          showStep(0);
        } else if (msg && msg.textContent) {
          window.showToast(msg.textContent, "error");
        }
      }, 0);
    });
  }

  restoreDraft();
  showStep(0);
})();

/* ---------------------------------------------------------
   5. COURSE / FACULTY DIRECTORY LIVE FILTER (faculties.html)
   Combines free-text keyword search (shares #collegeSearch
   with script.js's own simpler matcher - harmless, this just
   runs afterward and has final say) with department + degree
   level dropdowns, entirely via data-* attributes on cards.
   --------------------------------------------------------- */
(function () {
  const grid = document.getElementById("collegeCards");
  if (!grid || !document.getElementById("directoryLevel")) return;

  const searchInput = document.getElementById("collegeSearch");
  const deptSelect = document.getElementById("directoryDept");
  const levelSelect = document.getElementById("directoryLevel");
  const resultCount = document.getElementById("directoryCount");
  const clearBtn = document.getElementById("directoryClear");
  const noResults = document.getElementById("noResults");
  const cards = Array.prototype.slice.call(grid.querySelectorAll(".card"));

  function applyFilters() {
    const keyword = (searchInput.value || "").toLowerCase().trim();
    const dept = deptSelect.value;
    const level = levelSelect.value;
    let visible = 0;

    cards.forEach(function (card) {
      const text = card.textContent.toLowerCase();
      const matchesKeyword = keyword === "" || text.includes(keyword);
      const matchesDept = dept === "" || card.dataset.department === dept;
      const matchesLevel = level === "" || card.dataset.level === level;
      const show = matchesKeyword && matchesDept && matchesLevel;
      card.style.display = show ? "" : "none";
      if (show) visible++;
    });

    if (resultCount) resultCount.textContent = visible + (visible === 1 ? " program found" : " programs found");
    if (noResults) noResults.style.display = visible === 0 ? "block" : "none";
  }

  [searchInput, deptSelect, levelSelect].forEach(function (el) {
    if (el) el.addEventListener("input", applyFilters);
    if (el) el.addEventListener("change", applyFilters);
  });

  if (clearBtn) {
    clearBtn.addEventListener("click", function () {
      searchInput.value = "";
      deptSelect.value = "";
      levelSelect.value = "";
      applyFilters();
    });
  }

  applyFilters();
})();

/* ---------------------------------------------------------
   6. VIRTUAL CAMPUS TOUR & MEDIA HUB (student-life.html)
   Filter tabs over the existing #galleryGrid (still uses the
   same <img> elements script.js's lightbox already opens) plus
   a dedicated video lightbox for the campus tour clip.
   --------------------------------------------------------- */
(function () {
  const tabs = document.getElementById("hubTabs");
  if (!tabs) return;

  const figures = Array.prototype.slice.call(document.querySelectorAll("#galleryGrid figure"));
  const videoSection = document.getElementById("hubVideoPane");
  const gallerySection = document.getElementById("hubGalleryPane");

  tabs.querySelectorAll(".hub-tab").forEach(function (tab) {
    tab.addEventListener("click", function () {
      tabs.querySelectorAll(".hub-tab").forEach(function (t) { t.classList.remove("active"); });
      tab.classList.add("active");
      const category = tab.dataset.category;

      if (category === "Video") {
        gallerySection.classList.add("hidden");
        videoSection.classList.remove("hidden");
        return;
      }
      videoSection.classList.add("hidden");
      gallerySection.classList.remove("hidden");

      figures.forEach(function (fig) {
        const show = category === "All" || fig.dataset.category === category;
        fig.classList.toggle("hidden", !show);
      });
    });
  });

  // Dedicated lightbox for the hero video tile
  const videoTile = document.getElementById("videoTile");
  const videoLightbox = document.getElementById("videoLightbox");
  if (videoTile && videoLightbox) {
    const player = videoLightbox.querySelector("video");
    videoTile.addEventListener("click", function () {
      videoLightbox.classList.add("open");
      player.play().catch(function () { /* autoplay-blocked, fine */ });
    });
    videoLightbox.querySelector(".video-lightbox-close").addEventListener("click", function () {
      videoLightbox.classList.remove("open");
      player.pause();
    });
    videoLightbox.addEventListener("click", function (e) {
      if (e.target === videoLightbox) {
        videoLightbox.classList.remove("open");
        player.pause();
      }
    });
  }
})();

/* ---------------------------------------------------------
   7. CONTACT & FEEDBACK PORTAL (contact.html)
   Tab switching between Contact / Feedback / Track Status,
   plus a simulated live status tracker keyed off a generated
   ticket ID. Feedback submission itself is still fully owned
   by script.js's #feedbackForm handler - this only listens
   alongside it to mint a ticket once script.js accepts it.
   --------------------------------------------------------- */
(function () {
  const tabs = document.getElementById("portalTabs");
  if (!tabs) return;

  const panes = Array.prototype.slice.call(document.querySelectorAll(".portal-pane"));

  function activate(name) {
    tabs.querySelectorAll(".portal-tab").forEach(function (t) {
      t.classList.toggle("active", t.dataset.pane === name);
    });
    panes.forEach(function (p) { p.classList.toggle("active", p.id === "pane-" + name); });
  }

  tabs.querySelectorAll(".portal-tab").forEach(function (tab) {
    tab.addEventListener("click", function () { activate(tab.dataset.pane); });
  });

  // Deep-link support: contact.html#feedback / #track opens that tab
  const hash = (window.location.hash || "").replace("#", "");
  if (hash === "feedback" || hash === "track") activate(hash);

  // ---- Ticket generation on successful feedback submit ----
  const TICKETS_KEY = "kueFeedbackTickets";
  function loadTickets() { return kueLoadDraft(TICKETS_KEY) || []; }
  function saveTickets(list) { kueSaveDraft(TICKETS_KEY, list); }

  const feedbackForm = document.getElementById("feedbackForm");
  if (feedbackForm) {
    feedbackForm.addEventListener("submit", function () {
      // Runs after script.js's own listener resets the form on success;
      // read the name field before it clears via a microtask delay.
      const nameBefore = document.getElementById("feedbackName").value.trim();
      window.setTimeout(function () {
        const msg = document.getElementById("feedbackMessage");
        if (!msg || msg.style.color !== "green") return;

        const ticketId = "KUE-FB-" + Math.floor(1000 + Math.random() * 9000);
        const tickets = loadTickets();
        tickets.unshift({ id: ticketId, name: nameBefore || "Anonymous", submitted: Date.now() });
        saveTickets(tickets);

        const idBox = document.getElementById("newTicketId");
        if (idBox) {
          idBox.textContent = ticketId;
          document.getElementById("newTicketBanner").classList.remove("hidden");
        }
        window.showToast("Feedback received! Your tracking ID is " + ticketId + ".", "success");
      }, 0);
    });
  }

  // ---- Simulated live status lookup ----
  const trackForm = document.getElementById("trackForm");
  if (trackForm) {
    trackForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const input = document.getElementById("trackInput");
      const id = input.value.trim().toUpperCase();
      const tickets = loadTickets();
      const ticket = tickets.find(function (t) { return t.id.toUpperCase() === id; });
      const resultEl = document.getElementById("trackResult");

      if (!ticket) {
        resultEl.innerHTML = "<p class=\"field-error\">No ticket found with that ID. Double check it, or submit new feedback to get one.</p>";
        return;
      }

      const elapsedMinutes = (Date.now() - ticket.submitted) / 60000;
      let stage = 0; // 0 = received, 1 = in review, 2 = resolved
      if (elapsedMinutes >= 3) stage = 2;
      else if (elapsedMinutes >= 1) stage = 1;

      const stages = [
        { label: "Received", time: new Date(ticket.submitted).toLocaleString() },
        { label: "In Review by Student Affairs", time: stage >= 1 ? "In progress" : "Pending" },
        { label: "Resolved", time: stage >= 2 ? "Completed" : "Pending" }
      ];

      let html = "<div class=\"tracker-ticket-id\">" + ticket.id + "</div>";
      html += "<ul class=\"tracker-timeline\">";
      stages.forEach(function (s, i) {
        const cls = i < stage ? "done" : i === stage ? "current" : "";
        html += "<li class=\"" + cls + "\"><span class=\"tt-label\">" + s.label + "</span><span class=\"tt-time\">" + s.time + "</span></li>";
      });
      html += "</ul>";
      resultEl.innerHTML = html;
    });
  }
})();
