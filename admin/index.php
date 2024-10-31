<?php
include_once('../includes/connect.php');
include_once('../functions/common_functions.php');
session_start();
if (isset($_SESSION['admin_username'])) {
    $admin_name = $_SESSION['admin_username'];
    $get_admin_data = "SELECT * FROM `admin_table` WHERE admin_name = '$admin_name'";
    $get_admin_result = mysqli_query($con, $get_admin_data);
    $row_fetch_admin_data = mysqli_fetch_array($get_admin_result);
    $admin_name = $row_fetch_admin_data['admin_name'];
    $admin_image = $row_fetch_admin_data['admin_image'];
} else {
    echo "<script>window.open('./admin_login.php','_self');</script>";
}

// Total Products Query
$total_products_query = "SELECT COUNT(*) AS total_products FROM `products`";
$total_products_result = mysqli_query($con, $total_products_query);
$total_products = mysqli_fetch_assoc($total_products_result)['total_products'];

// Total Orders Query
$total_orders_query = "SELECT COUNT(*) AS total_orders FROM `user_orders`";
$total_orders_result = mysqli_query($con, $total_orders_query);
$total_orders = mysqli_fetch_assoc($total_orders_result)['total_orders'];

// Total Users Query
$total_users_query = "SELECT COUNT(*) AS total_users FROM `user_table`";
$total_users_result = mysqli_query($con, $total_users_query);
$total_users = mysqli_fetch_assoc($total_users_result)['total_users'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }

        .sidebar .nav-link {
            color: #fff;
        }

        .sidebar .nav-link:hover {
            background-color: #495057;
        }

        .main-content {
            padding-top: 20px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            border-radius: 10px 10px 0 0;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <img src="./admin_images/<?php echo $admin_image; ?>" class="img-fluid rounded-circle mb-3" alt="Admin Photo" style="width: 100px; height: 100px; object-fit: cover;">
                        <h5 class="text-white"><?php echo $admin_name; ?></h5>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="./index.php">
                                <i class="bi bi-house-door me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./insert_product.php">
                                <i class="bi bi-plus-circle me-2"></i>
                                Insert Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?view_products">
                                <i class="bi bi-grid me-2"></i>
                                View Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?insert_category">
                                <i class="bi bi-tags me-2"></i>
                                Insert Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?view_categories">
                                <i class="bi bi-list-ul me-2"></i>
                                View Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?insert_brand">
                                <i class="bi bi-bookmark-plus me-2"></i>
                                Insert Brands
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?view_brands">
                                <i class="bi bi-bookmarks me-2"></i>
                                View Brands
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?list_orders">
                                <i class="bi bi-bag-check me-2"></i>
                                All Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?list_payments">
                                <i class="bi bi-credit-card me-2"></i>
                                All Payments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?add_users">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-add me-2" viewBox="0 0 16 16">
                                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                                    <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z" />
                                </svg>
                                Add admins
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?list_users">
                                <i class="bi bi-people me-2"></i>
                                List Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./admin_logout.php">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="exportPDF()">Export</button>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Overview -->
                <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
                    <div class="col">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <h5 class="card-title">Total Products</h5>
                                <p class="card-text display-6"><?php echo $total_products; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <h5 class="card-title">Total Orders</h5>
                                <p class="card-text display-6"><?php echo $total_orders; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-white bg-info">
                            <div class="card-body">
                                <h5 class="card-title">Total Users</h5>
                                <p class="card-text display-6"><?php echo $total_users; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Content -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Manage Details</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_GET['insert_category'])) {
                            include_once('./insert_categories.php');
                        }
                        if (isset($_GET['insert_brand'])) {
                            include_once('./insert_brands.php');
                        }
                        if (isset($_GET['view_products'])) {
                            include_once('./view_products.php');
                        }
                        if (isset($_GET['edit_product'])) {
                            include_once('./edit_product.php');
                        }
                        if (isset($_GET['delete_product'])) {
                            include_once('./delete_product.php');
                        }
                        if (isset($_GET['view_categories'])) {
                            include_once('./view_categories.php');
                        }
                        if (isset($_GET['edit_category'])) {
                            include_once('./edit_category.php');
                        }
                        if (isset($_GET['delete_category'])) {
                            include_once('./delete_category.php');
                        }
                        if (isset($_GET['view_brands'])) {
                            include_once('./view_brands.php');
                        }
                        if (isset($_GET['edit_brand'])) {
                            include_once('./edit_brand.php');
                        }
                        if (isset($_GET['delete_brand'])) {
                            include_once('./delete_brand.php');
                        }
                        if (isset($_GET['list_orders'])) {
                            include_once('./list_orders.php');
                        }
                        if (isset($_GET['delete_order'])) {
                            include_once('./delete_order.php');
                        }
                        if (isset($_GET['list_payments'])) {
                            include_once('./list_payments.php');
                        }
                        if (isset($_GET['delete_payment'])) {
                            include_once('./delete_payment.php');
                        }
                        if (isset($_GET['add_users'])) {
                            include_once('./add_users.php');
                        }
                        if (isset($_GET['list_users'])) {
                            include_once('./list_users.php');
                        }
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        async function exportPDF() {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF();
        const content = document.querySelector('.main-content'); // Adjust selector as needed

        // Capture content as image
        await html2canvas(content, { scale: 2 }).then((canvas) => {
            const imgData = canvas.toDataURL('image/png');
            const imgWidth = 190; // Fit width within A4
            const imgHeight = (canvas.height * imgWidth) / canvas.width;

            // Add image to PDF and save
            pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);
            pdf.save("dashboard-export.pdf");
        });
    }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>