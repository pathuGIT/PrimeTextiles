<?php
include_once("./includes/connect.php");
include_once("./functions/common_functions.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Products</title>
    <link rel="stylesheet" href="./assets/css/bootstrap.css" />
    <link rel="stylesheet" href="./assets/css/main.css" />
</head>

<body>
    <!-- upper-nav -->
    <?php include_once('./includes/discount.php'); ?>
    <!-- upper-nav -->
    <?php include_once("./includes/navbar.php"); ?>



    <!-- Start Product details  -->
    <div class="prod-details">
        <div class="container">
            <div class="sub-container pt-4 pb-4">

                <?php
                viewDetails();
                ?>
            </div>
        </div>
    </div>
    <!-- End Product details  -->

    <!-- Start Products  -->
    <div class="products">
        <div class="container">
            <div class="categ-header">
                <div class="sub-title">
                    <span class="shape"></span>
                    <span class="title">Related Products</span>
                </div>
                <h2>Discover More Products</h2>
            </div>
            <div class="row mb-3">
                <?php
                getProduct(3);
                cart();
                ?>
            </div>
            <div class="view d-flex justify-content-center align-items-center">
                <button onclick="location.href='./products.php'">View More Products</button>
            </div>
        </div>
    </div>

    <?php include_once("./includes/footer.php"); ?>
    <script src="./assets//js/bootstrap.bundle.js"></script>
    <script src="./assets/js/script.js"></script>
</body>

</html>