<main class="container my-4 dogs-page">

<!-- DOG CARDS & PAGINATION -->
<?php if ($result->num_rows > 0): ?>
  <section id="dogCardCarousel"
   class="dogs-carousel my-4">
    <button class="carousel-control prev" aria-label="Previous">&#10094;</button>

    <div class="carousel-window">
      <div class="carousel-track">
        <?php foreach ($featuredDogs as $dog): ?>
          <?php
              $extraList   = $dog['extra_list'] ?? '';
              $mainInline   = $dog['main_inline'] ?? '';
              $fosterUrl  = BASE_URL . '/includes/download.php';   // adjust to your real paths
              $adoptUrl   = BASE_URL . '/includes/download.php';
          ?>
          <div class="carousel-card">
            <div class="card dog-card position-relative">
              <span class="badge badge-status badge-<?= htmlspecialchars($dog['status_slug']) ?>">
                <?= ucfirst(htmlspecialchars($dog['status_slug'])) ?>
              </span>

              <div class="card-img-container">
                <img src="<?= htmlspecialchars($dog['photo_url'] ?: 'assets/images/default-dog.jpg') ?>"
                     alt="Photo of <?= htmlspecialchars($dog['name']) ?>">
              </div>

              <div class="card-body">
              <h5 class="card-title <?= ($dog['gender'] === 'Male') ? 'dog-male' : (($dog['gender'] === 'Female') ? 'dog-female' : '') ?>">
                <?= htmlspecialchars($dog['name']) ?>
              </h5>
                <p class="card-text">
                  <small class="text-muted">
                    <?= htmlspecialchars($dog['gender']) ?>,
                    <?php
                      if($dog['date_of_birth']) {
                        $dob = new DateTime($dog['date_of_birth']);
                        $now = new DateTime();
                        $diff = $dob->diff($now);
                        $ageText = ($diff->y > 0) ? $diff->y . ' yrs' : $diff->m . ' months';
                      } elseif ($dog['age_description']){
                        $ageText = $dog['age_description'];
                      } else {
                        $ageText = 'Age Unknown';
                      }
                    ?>
                    <?= htmlspecialchars($dog['breed']) ?>, <?= $ageText ?>
                  </small>
                </p>
               
                <div class="d-flex gap-2">
                  <?php if (in_array(htmlspecialchars($dog['status_slug']), ['Available', 'Fostered'])): ?>
                      <button class="col-md-6 btn btn-dogs open-form-btn" target="_blank"
                              data-name="<?= htmlspecialchars($dog['name']) ?>"
                              data-story="<?= htmlspecialchars($dog['my_story'] ?? '') ?>"
                              data-img="<?= htmlspecialchars($dog['dog_info_card']) ?>"
                              data-extra="<?= htmlspecialchars(implode(',', $extraList)) ?>"
                              data-foster="<?= htmlspecialchars($fosterUrl) ?>"
                              data-adopt="<?= htmlspecialchars($adoptUrl) ?>">
                        More details
                      </button>                      
                      <button class="col-md-6 btn btn-dogs view-more-btn" target="_blank"
                              data-name="<?= htmlspecialchars($dog['name']) ?>"
                              data-story="<?= htmlspecialchars($dog['my_story'] ?? '') ?>"
                              data-img="<?= htmlspecialchars($mainInline) ?>"  
                              data-extra="<?= htmlspecialchars(implode(',', $extraList)) ?>"
                              data-foster="<?= htmlspecialchars($fosterUrl) ?>"
                              data-adopt="<?= htmlspecialchars($adoptUrl) ?>">
                        My Story
                      </button>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <button class="carousel-control next" aria-label="Next">&#10095;</button>
  </section>
<?php else: ?>
  <div class="alert alert-info text-center">
    No dogs match your filters.
  </div>
<?php endif; ?>

<!-- Dog Info Overlay -->
    <div class="dog-form-overlay" id="dogForm">
      <div class="dog-form-content">
        <img id="dogInfoImg" src="" alt="Dog Info" />
        <div class="form-buttons">
          <a id="adoptBtn" href="#" target="_blank" class="btn btn-dogs">Adopt/Foster Me</a>
          <button class="close-form-btn">Close</button>
        </div>
      </div>
    </div>


<!-- Dog Info Section (initially hidden) -->
<section id="dogInfoSection" class="dog-info-section d-none my-5">
  <div class="row">
    <!-- Left: Dog images -->
    <div class="col-md-6" id="dogInfoImages">
      <div class="dog-sub-images"></div>
    </div>

    <!-- Right: Dog story -->
    <div class="col-md-6">
      <h2 id="dogInfoName"></h2>
      <div id="dogInfoStoryWrapper">
        <p id="dogInfoStory"></p>
      </div>
    </div>
  </div>

  <!-- Buttons now outside the scrollable story -->
  <div class="dog-info-buttons mt-3 d-flex gap-3 justify-content-center">
    <a id="fosterBtn" href="#" target="_blank" class="btn btn-dogs">Foster Me</a>
    <a id="adoptBtnInline" href="#" target="_blank" class="btn btn-dogs">Adopt Me</a>
    <button id="backBtn" class="btn btn-dogs">Close</button>
  </div>
</section>

  <br>
  <hr class="blog-line">
  <br> 


    <!-- Blog with image left -->
    <div id="adoptionProcess" class="blog-row image-left">
      <div class="blog-image">
        <img src="<?= BASE_URL ?>/assets/images/AdoptionProcess.jpg" alt="How to Adopt">
      </div>
      <div class="blog-text">
        <h2>&nbsp;&nbsp;&nbsp;Adoption process - 🐾 How to Adopt:</h2>
        <p> 1️⃣ Reach Out:- Contact us on 082 387 9230 or email info@huistoeanimalwelfare.co.za to schedule a visit to our shelter – or skip right ahead to the admin if you already have your heart set on one of our snoots!
            <br>2️⃣ Apply:- download, complete and email the adoption application form bacl to us email.
            <br>3️⃣ Meet & Match:- We’ll set up a meet and greet and do a quick home check to ensure it’s a perfect match for you and your future fur baby.
            <br>4️⃣ Final Steps:- Once approved, sign the contract and pay the adoption fee.
            <br>5️⃣ Bring Your Pup Home!:- Your new best friend comes sterilized, fully vaccinated, dewormed, treated for ticks and fleas, and microchipped or tagged – all included in the adoption fee. 🐕💉💖
            <br>📷 Browse the album now and fall in love with your next four-legged family member!
            <br>💛 We are busy with a few more adoption posters as we speak! So many babies looking for their happily-ever-afters!!
        </p>
        <div class="d-flex gap-2">
          <a href="<?= BASE_URL ?>/includes/download.php" target="_blank" class="col-md-6 btn btn-dogs">Open Adoption application</a>
          <a href="#" class="col-md-6 btn btn-dogs secondary">Back</a>
        </div>
      </div>
    </div>

</main>