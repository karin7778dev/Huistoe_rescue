<?php
// dogsController.php

// 1. Bootstrap & dependencies
require_once __DIR__ . '/../includes/db.php';

// Load all dogs available for adoption
// Featured dogs for hero carousel – e.g. first 5 available
$featuredDogs = [];
$featuredRS = $conn->query("SELECT 
        d.id,
        d.name,
        d.photo_url,
        d.breed,
        d.gender,
        d.date_of_birth,
        s.slug AS status_slug,
        d.date_added,
        d.dog_info_card,
        d.my_story,
        d.age_description,
        d.dob_type,
        d.health_info,
        GROUP_CONCAT(DISTINCT e.image_url ORDER BY e.sort_order SEPARATOR ',') AS extra_images
        -- GROUP_CONCAT(e.image_url ORDER BY e.sort_order) AS extra_images
    FROM dogs d
    JOIN statuses s 
        ON d.status_id = s.id
    LEFT JOIN dog_extra_images e 
        ON e.dog_id = d.id
    WHERE s.slug NOT IN ('adopted')
    GROUP BY d.id, d.name, d.photo_url, d.breed, d.gender, d.date_of_birth,
            s.slug, d.date_added, d.dog_info_card, d.my_story,
            d.age_description, d.dob_type, d.health_info
    ORDER BY d.date_added DESC");

if ($featuredRS) {
    while ($row = $featuredRS->fetch_assoc()) {
        // Use $row, not $dog
        $extraRaw   = $row['extra_images'] ?? '';
        $extraList  = $extraRaw ? array_map('trim', explode(',', $extraRaw)) : [];
        $mainInline = !empty($extraList) ? $extraList[0] : $row['photo_url'];

        // If you want to keep these computed values with the row:
        $row['extra_list']  = $extraList;
        $row['main_inline'] = $mainInline;

        $featuredDogs[] = $row;
    }
}

// 1. Load all statuses
$allStatuses = [];
$statusRS = $conn->query("SELECT id, slug FROM statuses ORDER BY id");
if (!$statusRS) {
    error_log('DB error: ' . $conn->error);
    echo "<div class='alert alert-danger'>Something went wrong. Please try again later.</div>";
}
while ($row = $statusRS->fetch_assoc()) {
    $allStatuses[] = $row;
}
$allStatusIds = array_column($allStatuses, 'id');

// 2. Load all breeds
$allBreeds = [];
$breedRS = $conn->query("SELECT DISTINCT breed FROM dogs ORDER BY breed");
if (!$breedRS) {
    error_log('DB error: ' . $conn->error);
    echo "<div class='alert alert-danger'>Something went wrong. Please try again later.</div>";
}
while ($row = $breedRS->fetch_assoc()) {
    $allBreeds[] = $row['breed'];
}

// 3. Default statuses if no filter
$defaultSlugs = ['available', 'on-hold'];
$defaultStatusIds = array_column(
    array_filter(
        $allStatuses,
        fn($s) => in_array($s['slug'], $defaultSlugs, true)
    ),
    'id'
);

// 4. Capture selected statuses (slug values from GET)
$showingAllMessage = false;

if (isset($_GET['status']) && is_array($_GET['status'])) {
    $rawStatus = $_GET['status'];
    if (empty($rawStatus) || in_array('all', $rawStatus, true)) {
        $selectedStatuses = $allStatusIds;
        $showingAllMessage = true;
    } else {
        $selectedStatuses = array_column(
            array_filter(
                $allStatuses,
                fn($s) => in_array($s['slug'], $rawStatus, true)
            ),
            'id'
        );
    }
} else {
    $selectedStatuses = $defaultStatusIds;
    $showingAllMessage = true;
}

// 5. Capture selected breeds
if (isset($_GET['breed']) && is_array($_GET['breed'])) {
    $rawBreeds = $_GET['breed'];
    if (empty($rawBreeds) || in_array('all', $rawBreeds, true)) {
        $selectedBreeds = $allBreeds;
        $showingAllMessage = true;
    } else {
        $selectedBreeds = array_values(array_intersect($allBreeds, $rawBreeds));
    }
} else {
    $selectedBreeds = $allBreeds;
    $showingAllMessage = true;
}

// 6. Build WHERE + params with guards
$where   = [];
$params  = [];
$types   = '';

// Breed filter
if (count($selectedBreeds) > 0 && count($selectedBreeds) < count($allBreeds)) {
    $ph = implode(',', array_fill(0, count($selectedBreeds), '?'));
    $where[] = "dogs.breed IN ($ph)";
    foreach ($selectedBreeds as $b) {
        $params[] = $b;
        $types   .= 's';
    }
}

// Status filter
if (count($selectedStatuses) > 0 && count($selectedStatuses) < count($allStatusIds)) {
    $ph = implode(',', array_fill(0, count($selectedStatuses), '?'));
    $where[] = "dogs.status_id IN ($ph)";
    foreach ($selectedStatuses as $i) {
        $params[] = $i;
        $types   .= 'i';
    }
}

$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// 7. Pagination setup
$perPage = 12;
$page    = max(1, (int)($_GET['page'] ?? 1));
$offset  = ($page - 1) * $perPage;

// 8. Count total
$countSql = "
  SELECT COUNT(*) AS total
    FROM dogs
    JOIN statuses ON dogs.status_id = statuses.id
  $whereSQL
";
$countStmt = $conn->prepare($countSql);
if ($types !== '') {
    $countStmt->bind_param($types, ...$params);
}
$countStmt->execute();
$total      = (int)$countStmt->get_result()->fetch_assoc()['total'];
$totalPages = (int)ceil($total / $perPage);

$page   = min(max(1, $page), max(1, $totalPages));
$offset = ($page - 1) * $perPage;

// 9. Fetch page
$sql = "
  SELECT dogs.*, statuses.slug AS status_slug
    FROM dogs
    JOIN statuses ON dogs.status_id = statuses.id
  $whereSQL
  ORDER BY dogs.date_added DESC
  LIMIT ? OFFSET ?
";
$paramsWithLimit = [...$params, $perPage, $offset];
$typesWithLimit  = $types . 'ii';

$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log('DB error: ' . $conn->error);
    echo "<div class='alert alert-danger'>Something went wrong. Please try again later.</div>";
}
$stmt->bind_param($typesWithLimit, ...$paramsWithLimit);
$stmt->execute();
$result = $stmt->get_result();

$pageContent = __DIR__ . '/../pages/dogs.php';
require_once __DIR__ . '/../layout.php';