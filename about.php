<?php
include_once('./includes/connect.php');
include_once('./functions/common_functions.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrimeTextiles - About Us</title>
    <link rel="stylesheet" href="./assets/css/bootstrap.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <style>
        .about-section {
            padding: 80px 0;
            background-color: #f7f9fc;
        }
        .about-content {
            background: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .about-title {
            font-size: 2rem;
            font-weight: bold;
            color: #333333;
        }
        .about-text {
            font-size: 1rem;
            color: #555555;
            line-height: 1.8;
        }
        .btn-learn-more {
            background-color: #007bff;
            color: #ffffff;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 25px;
            transition: background 0.3s ease;
        }
        .btn-learn-more:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <!-- Promotional Bar -->
    <?php include_once('./includes/discount.php'); ?>

    <!-- Navbar -->
    <?php include_once('./includes/navbar.php'); ?>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="about-content text-center">
                        <h2 class="about-title mb-4">About PrimeTextiles</h2>
                        <p class="about-text mb-5">
                            Welcome to PrimeTextiles! We're passionate about bringing you the latest trends in fashion, 
                            crafted with quality and style in mind. Our mission is to provide an exceptional shopping experience 
                            for all fashion lovers by offering a diverse selection of apparel that suits every taste and occasion. 
                            <br><br>
                            From casual wear to formal attire, each piece in our collection is carefully chosen to ensure it meets 
                            the high standards we set for quality, style, and comfort. We believe that clothing is not just about 
                            fashion—it's a way to express yourself and feel confident. Join us on this journey and discover your unique style.
                        </p>
                        <a href="products.php" class="btn btn-learn-more">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include_once('./includes/footer.php'); ?>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
