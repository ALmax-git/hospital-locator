<!DOCTYPE html>
<html lang="en">
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Hospital Locator</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

  <header id="header" class="header sticky-top">



    <div class="branding d-flex align-items-cente">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
          <h1 class="sitename">Hospital Locator</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="./" class="<?php echo isset($_GET['web']) && $_GET['web'] == '' ? 'active' : ''; ?>">Home</a></li>
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Dropdown
              </button>
              <ul class="dropdown-menu dropdown-menu-dark">
                <li><a class="dropdown-item active" href="#">Action</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Separated link</a></li>
              </ul>
            </div>
            <li><a class="<?php echo isset($_GET['web']) && $_GET['web'] == 'hospitals' ? 'active' : ''; ?>" href="./?web=hospitals">Hospitals</a></li>
            <li><a class="<?php echo isset($_GET['web']) && $_GET['web'] == 'about' ? 'active' : ''; ?>" href="./?web=about">About</a></li>
            <li><a class="<?php echo isset($_GET['web']) && $_GET['web'] == 'team' ? 'active' : ''; ?>" href="./?web=team">Team</a></li>

            <li><a class="<?php echo isset($_GET['web']) && $_GET['web'] == 'contact' ? 'active' : ''; ?>" href="./?web=contact">Contact</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

      </div>

    </div>

  </header>

  <main class="main">
    <?php if (!isset($_GET['web'])): ?>
      <!-- Hero Section -->
      <section id="hero" class="hero section light-background">

        <div class="container">
          <div class="row gy-4">
            <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">

              <?php if (!isset($_GET['web'])): ?>
                <h1>Welcome to <span>Hospital Locator</span></h1>
                <p>Find The nearest Hospital in Maiduguri with ease.</p>
                <div class="d-flex">
                  <a href="#about" class="btn-get-started">Get Started</a>
                </div>
              <?php else: ?>
                <?php if ($_GET['web'] == 'hospitals'): ?>
                  <div>
                    <input type="text" id="location-input" class="form-control" placeholder="Search for a hospital...">
                    <br>
                    <button id="search-button" class="form-control">Search</button>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            </div>
            <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
              <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="assets/img/clients/img-1.jpg" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="assets/img/clients/img-2.jpg" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="assets/img/clients/img-3.jpg" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="assets/img/clients/img-4.jpg" class="d-block w-100" alt="...">
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
            </div>
          </div>
        </div>

      </section>
    <?php endif; ?>
    <?php
    if (isset($_GET['web'])) {
      switch ($_GET['web']) {
        case "about":
          include "about.php";
          break;
        case "contact":
          include "contact.php";
          break;
        case "hospitals":
          include "map.php";
          break;
        case "team":
          include "team.php";
          include "statistic.php";
          break;
        default:
          include "about.php";
          include "statistic.php";
          break;
      }
    } else {
      include "statistic.php";
      include "about.php";
    }
    ?>



  </main>

  <footer id="footer" class="footer">



    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="d-flex align-items-center">
            <span class="sitename">Hospital Locator</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Maiduguri, Borno State</p>
            <p>Ramat Polytechnic, 606282</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+234 81 6514 1519</span></p>
            <p><strong>Email:</strong> <span>alimustaphashettima@gmail.com</span></p>
          </div>
        </div>


        <div class="col-lg-4 col-md-12">
          <h4>Follow Us</h4>
          <div class="social-links d-flex">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Hospital Locator</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Designed by <a href="https://github.com/ALmax-git">ALmax</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
  </div>

  <?php if (isset($_GET['web']) && $_GET['web'] == 'hospitals') {
    include 'script.php';
  } ?>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
