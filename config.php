<?php
/**
 * Database connection settings for XAMPP.
 * Default XAMPP MySQL credentials are host=localhost, user=root, no password.
 * Change these only if you changed your MySQL setup.
 */
$DB_HOST = "localhost";
$DB_NAME = "kue_db";
$DB_USER = "root";
$DB_PASS = "";

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
    // Fail loudly but avoid leaking connection details to the browser.
    die("Database connection failed. Please make sure XAMPP's MySQL service is running "
      . "and that the 'kue_db' database has been imported (see sql/kue_db.sql).");
}

$conn->set_charset("utf8mb4");
