# KUE Website - Database Setup (XAMPP)

This adds a real MySQL database + PHP backend to your KUE site: user
accounts (Student / Staff / Admin), a login/registration system, an
admin panel to manage accounts, and an application tracker.

## What's in this folder

```
kue_web/
├── config.php              <- database connection settings
├── login.php                 replaces login.html
├── register.php               Student-only public registration
├── logout.php
├── dashboard.php              role-based dashboard (student vs staff/admin)
├── admission.php              real, database-backed application wizard
├── news.php                   real, database-backed News & Events page
├── about.php, academics.php, contact.php, faculties.php,
│   faq.php, research.php, services.php, student-life.php,
│   index.php                  every other page, now dynamic PHP
├── feedback.php                courtesy redirect to contact.php#feedback
├── admin/
│   └── index.php               admin-only: create accounts (any role),
│                                approve/promote/suspend/delete accounts
├── includes/
│   ├── auth.php                 session + role helpers
│   ├── header.php                shared header/nav (session-aware, all pages)
│   └── footer.php                shared footer + chatbot widget
├── sql/
│   └── kue_db.sql               database schema + starter admin account
├── css/, js/                     styling + client-side UI behavior only
```

Your `images/` and `videos/` folders are **not** included here (they're
large and unchanged) - just copy this folder's contents into your
existing site folder so they sit next to your existing `images/` and
`videos/` folders.

## 1. Install / start XAMPP

1. Open the **XAMPP Control Panel**.
2. Start **Apache** and **MySQL**.

## 2. Put the site in htdocs

Copy your whole site (this folder's contents merged with your existing
`images/` and `videos/` folders) into:

```
C:\xampp\htdocs\kue_web\
```

So you end up with `C:\xampp\htdocs\kue_web\index.php`,
`C:\xampp\htdocs\kue_web\login.php`, `C:\xampp\htdocs\kue_web\images\...`, etc.

## 3. Create the database

1. Go to `http://localhost/phpmyadmin`.
2. Click **Import** (top tab).
3. Choose the file `sql/kue_db.sql` from this folder.
4. Click **Go**.

This creates the `kue_db` database with three tables (`users`,
`applications`, `news`) and one starter admin account:

- **Username:** `admin`
- **Password:** `Admin@123`

**Change this password after your first login** (for now, do it in
phpMyAdmin by editing the `users` table row and using the "Password"
function type with a new password so it stays hashed).

## 4. Check config.php

`config.php` already matches XAMPP's defaults (`host=localhost`,
`user=root`, no password). You only need to change it if your MySQL
setup is different.

## 5. Try it

- Visit `http://localhost/kue_web/register.php` and create a Student
  account - it's active immediately.
- Log in as `admin` at `http://localhost/kue_web/login.php`
  (password `Admin@123`), go to **Admin Panel** from the nav bar, and
  use the **Create New Account** form to create a Staff account (or
  another Admin account) - it's active immediately too, no approval
  step needed since you're creating it yourself as an administrator.
- Log out and log in as that new Staff account - it can see the "All
  Applications" view on its dashboard and can post announcements from
  the News & Events page.
- Log in as the student account, go to **Admission**, and submit an
  application through the multi-step wizard - then check your
  Dashboard to see it, or log in as staff/admin to see and update it.

## How permissions differ by role

| Action                              | Student | Staff | Admin |
|--------------------------------------|:-------:|:-----:|:-----:|
| Register a new account (public form) |   ✅ (self only) |  ❌   |  ❌   |
| Submit / view own applications       |   ✅    |  ✅   |  ✅   |
| View & update ALL applications       |   ❌    |  ✅   |  ✅   |
| Post a News & Events announcement    |   ❌    |  ✅   |  ✅   |
| Create Student/Staff/Admin accounts  |   ❌    |  ❌   |  ✅   |
| Approve pending accounts, promote/demote roles, suspend/delete |   ❌    |  ❌   |  ✅   |

The public `register.php` form now **only ever creates Student accounts**
— there's no role picker on it anymore. Staff and Admin accounts can
only be created by an existing administrator, from the **Create New
Account** panel at the top of the Admin Panel (`admin/index.php`).
Accounts created this way are active immediately (no approval step,
since an administrator is vouching for them directly).

`includes/auth.php`'s `require_role()` enforces all of this on the
server side (not just hiding buttons in HTML), so e.g. a student can't
reach `admin/index.php` even by typing the URL directly.

## Every page is now dynamic

All of the site's pages (Home, About, Academics, Faculties, Research,
Admission, Student Life, News & Events, Services, Contact) are now
real PHP pages sharing one header/footer (`includes/header.php` /
`includes/footer.php`), instead of separate static HTML files. This
means:

- The navigation bar genuinely reflects who's logged in (Login vs.
  Dashboard / Admin Panel / Log Out) everywhere on the site, not just
  on the login/register/dashboard pages.
- The current page is highlighted in the nav.
- **News & Events** is now backed by the `news` table - Staff and
  Admin see a "Post an announcement" form right on the page; everyone
  else just sees the real posts.
- **Admission** applications submitted through the multi-step wizard
  on `admission.php` are saved to the real `applications` table (tied
  to whoever is logged in) instead of the browser's local storage -
  you must be logged in to submit, and you'll see a specific message
  for each thing that needs fixing (missing name, invalid email,
  invalid phone, no program selected, confirmation box not ticked).

## Validation messages you'll see

Registration and login give a specific message for each situation,
instead of one generic error, for example:

- "This username is already taken. Please choose another."
- "This email address is already registered."
- "Password must be at least 8 characters long."
- "Passwords do not match."
- "Incorrect password. Please try again."
- "This account has been suspended. Please contact the administrator."

The admin panel does the same for account actions, e.g. "You cannot
delete your own administrator account," "That account is already
active," "\"jdoe\" is now a Staff."

## Notes / things you may want to add later

- **Password reset / change password page** - not included yet; for
  now, change a password directly in phpMyAdmin using the "Password"
  function type so it stays hashed.
- The **Feedback**, **Contact form**, and **Newsletter signup** on the
  Contact page are still the original demo behavior (they show a
  thank-you message but don't save anywhere) - let me know if you'd
  like those wired up to the database too.
- All database queries use prepared statements (protects against SQL
  injection), and passwords are stored with PHP's `password_hash()`
  (bcrypt) - never in plain text.
