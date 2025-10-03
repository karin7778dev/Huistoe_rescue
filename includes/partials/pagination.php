<?php
// includes/partials/pagination.php
// Expects $page, $totalPages, and $_GET parameters

// Build base URL preserving other filters
$query = $_GET;
$urlBase = strtok($_SERVER['REQUEST_URI'], '?') . '?';

// Helper to build link
function pageLink(int $target, array $query) {
    $query['page'] = $target;
    return htmlspecialchars($_SERVER['PHP_SELF'] . '?' . http_build_query($query));
}
?>

<ul class="pagination justify-content-center mb-0">
  <!-- Prev -->
  <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
    <a class="page-link" href="<?= $page > 1 ? pageLink($page - 1, $query) : '#' ?>">
      Prev
    </a>
  </li>

  <!-- Page numbers (show max ±2 around current) -->
  <?php
    $start = max(1, $page - 2);
    $end   = min($totalPages, $page + 2);
    for ($i = $start; $i <= $end; $i++):
  ?>
    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
      <a class="page-link" href="<?= pageLink($i, $query) ?>">
        <?= $i ?>
      </a>
    </li>
  <?php endfor; ?>

  <!-- Next -->
  <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
    <a class="page-link" href="<?= $page < $totalPages ? pageLink($page + 1, $query) : '#' ?>">
      Next
    </a>
  </li>
</ul>