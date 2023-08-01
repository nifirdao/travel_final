<?php
session_start();
define("APPURL", "http://localhost/travel");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  

    <!-- Bootstrap core CSS -->
    <link href="<?php echo APPURL; ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="<?php echo APPURL; ?>/assets/css/fontawesome.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/assets/css/templatemo-woox-travel.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/assets/css/owl.css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <!-- Your custom CSS -->
    <link rel="stylesheet" href="<?php echo APPURL; ?>/assets/css/custom.css">
</head>
<body>
    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="index.php" class="logo">
                            <img src="assets/images/logos.png" alt="" width="150" height="50">
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="index.php" class="active">Home</a></li>
                            <li><a href="about.php">About</a></li>
                            <li><a href="recommendation.php">Recommendation</a></li>
                            <?php if(isset($_SESSION['username'])) :?> 
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php echo $_SESSION['username']; ?>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item text-black" href="#">Action</a></li>
                                        <li><a class="dropdown-item text-black" href="#">Another action</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-black" href="<?php echo APPURL; ?>/auth/logout.php">logout</a></li>
                                    </ul>
                                </li>
                            <?php else : ?>  
                                <li><a href="<?php echo APPURL; ?>/auth/login.php">Login</a></li>
                                <li><a href="<?php echo APPURL; ?>/auth/register.php">Register</a></li> 
                            <?php endif; ?>
                        </ul>   
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <!-- ... ส่วนอื่น ๆ ใน header.php ที่คุณต้องการให้ปรากฎในทุกหน้า ... -->

    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo APPURL; ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo APPURL; ?>/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo APPURL; ?>/assets/js/isotope.min.js"></script>
    <script src="<?php echo APPURL; ?>/assets/js/owl-carousel.js"></script>
    <script src="<?php echo APPURL; ?>/assets/js/wow.js"></script>
    <script src="<?php echo APPURL; ?>/assets/js/tabs.js"></script>
    <script src="<?php echo APPURL; ?>/assets/js/popup.js"></script>
    <script src="<?php echo APPURL; ?>/assets/js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script> 

   
</body>
</html>
