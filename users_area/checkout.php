<?php
include_once('../includes/connect.php');
include_once('../functions/common_functions.php');
session_start();

// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Checkout Page</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
</head>

<body>
    <!-- upper-nav -->
    <!-- Start NavBar -->
    <?php include_once('../includes/navbar.php'); ?>
    <!-- End NavBar -->

    <!-- Start Landing Section -->
    <div class="landing">
        <div class="container">
            <div class="row m-0">
                <?php
                    // Conditionally include login or payment page
                    if(!isset($_SESSION['username'])){
                        include_once('user_login.php');
                    } else {
                        include_once('payment.php');
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- End Landing Section -->

    <?php include_once('../includes/footer.php'); ?>
    <script src="../assets/js/bootstrap.bundle.js"></script>
</body>

</html>
