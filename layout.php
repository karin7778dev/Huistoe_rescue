<?php
// layout.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- // 1. We assume config is loaded via header, so no need to require it again here -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Huistoe Animal Rescue Centre</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

  <!-- Site Header -->
  <?php include __DIR__ . '/includes/header.php'; ?>

  <!-- Main Content -->
  <main class="page-content">
  <?php
    if (is_file($pageContent)) {
      include $pageContent;
    } else {
      echo '<p>Oops, page not found.</p>';
    }
  ?>
</main>


  <!-- Site Footer -->
  <?php include __DIR__ . '/includes/footer.php'; ?>

  <!-- Bootstrap JS Bundle (includes Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

  <!-- Define BASE_URL for JavaScript -->
<script>
  const BASE_URL = "<?= BASE_URL ?>";
</script>

<!-- Now load your main JS -->
<script src="<?= BASE_URL ?>/assets/js/layout.js" defer></script>

</body>
</html>