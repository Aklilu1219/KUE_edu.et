<?php
/**
 * Shared header for every page on the site. Expects (all optional):
 *   $pageTitle    browser tab title
 *   $pageHeading  the big H1 shown in the page banner
 *   $bannerImage  path (relative to site root) to the banner background image
 *   $activeNav    one of: home, about, academics, admission, faculties,
 *                 research, student-life, news, services, contact
 *   $noBanner     set true to skip the banner entirely (used by index.php,
 *                 which has its own hero/video section instead)
 *   $inAdmin      set true when included from inside admin/ (adjusts paths)
 */
$user        = current_user();
$pageTitle   = $pageTitle   ?? 'KUE';
$pageHeading = $pageHeading ?? '';
$bannerImage = $bannerImage ?? 'images/campus.jpg';
$activeNav   = $activeNav   ?? '';
$noBanner    = $noBanner    ?? false;
$base        = isset($inAdmin) ? '../' : '';

function nav_active($key, $activeNav) {
    return $key === $activeNav ? ' class="active"' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo h($pageTitle); ?> - KUE</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="<?php echo $base; ?>css/style.css">
  <link rel="stylesheet" href="<?php echo $base; ?>css/enhanced.css">
  <script>
    (function () {
      try {
        var saved = localStorage.getItem("kueTheme");
        if (saved === "dark") document.documentElement.setAttribute("data-theme", "dark");
      } catch (e) {}
    })();
  </script>
</head>
<body>
  <header id="siteHeader">
    <div class="container navbar">
      <a href="<?php echo $base; ?>index.php" class="logo">
        <img src="<?php echo $base; ?>images/logo.png" alt="KUE logo">
        <span>KUE</span>
      </a>
      <button class="menu-toggle" id="menuButton" aria-label="Toggle menu">
        <span></span><span></span><span></span>
      </button>
      <ul class="nav-links" id="navLinks">
        <li><a href="<?php echo $base; ?>index.php"<?php echo nav_active('home', $activeNav); ?>>Home</a></li>
        <li><a href="<?php echo $base; ?>about.php"<?php echo nav_active('about', $activeNav); ?>>About</a></li>
        <li><a href="<?php echo $base; ?>academics.php"<?php echo nav_active('academics', $activeNav); ?>>Academics</a></li>
        <li><a href="<?php echo $base; ?>faculties.php"<?php echo nav_active('faculties', $activeNav); ?>>Faculties</a></li>
        <li><a href="<?php echo $base; ?>research.php"<?php echo nav_active('research', $activeNav); ?>>Research</a></li>
        <li><a href="<?php echo $base; ?>admission.php"<?php echo nav_active('admission', $activeNav); ?>>Admission</a></li>
        <li><a href="<?php echo $base; ?>student-life.php"<?php echo nav_active('student-life', $activeNav); ?>>Student Life</a></li>
        <li><a href="<?php echo $base; ?>news.php"<?php echo nav_active('news', $activeNav); ?>>News &amp; Events</a></li>
        <li><a href="<?php echo $base; ?>services.php"<?php echo nav_active('services', $activeNav); ?>>Services</a></li>
        <li><a href="<?php echo $base; ?>contact.php"<?php echo nav_active('contact', $activeNav); ?>>Contact</a></li>
        <?php if ($user): ?>
          <li><a href="<?php echo $base; ?>dashboard.php"<?php echo nav_active('dashboard', $activeNav); ?>>Dashboard</a></li>
          <?php if ($user['role'] === 'admin'): ?>
            <li><a href="<?php echo $base; ?>admin/index.php"<?php echo nav_active('admin', $activeNav); ?>>Admin Panel</a></li>
          <?php endif; ?>
          <li><a href="<?php echo $base; ?>logout.php">Log Out (<?php echo h($user['username']); ?>)</a></li>
        <?php else: ?>
          <li><a href="<?php echo $base; ?>login.php"<?php echo nav_active('login', $activeNav); ?>>Login</a></li>
        <?php endif; ?>
        <li class="theme-toggle-item">
          <button type="button" id="themeToggle" class="theme-toggle" aria-label="Toggle dark mode">
            <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
            <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg>
          </button>
        </li>
      </ul>
    </div>
  </header>

  <?php if (!$noBanner): ?>
  <div class="page-banner" style="background-image:url('<?php echo $base . $bannerImage; ?>');">
    <div class="page-banner-overlay"></div>
    <div class="container page-banner-content">
      <span class="page-banner-badge">KUE</span>
      <h1><?php echo h($pageHeading); ?></h1>
    </div>
  </div>
  <?php endif; ?>
