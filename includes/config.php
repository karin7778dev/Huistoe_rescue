<?php
// includes/config.php

$env = parse_ini_file(__DIR__ . '/../.env');
if (!$env) {
    throw new Exception('.env file not found or unreadable');
}

define('DB_HOST', $env['DB_HOST']);
define('DB_NAME', $env['DB_NAME']);
define('DB_USER', $env['DB_USER']);
define('DB_PASS', $env['DB_PASS']);
define('ADMIN_USER', $env['ADMIN_USER']);
define('ADMIN_PASS', $env['ADMIN_PASS']);

// Base URL for assets and links (no trailing slash)
define('BASE_URL', 'http://localhost:8080/huistoe_rescue');

// Create PDO connection
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}