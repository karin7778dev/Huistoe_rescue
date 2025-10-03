<?php
// includes/header.php
require_once __DIR__ . '/config.php';

$currentPage = $_GET['page'] ?? 'home';
?>
<header class="page-header <?= htmlspecialchars($currentPage, ENT_QUOTES) ?>">
  <div class="header-inner">
    <!-- Logo -->
    <a href="<?= BASE_URL ?>/index.php?page=home" class="site-logo" aria-label="Huistoe Rescue home">
      <img
        src="<?= BASE_URL ?>/assets/images/Huistoe_logo.jpg"
        alt="Huistoe Rescue"
      >
    </a>

    <!-- Header description -->
    <p class="header-description">
      <?php if ($currentPage === 'home'): ?>  
        Rescuing, Rehabilitation, and Rehoming of dogs
      <?php elseif ($currentPage === 'dogs'):
        echo "Dogs available for adoption"; ?>
      <?php elseif ($currentPage === 'volunteers'):
        echo "Get Involved"; ?>
      <?php elseif ($currentPage === 'donations'):
        echo "Support Us"; ?>
      <?php elseif ($currentPage === 'about'):
        echo "About Us"; ?>
      <?php elseif ($currentPage === 'contact'):
        echo "Contact Us"; ?>
      <?php elseif ($currentPage === 'news'):
        echo "News & Education"; ?>
      <?php elseif ($currentPage === 'admin'):
        echo "Admin"; ?>
      <?php else: 
        echo $currentPage;
       endif; ?>
    </p>

    <!-- Navigation -->
    <nav class="page-nav" id="site-nav" aria-label="Primary">
      <ul>
        <?php if ($currentPage === 'dogs'): ?>
          <li><a id="adoptionProcessBtn" class="my-btn btn-dogs">Adoption Process</a></li>
          <li><a href="<?= BASE_URL ?>/includes/download.php" target="_blank" class="my-btn btn-dogs">Adoption Application</a></li>
        <?php elseif ($currentPage === 'home'): ?>          
          <li><a href="<?= BASE_URL ?>/index.php?page=dogs" class="my-btn btn-dogs">Adopt your Bestie</a></li>
          <li><a href="#buyCoffee" target="_blank" class="my-btn btn-dogs">Buy our Coffee
                <!-- <img  src="<?= BASE_URL ?>/assets/images/coffeeCupHuistoe.jpg"
                      alt="Huistoe-Coffee"
                      width="30" height="30"> -->
              </a>
          </li>
          <!-- <li><a href="<?= BASE_URL ?>/index.php?page=volunteers" class="my-btn btn-dogs">Get Involved</a></li> -->
          <li><a href="#charityShop" class="my-btn btn-dogs">Charity Shop</a></li>
          <li><a href="<?= BASE_URL ?>/index.php?page=donations" class="my-btn btn-dogs">Donate/Sponsor/Buy</a></li>
        <?php elseif ($currentPage === 'donations'): ?>          
          <li><a href="#buyOurCoffee" class="my-btn btn-dogs">Buy Coffee</a></li>
          <li><a href="index.php?page=home#charityShop" class="my-btn btn-dogs">Charity Shop</a></li>
          <li><a href="#sponsorDog" class="my-btn btn-dogs">Sponsor a dog</a></li>
          <li><a href="https://payf.st/tgxv2"  target="_blank" class="my-btn btn-dogs">Donate via Payfast</a></li>
          <!-- <li><a href="https://payf.st/tgxv2"  target="_blank" class="my-btn btn-dogs">EFT details</a></li> -->
           <!-- Trigger button in header -->
          <li><a id="openPaymentModal" class="my-btn btn-dogs">EFT Details</a></li>


        <?php elseif ($currentPage === 'admin'): ?>          
          <li><a href="<?= BASE_URL ?>/index.php?page=edit_dogs" class="my-btn btn-dogs">dogs</a></li>
          <li><a href="<?= BASE_URL ?>/index.php?page=edit_news" class="my-btn btn-dogs">news</a></li>
          <li><a href="<?= BASE_URL ?>/index.php?page=view_stats" class="my-btn btn-dogs">stats</a></li>
        <?php else: ?>
          <li><a href="<?= BASE_URL ?>/index.php?page=dogs" class="my-btn btn-dogs">Adopt your Bestie</a></li>
          <li><a href="#buyCoffee" target="_blank" class="my-btn btn-dogs">Buy our Coffee
                <!-- <img  src="<?= BASE_URL ?>/assets/images/coffeeCupHuistoe.jpg"
                      alt="Huistoe-Coffee"
                      width="30" height="30"> -->
              </a>
          </li>
          <!-- <li><a href="<?= BASE_URL ?>/index.php?page=volunteers" class="my-btn btn-dogs">Get Involved</a></li> -->
          <li><a href="#charityShop" class="my-btn btn-dogs">Charity Shop</a></li>
          <li><a href="<?= BASE_URL ?>/index.php?page=donations" class="my-btn btn-dogs">Donate/Sponsor/Buy</a></li>
        <?php endif; ?>
      </ul>
    </nav>

    <!-- Mobile Menu Toggle -->
    <button class="menu-toggle" aria-label="Toggle menu" aria-controls="site-nav" aria-expanded="false">
      &#9776;
    </button>
  </div>
</header>