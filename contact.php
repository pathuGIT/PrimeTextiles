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
    <title>PrimeTextiles - Home</title>
    <link rel="stylesheet" href="./assets/css/bootstrap.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <style>
        .form-control, .btn-send {
            border-radius: 15px;
        }
        .btn-send {
            background-color: #007bff;
            color: #ffffff;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            transition: background 0.3s ease;
        }
        .btn-send:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <!-- Promotional Bar -->
    <?php include_once('./includes/discount.php'); ?>

    <!-- Navbar -->
     <?php include_once('./includes/navbar.php'); ?>

     <section class="contact-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <h2 class="text-center mb-4">Get in Touch</h2>
                    <p class="text-center mb-5 text-muted">We'd love to hear from you! Whether you have a question about our products, pricing, or anything else, our team is ready to answer all your questions.</p>

                    <form action="process_contact.php" method="POST" class="contact-form">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="Your Name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="Your Email">
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required placeholder="Type your message here..."></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-send">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>



    <!-- Footer -->
    <?php include_once('./includes/footer.php'); ?>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
