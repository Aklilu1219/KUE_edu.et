-- =========================================================
--  KUE (Kotebe University of Education) website database
--  Import this file in phpMyAdmin (XAMPP) to create everything
--  needed: the database, the tables, and one starter admin
--  account so you can log in and manage the site.
-- =========================================================

CREATE DATABASE IF NOT EXISTS kue_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE kue_db;

-- ---------------------------------------------------------
-- users: every account on the site. `role` decides what a
-- person can do, `status` decides whether they're allowed
-- to log in yet.
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    full_name     VARCHAR(100)        NOT NULL,
    username      VARCHAR(30)         NOT NULL UNIQUE,
    email         VARCHAR(100)        NOT NULL UNIQUE,
    password      VARCHAR(255)        NOT NULL,          -- stored with password_hash(), never plain text
    role          ENUM('student','staff','admin') NOT NULL DEFAULT 'student',
    status        ENUM('active','pending','suspended')   NOT NULL DEFAULT 'active',
    student_id    VARCHAR(20)         NULL,               -- only used when role = student
    department    VARCHAR(100)        NULL,               -- only used when role = staff
    created_at    TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- applications: admission applications. A student submits
-- one from their dashboard; staff/admin review and update
-- its status.
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS applications (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    user_id           INT                 NOT NULL,
    program           VARCHAR(150)        NOT NULL,
    applicant_name    VARCHAR(100)        NULL,
    applicant_email   VARCHAR(100)        NULL,
    applicant_phone   VARCHAR(20)         NULL,
    status            ENUM('pending','under_review','accepted','rejected') NOT NULL DEFAULT 'pending',
    submitted_at      TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- news: announcements shown on the News & Events page.
-- Only Staff and Admin accounts can post; everyone can read.
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS news (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    title         VARCHAR(150)        NOT NULL,
    body          TEXT                NOT NULL,
    posted_by     INT                 NOT NULL,
    created_at    TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (posted_by) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Starter admin account.
-- username: admin   |   password: Admin@123
-- CHANGE THIS PASSWORD after your first login (Admin Panel
-- has no "change password" screen yet, so for now update it
-- straight in phpMyAdmin with a new password_hash() value,
-- or add a change-password page later).
-- ---------------------------------------------------------
INSERT INTO users (full_name, username, email, password, role, status)
VALUES (
    'Site Administrator',
    'admin',
    'admin@kue.edu.et',
    '$2y$10$o2W0tHmNID1y4I9Pxdhljuy6AtwYXbyjMlrZndUOw7n0me2AAjKwO', -- Admin@123
    'admin',
    'active'
)
ON DUPLICATE KEY UPDATE username = username;
