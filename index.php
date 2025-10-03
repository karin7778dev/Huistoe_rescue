<?php

// // website visits counter
$counterFile = __DIR__ . '/includes/counter.txt';

if (file_exists($counterFile)) {
  $count = (int)file_get_contents($counterFile);
  $count++;
  file_put_contents($counterFile, $count);
} else {
  file_put_contents($counterFile, 1);
}

require_once __DIR__ . '/includes/config.php';

// Get visitor info
$ip   = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$page = $_GET['page'] ?? 'home';
$now  = date('Y-m-d H:i:s');

// Insert into DB
$stmt = $pdo->prepare("INSERT INTO site_visits (visit_time, ip_address, page) VALUES (?, ?, ?)");
$stmt->execute([$now, $ip, $page]);

// index.php

// 1. Determine which page to show (default to 'home')
$page = $_GET['page'] ?? 'home';

// 2. Locate the corresponding controller
$controllerFile = __DIR__ . '/controllers/' . $page . 'Controller.php';

if (file_exists($controllerFile)) {
    // Controller sets $pageContent
    require_once $controllerFile;
} else {
    // Fallback for unknown pages
    require_once __DIR__ . '/pages/404.php';
}

// 3. Render the full layout (header + content + footer)
require_once __DIR__ . '/layout.php';