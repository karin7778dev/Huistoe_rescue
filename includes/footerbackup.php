<?php
// footer.php
?>

<?php
// includes/footer.php
require_once __DIR__ . '/config.php';
?>
  </main>

  <footer class="page-footer fixed-footer">
    <div class="footer-bar">

      <!-- Logo -->
      <a href="<?= BASE_URL ?>/index.php?page=home" class="site-logo">
        <img
          src="<?= BASE_URL ?>/assets/images/Huistoe_logo.jpg"
          alt="Huistoe Rescue"
          width="75"
          height="75"
        >
      </a>
      <?php if (!empty($_SESSION['is_admin'])):
        $counterFile = dirname(__DIR__) . '/includes/counter.txt';
        $visitCount = file_exists($counterFile) ? file_get_contents($counterFile) : '0';
        echo "Total visits: " . htmlspecialchars($visitCount);
      endif; ?>

      <!-- Nav Buttons -->
      <nav aria-label="Footer navigation" class="footer-nav">
      <!-- Small screen toggle -->
      <button class="footer-menu-toggle all-toggle" aria-expanded="false" aria-controls="footerMenuAll">
        Menu &#9662;
      </button>

      <ul class="footer-menu footer-menu-main">
        <li><a href="<?= BASE_URL ?>/index.php?page=home">Home</a></li>
        <li><a href="<?= BASE_URL ?>/index.php?page=dogs">Adopt</a></li>   
        <li><a href="<?= BASE_URL ?>/index.php?page=volunteers">Volunteer</a></li>   
        <li><a href="<?= BASE_URL ?>/index.php?page=sponsors">Donate</a></li>
        <?php if (!empty($_SESSION['is_admin'])): ?>
    <li><a href="<?= BASE_URL ?>/index.php?page=admin">Admin</a></li>
<?php endif; ?>
      </ul>

      <!-- Medium screen "More" dropdown -->
      <div class="footer-more-wrapper">
        <button class="footer-menu-toggle more-toggle" aria-expanded="false" aria-controls="footerMenuMore">
          More &#9662;
        </button>
        <ul class="footer-menu footer-menu-more" id="footerMenuMore">
        <li><a href="<?= BASE_URL ?>/index.php?page=sponsors">Sponsors</a></li>
        <li><a href="<?= BASE_URL ?>/index.php?page=news">News & Education</a></li>    
        <li><a href="<?= BASE_URL ?>/index.php?page=about">About Us</a></li>
        <li><a href="<?= BASE_URL ?>/index.php?page=contact">Contact Us</a></li>
        <?php if (!empty($_SESSION['is_admin'])): ?>
              <li><a href="<?= BASE_URL ?>/index.php?page=admin">Admin</a></li>
        <?php endif; ?>
        </ul>
      </div>

      <!-- Small screen full menu -->
      <ul class="footer-menu footer-menu-all" id="footerMenuAll">
        <li><a href="<?= BASE_URL ?>/index.php?page=home">Home</a></li>
        <li><a href="<?= BASE_URL ?>/index.php?page=dogs">Our Dogs</a></li> 
        <li><a href="<?= BASE_URL ?>/index.php?page=volunteers">Volunteer</a></li>   
        <li><a href="<?= BASE_URL ?>/index.php?page=sponsors">Donate</a></li>
        <li><a href="<?= BASE_URL ?>/index.php?page=sponsors">Sponsors</a></li>
        <li><a href="<?= BASE_URL ?>/index.php?page=news">News & Education</a></li>    
        <li><a href="<?= BASE_URL ?>/index.php?page=about">About Us</a></li>
        <li><a href="<?= BASE_URL ?>/index.php?page=contact">Contact Us</a></li>
        <?php if (!empty($_SESSION['is_admin'])): ?>
    <li><a href="<?= BASE_URL ?>/index.php?page=admin">Admin</a></li>
<?php endif; ?>

      </ul>
    </nav>

    </div>
  </footer>
</body>
</html>