<?php
/**
 * Auth helpers: start the session, read the logged-in user, and
 * gate pages by role. Include this at the very top of any page
 * BEFORE any HTML is echoed (session_start must run first).
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config.php';

/** Returns the logged-in user's session data, or null if nobody is logged in. */
function current_user() {
    return $_SESSION['kue_user'] ?? null;
}

/** Redirects to login.php if nobody is logged in. */
function require_login() {
    if (!current_user()) {
        header("Location: login.php");
        exit;
    }
}

/**
 * Redirects away if the logged-in user's role isn't in $roles.
 * Always call require_login() logic implicitly first.
 * @param string|array $roles e.g. 'admin' or ['staff','admin']
 */
function require_role($roles) {
    require_login();
    $roles = (array) $roles;
    if (!in_array(current_user()['role'], $roles, true)) {
        header("Location: dashboard.php?error=forbidden");
        exit;
    }
}

/** Small helper to safely print user-supplied text back into HTML. */
function h($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
