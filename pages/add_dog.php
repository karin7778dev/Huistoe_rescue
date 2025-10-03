<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // sanitize inputs
    $name   = $conn->real_escape_string($_POST['name']);
    $age    = (int) $_POST['age'];
    $breed  = $conn->real_escape_string($_POST['breed']);
    $status = $conn->real_escape_string($_POST['status']);
    $temperament    = $conn->real_escape_string($_POST['temperament']);
  
    // handle image upload
    $photo_url = 'assets/images/default-dog.jpg';
    if (!empty($_FILES['photo']['tmp_name'])) {
      $targetDir = __DIR__ . '/assets/images/dogs/';
      $filename  = uniqid() . '_' . basename($_FILES['photo']['name']);
      if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetDir . $filename)) {
        $photo_url = 'assets/images/dogs/' . $filename;
      }
    }
  
    // insert into database
    $sql = "INSERT INTO dogs
      (name, age, breed, size, gender, status, temperament, photo_url)
      VALUES
      ('$name', $age, '$breed', 'medium', 'unknown', '$status', '$temperament', '$photo_url')";
      
    if ($conn->query($sql)) {
      header('Location: dogs.php');
      exit;
    } else {
      echo '<div class="alert alert-danger">Error: ' . $conn->error . '</div>';
    }
  }
?>

<div class="container">
  <h2>Add New Dog</h2>
  <form
    action="add_dog.php"
    method="post"
    enctype="multipart/form-data"
    class="row g-3"
  >
    <div class="col-md-6">
      <label>Name</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="col-md-3">
      <label>Age</label>
      <input type="number" name="age" class="form-control" min="0">
    </div>
    <div class="col-md-3">
      <label>Breed</label>
      <input type="text" name="breed" class="form-control">
    </div>
    <div class="col-md-4">
      <label>Status</label>
      <select name="status" class="form-select">
        <option>available</option>
        <option>fostered</option>
        <option>adopted</option>
      </select>
    </div>
    <div class="col-md-4">
      <label>Photo</label>
      <input type="file" name="photo" class="form-control">
    </div>
    <div class="col-12">
      <label>temperament</label>
      <textarea name="temperament" class="form-control" rows="3"></textarea>
    </div>
    <div class="col-12">
      <button type="submit" name="submit" class="btn btn-success">
        Add Dog
      </button>
    </div>
  </form>
</div>



<!-- HERE IS CURRENT DOG PAGE -->
  <!-- FILTER FORM -->
  <form method="get" class="row g-3 mb-4">

    <!-- BREED MULTI-SELECT DROPDOWN -->
    <div class="col-md-6">
      <label class="form-label">Breed</label>
      <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start"
                type="button"
                id="breedDropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false">
          <?php
            if (count($selectedBreeds) === count($allBreeds)) {
              echo 'All Breeds';
            } else {
              echo htmlspecialchars(implode(', ', $selectedBreeds));
            }
          ?>
        </button>
        <ul class="dropdown-menu p-3"
            aria-labelledby="breedDropdown"
            data-bs-auto-close="outside"
            style="min-width: 16rem;">
          <li class="form-check">
            <input class="form-check-input" type="checkbox" id="breed-all" name="breed[]" value="all"
              <?= count($selectedBreeds) === count($allBreeds) ? 'checked' : '' ?>>
            <label class="form-check-label" for="breed-all">All Breeds</label>
          </li>
          <li><hr class="dropdown-divider"></li>
          <?php foreach ($allBreeds as $breed): ?>
            <li class="form-check">
              <input class="form-check-input" type="checkbox"
                     name="breed[]" id="breed-<?= htmlspecialchars($breed) ?>"
                     value="<?= htmlspecialchars($breed) ?>"
                     <?= in_array($breed, $selectedBreeds, true) ? 'checked' : '' ?>>
              <label class="form-check-label" for="breed-<?= htmlspecialchars($breed) ?>">
                <?= htmlspecialchars($breed) ?>
              </label>
            </li>
          <?php endforeach; ?>
          <li class="mt-3">
            <button type="submit" class="btn btn-sm btn-primary w-100">Apply Filters</button>
          </li>
        </ul>
      </div>
    </div>

    <!-- STATUS MULTI-SELECT DROPDOWN -->
    <div class="col-md-6">
      <label class="form-label">Status</label>
      <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start"
                type="button"
                id="statusDropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false">
          <?php
            if (count($selectedStatuses) === count($allStatusIds)) {
              echo 'All Statuses';
            } else {
              $labels = array_map(
                fn($s) => ucfirst(htmlspecialchars($s['slug'])),
                array_filter(
                  $allStatuses,
                  fn($s) => in_array((int)$s['id'], $selectedStatuses, true)
                )
              );
              echo implode(', ', $labels);
            }
          ?>
        </button>
        <ul class="dropdown-menu p-3"
            aria-labelledby="statusDropdown"
            data-bs-auto-close="outside"
            style="min-width: 16rem;">
          <li class="form-check">
            <input class="form-check-input" type="checkbox" id="status-all" name="status[]" value="all"
              <?= count($selectedStatuses) === count($allStatusIds) ? 'checked' : '' ?>>
            <label class="form-check-label" for="status-all">All Statuses</label>
          </li>
          <li><hr class="dropdown-divider"></li>
          <?php foreach ($allStatuses as $s): ?>
            <li class="form-check">
              <input class="form-check-input" type="checkbox"
                     name="status[]" id="status-<?= $s['id'] ?>"
                     value="<?= htmlspecialchars($s['slug']) ?>"
                     <?= in_array((int)$s['id'], $selectedStatuses, true) ? 'checked' : '' ?>>
              <label class="form-check-label" for="status-<?= $s['id'] ?>">
                <?= ucfirst(htmlspecialchars($s['slug'])) ?>
              </label>
            </li>
          <?php endforeach; ?>
          <li class="mt-3">
            <button type="submit" class="btn btn-sm btn-primary w-100">Apply Filters</button>
          </li>
        </ul>
      </div>
    </div>

  </form>

  <!-- Filter showing All message -->
  <?php if ($showingAllMessage): ?>
    <div class="alert-box" id="alertBox">
        <span>Showing all dogs by default.</span>
        <button class="close-btn" onclick="document.getElementById('alertBox').style.display='none'">×</button>
    </div>
  <?php endif; ?>

  <!-- DOG CARDS & PAGINATION -->
  <?php if ($result->num_rows > 0): ?>
    <div class="row">
      <?php while ($dog = $result->fetch_assoc()): ?>
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
          <div class="card position-relative h-100">
            <span class="badge badge-status badge-<?= htmlspecialchars($dog['status_slug']) ?>">
              <?= ucfirst(htmlspecialchars($dog['status_slug'])) ?>
            </span>
            <img src="<?= htmlspecialchars($dog['photo_url'] ?: 'assets/images/default-dog.jpg') ?>"
                 class="card-img-top"
                 alt="Photo of <?= htmlspecialchars($dog['name']) ?>">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($dog['name']) ?></h5>
              <p class="card-text mb-2">
                <small class="text-muted">
                  <?= htmlspecialchars($dog['breed']) ?>,
                  <?= (int)$dog['age'] ?> yrs
                </small>
              </p>
              <a href="dog_detail.php?id=<?= (int)$dog['id'] ?>"
                 class="mt-auto btn btn-sm btn-primary">
                View Details
              </a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <nav aria-label="Dog list pagination">
      <ul class="pagination justify-content-center mt-4">
        <!-- Existing pagination code here -->
      </ul>
    </nav>

  <?php else: ?>
    <!-- <div class="alert alert-info text-center">
      No dogs match your filters.
    </div> -->
  <?php endif; ?>