<?php
include_once('../includes/connect.php');

// Check if admin is logged in
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
    <title>View Categories - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .table-responsive {
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .category-banner {
            width: 120px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }
        .search-box {
            max-width: 300px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Categories</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Categories</li>
                    </ol>
                </nav>
            </div>
            <a href="index.php?insert_category" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add New Category
            </a>
        </div>

        <!-- Search Box -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="search-box">
                            <input type="search" 
                                   class="form-control" 
                                   id="searchCategory" 
                                   placeholder="Search categories...">
                        </div>
                    </div>
                    <div class="col-md-8 text-md-end">
                        <span class="text-muted">Total Categories: 
                            <?php
                            $count_query = "SELECT COUNT(*) as total FROM categories";
                            $count_result = mysqli_query($con, $count_query);
                            $count_data = mysqli_fetch_assoc($count_result);
                            echo $count_data['total'];
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Banner</th>
                        <th scope="col">Category Title</th>
                        <th scope="col">Products</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $get_category_query = "SELECT c.*, COUNT(p.product_id) as product_count 
                                         FROM categories c 
                                         LEFT JOIN products p ON c.category_id = p.category_id 
                                         GROUP BY c.category_id 
                                         ORDER BY c.category_title";
                    $get_category_result = mysqli_query($con, $get_category_query);
                    $id_number = 1;

                    if(mysqli_num_rows($get_category_result) > 0) {
                        while($row = mysqli_fetch_array($get_category_result)){
                            $category_id = $row['category_id'];
                            $category_title = $row['category_title'];
                            $banner_image = $row['banner_image'];
                            $product_count = $row['product_count'];
                            ?>
                            <tr>
                                <td><?php echo $id_number; ?></td>
                                <td>
                                    <?php if($banner_image): ?>
                                        <img src="../assets/images/categories/<?php echo $banner_image; ?>" 
                                             alt="<?php echo $category_title; ?>" 
                                             class="category-banner">
                                    <?php else: ?>
                                        <div class="category-banner bg-light d-flex align-items-center justify-content-center">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <h6 class="mb-0"><?php echo $category_title; ?></h6>
                                    <small class="text-muted">ID: <?php echo $category_id; ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-primary rounded-pill">
                                        <?php echo $product_count; ?> Products
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="index.php?edit_category=<?php echo $category_id; ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal_<?php echo $category_id; ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal_<?php echo $category_id; ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header border-0">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center pb-4">
                                                    <i class="bi bi-exclamation-triangle text-warning display-3"></i>
                                                    <h4 class="mt-3">Delete Category?</h4>
                                                    <p class="text-muted mb-0">
                                                        Are you sure you want to delete "<?php echo $category_title; ?>"?
                                                    </p>
                                                    <p class="text-muted">
                                                        This will also affect <?php echo $product_count; ?> products.
                                                    </p>
                                                    <div class="d-flex gap-2 justify-content-center mt-4">
                                                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                                                            Cancel
                                                        </button>
                                                        <a href="index.php?delete_category=<?php echo $category_id; ?>" 
                                                           class="btn btn-danger px-4">
                                                            Delete Category
                                                        </a>
                                                    </div>
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
                        echo '<tr><td colspan="5" class="text-center py-4">No categories found</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Search functionality
        document.getElementById('searchCategory').addEventListener('keyup', function() {
            let searchValue = this.value.toLowerCase();
            let tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                let categoryTitle = row.querySelector('h6').textContent.toLowerCase();
                if(categoryTitle.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>