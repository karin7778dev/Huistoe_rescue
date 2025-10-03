<?php
require_once __DIR__ . '/config.php'; // if BASE_URL or constants are needed

// Path to your file
$file = __DIR__ . '/../uploads/forms/adoption_form.pdf';

// Simple mobile detection
$userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
$isMobile = preg_match('/iphone|ipod|ipad|android|blackberry|mini|windows\sce|palm/i', $userAgent);

// If file doesn't exist, show styled message
if (!file_exists($file)) {
    http_response_code(404);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>File Not Found</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #faf6f1;
                color: #333;
                text-align: center;
                padding: 2rem;
            }
            .error-box {
                background: #fff;
                border: 2px solid #d4b483;
                border-radius: 8px;
                display: inline-block;
                padding: 2rem;
                max-width: 400px;
            }
            h1 {
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }
            a {
                display: inline-block;
                margin-top: 1rem;
                padding: 0.5rem 1rem;
                background: #d4b483;
                color: #fff;
                text-decoration: none;
                border-radius: 4px;
            }
            a:hover {
                background: #bfa06f;
            }
        </style>
    </head>
    <body>
        <div class="error-box">
            <h1>🐾 Oops! File Not Found</h1>
            <p>We couldn’t find the adoption form right now.<br>
               Please try again later or contact us for assistance.</p>
            <a href="<?= BASE_URL ?>/index.php?page=contact">Contact Us</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Serve file
// if ($isMobile) {
//     // Mobile: stream inline
//     header('Content-Type: application/pdf');
//     header('Content-Disposition: inline; filename="' . basename($file) . '"');
//     header('Content-Length: ' . filesize($file));
//     header('Accept-Ranges: bytes');
//     readfile($file);
//     exit;
// } else 
// {
    // Desktop: force download
//     header('Content-Description: File Transfer');
//     header('Content-Type: application/pdf');
//     header('Content-Disposition: attachment; filename="' . basename($file) . '"');
//     header('Content-Length: ' . filesize($file));
//     flush();
//     readfile($file);
//     exit;
// }

// Serve file inline for all devices
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . basename($file) . '"');
header('Content-Length: ' . filesize($file));
header('Accept-Ranges: bytes');
readfile($file);
exit;