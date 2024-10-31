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
</head>

<body>
    <!-- Promotional Bar -->
    <?php include_once('./includes/discount.php'); ?>

    <!-- Navbar -->
     <?php include_once('./includes/navbar.php'); ?>

    <!-- Hero Section -->
    <header class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 hero-text">
                    <h1>Elevate Your Style with the Latest Collection</h1>
                    <p>Discover exclusive styles and fresh fashion trends tailored just for you.</p>
                    <a href="./products.php" class="btn btn-primary btn-lg mt-3">Shop Now</a>
                </div>
                <div class="col-md-6 d-none d-md-block">
                    <img src="./assets/images/bg.png" alt="Fashion Hero" class="img-fluid">
                </div>
            </div>
        </div>
    </header>

    <section class="categories-section py-5">
    <div class="container">
        <h2 class="text-center mb-4">Browse By Category</h2>
        <div class="category-scroll overflow-hidden">
            <div class="category-scroll-inner d-flex">
                <?php
                // Fetch categories from the database
                $query = "SELECT category_id, category_title, banner_image FROM categories";
                $result = $con->query($query);

                // Check if there are categories to display
                if ($result->num_rows > 0) {
                    // Loop through each category
                    while ($row = $result->fetch_assoc()) {
                        $categoryName = $row['category_title'];
                        $bannerImage = $row['banner_image'] ? $row['banner_image'] : 'default-category.jpg';
                        $categoryId = $row['category_id'];
                        ?>
                        
                        <a href="products.php?category=<?php echo urlencode($categoryId); ?>" class="category-item text-decoration-none me-3">
                            <div class="category-card p-3 text-center">
                                <img src="<?php echo htmlspecialchars("assets/images/categories/".$bannerImage); ?>" alt="<?php echo htmlspecialchars($categoryName); ?>" class="img-fluid mb-2 rounded">
                                <h5><?php echo htmlspecialchars($categoryName); ?></h5>
                            </div>
                        </a>
                        
                        <?php
                    }
                } else {
                    echo "<p class='text-center'>No categories available.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</section>

<style>
    /* Scrollable container styling */
    .category-scroll {
        width: 100%; /* Full width */
        overflow: hidden; /* Hide overflow */
        position: relative; /* Relative position for the inner scroll */
    }

    /* Inner container for scrolling animation */
    .category-scroll-inner {
        display: flex; /* Flex display for horizontal alignment */
        animation: scrollLeft 20s linear infinite; /* Continuous scrolling */
    }

    /* Keyframes for infinite scrolling */
    @keyframes scrollLeft {
        from {
            transform: translateX(0);
        }
        to {
            transform: translateX(-50%); /* Adjust based on total items */
        }
    }

    /* Category card styling */
    .category-card {
        width: 300px;
        border-radius: 10px;
        background-color: #f8f9fa;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
    }

    /* Image styling */
    .category-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
    }

    /* Text styling */
    .category-card h5 {
        font-weight: 600;
        color: #333;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const categoryScroll = document.querySelector(".category-scroll-inner");
        const items = Array.from(document.querySelectorAll(".category-item"));
        
        // Clone items to create seamless infinite scroll
        items.forEach(item => {
            const clone = item.cloneNode(true);
            categoryScroll.appendChild(clone); // Append clone to the end
        });

        // Dynamically adjust animation duration based on item count
        const totalItems = items.length * 2; // Original + cloned items
        const animationDuration = totalItems * 5; // Adjust speed
        categoryScroll.style.animationDuration = animationDuration + "s";
    });
</script>

<section class="brands-section py-5">
    <div class="container">
        <h2 class="text-center mb-4">Browse By Brand</h2>
        <div class="brand-scroll overflow-hidden">
            <div class="brand-scroll-inner d-flex">
                <?php
                // Fetch brands from the database
                $query = "SELECT brand_id, brand_title, brand_logo FROM brands";
                $result = $con->query($query);

                // Check if there are brands to display
                if ($result->num_rows > 0) {
                    // Loop through each brand
                    while ($row = $result->fetch_assoc()) {
                        $brandName = $row['brand_title'];
                        $brandLogo = $row['brand_logo'] ? $row['brand_logo'] : 'default-brand.jpg';
                        $brandId = $row['brand_id'];
                        ?>
                        
                        <a href="products.php?brand=<?php echo urlencode($brandId); ?>" class="brand-item text-decoration-none me-3">
                            <div class="brand-card p-3 text-center">
                                <img src="<?php echo htmlspecialchars("assets/images/brands/".$brandLogo); ?>" alt="<?php echo htmlspecialchars($brandName); ?>" class="img-fluid mb-2 rounded">
                                <h5><?php echo htmlspecialchars($brandName); ?></h5>
                            </div>
                        </a>
                        
                        <?php
                    }
                } else {
                    echo "<p class='text-center'>No brands available.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</section>

<style>
    /* Scrollable container styling */
    .brand-scroll {
        width: 100%; /* Full width */
        overflow: hidden; /* Hide overflow */
        position: relative; /* Relative position for the inner scroll */
    }

    /* Inner container for scrolling animation */
    .brand-scroll-inner {
        display: flex; /* Flex display for horizontal alignment */
        animation: scrollLeft 20s linear infinite; /* Continuous scrolling */
    }

    /* Keyframes for infinite scrolling */
    @keyframes scrollLeft {
        from {
            transform: translateX(0);
        }
        to {
            transform: translateX(-50%); /* Adjust based on total items */
        }
    }

    /* Brand card styling */
    .brand-card {
        width: 300px; /* Adjust width as needed */
        border-radius: 10px;
        background-color: #f8f9fa;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .brand-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
    }

    /* Image styling */
    .brand-card img {
        width: 100%;
        height: 200px; /* Adjust height as needed */
        object-fit: cover;
        border-radius: 8px;
    }

    /* Text styling */
    .brand-card h5 {
        font-weight: 600;
        color: #333;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const brandScroll = document.querySelector(".brand-scroll-inner");
        const items = Array.from(document.querySelectorAll(".brand-item"));
        
        // Clone items to create seamless infinite scroll
        items.forEach(item => {
            const clone = item.cloneNode(true);
            brandScroll.appendChild(clone); // Append clone to the end
        });

        // Dynamically adjust animation duration based on item count
        const totalItems = items.length * 2; // Original + cloned items
        const animationDuration = totalItems * 5; // Adjust speed
        brandScroll.style.animationDuration = animationDuration + "s";
    });
</script>

    <!-- Footer -->
    <?php include_once('./includes/footer.php'); ?>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
