<?php
include_once('../includes/connect.php');
if(!isset($_SESSION['admin_username'])){
    echo "<script>window.open('./admin_login.php','_self');</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .table-responsive {
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Products</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </nav>
            </div>
            <a href="insert_product.php" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add New Product
            </a>
        </div>

        <!-- Search and Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="search" class="form-control" id="searchProduct" placeholder="Search products...">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="true">Active</option>
                            <option value="false">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Total Sold</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $get_product_query = "SELECT * FROM `products` ORDER BY product_id DESC";
                    $get_product_result = mysqli_query($con, $get_product_query);
                    $id_number = 1;
                    
                    if(mysqli_num_rows($get_product_result) > 0) {
                        while($row_fetch_products = mysqli_fetch_array($get_product_result)){
                            $product_id = $row_fetch_products['product_id'];
                            $product_title = $row_fetch_products['product_title'];
                            $product_image_one = $row_fetch_products['product_image_one'];
                            $product_price = $row_fetch_products['product_price'];
                            $product_status = $row_fetch_products['status'];
                            
                            // Get product total sold 
                            $get_count_sold = "SELECT SUM(quantity) as total_sold FROM `orders_pending` WHERE product_id = $product_id";
                            $get_count_sold_result = mysqli_query($con, $get_count_sold);
                            $sold_data = mysqli_fetch_assoc($get_count_sold_result);
                            $quantity_sold = $sold_data['total_sold'] ?? 0;
                            
                            $status_class = $product_status == 'true' ? 'bg-success' : 'bg-danger';
                            ?>
                            <tr>
                                <td><?php echo $id_number; ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="/PrimeTextiles/assets/images/products/<?php echo $product_image_one; ?>" 
                                             alt="<?php echo $product_title; ?>" 
                                             class="product-image me-3">
                                        <div>
                                            <h6 class="mb-0"><?php echo $product_title; ?></h6>
                                            <small class="text-muted">ID: <?php echo $product_id; ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>$<?php echo number_format($product_price, 2); ?></td>
                                <td><?php echo $quantity_sold; ?></td>
                                <td>
                                    <span class="status-badge <?php echo $status_class; ?> text-white">
                                        <?php echo $product_status == 'true' ? 'Active' : 'Inactive'; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="index.php?edit_product=<?php echo $product_id; ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal_<?php echo $product_id; ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal_<?php echo $product_id; ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm Deletion</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <i class="bi bi-exclamation-triangle text-warning display-3"></i>
                                                    <h4 class="mt-3">Are you sure?</h4>
                                                    <p class="text-muted">
                                                        Do you really want to delete "<?php echo $product_title; ?>"? 
                                                        This process cannot be undone.
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <a href="index.php?delete_product=<?php echo $product_id; ?>" 
                                                       class="btn btn-danger">
                                                        Delete Product
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            $id_number++;
                        }
                    } else {
                        echo '<tr><td colspan="6" class="text-center py-4">No products found</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Search functionality
        document.getElementById('searchProduct').addEventListener('keyup', function() {
            let searchValue = this.value.toLowerCase();
            let tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                let productName = row.querySelector('h6').textContent.toLowerCase();
                if(productName.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Status filter
        document.getElementById('statusFilter').addEventListener('change', function() {
            let filterValue = this.value;
            let tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                let status = row.querySelector('.status-badge').textContent.trim().toLowerCase();
                if(filterValue === '' || (filterValue === 'true' && status === 'active') || 
                   (filterValue === 'false' && status === 'inactive')) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>