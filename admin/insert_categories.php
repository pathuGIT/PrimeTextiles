<?php
include_once('../includes/connect.php');

// Check if admin is logged in
if(!isset($_SESSION['admin_username'])){
    echo "<script>window.open('./admin_login.php','_self');</script>";
    exit();
}

$success_message = '';
$error_message = '';

if (isset($_POST['insert_category'])) {
    $category_title = mysqli_real_escape_string($con, $_POST['category_title']);
    
    // Check if category exists
    $select_query = "SELECT * FROM `categories` WHERE category_title = '$category_title'";
    $select_result = mysqli_query($con, $select_query);
    
    if (mysqli_num_rows($select_result) > 0) {
        $error_message = "Category already exists in database.";
    } else {
        // Handle banner image upload
        $banner_image = '';
        if(isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] === 0) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
            $max_size = 5 * 1024 * 1024; // 5MB
            
            if (!in_array($_FILES['banner_image']['type'], $allowed_types)) {
                $error_message = "Only JPG, PNG and WebP images are allowed.";
            } elseif ($_FILES['banner_image']['size'] > $max_size) {
                $error_message = "Image size should be less than 5MB.";
            } else {
                $file_extension = pathinfo($_FILES['banner_image']['name'], PATHINFO_EXTENSION);
                $banner_image = 'category_' . time() . '.' . $file_extension;
                $upload_path = "../assets/images/categories/" . $banner_image;
                
                if (!move_uploaded_file($_FILES['banner_image']['tmp_name'], $upload_path)) {
                    $error_message = "Failed to upload image. Please try again.";
                }
            }
        }
        
        if (empty($error_message)) {
            $insert_query = "INSERT INTO `categories` (category_title, banner_image) VALUES (?, ?)";
            $stmt = mysqli_prepare($con, $insert_query);
            mysqli_stmt_bind_param($stmt, "ss", $category_title, $banner_image);
            
            if (mysqli_stmt_execute($stmt)) {
                $success_message = "Category has been inserted successfully!";
            } else {
                $error_message = "Failed to insert category. Please try again.";
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Category - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .image-preview {
            max-width: 100%;
            height: 200px;
            border: 2px dashed #ddd;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .image-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Insert Category</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Insert Category</li>
                            </ol>
                        </nav>
                    </div>
                    <a href="index.php?view_categories" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left"></i> Back to Categories
                    </a>
                </div>

                <?php if($success_message): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?php echo $success_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <?php if($error_message): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?php echo $error_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <div class="form-container">
                    <form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="mb-4">
                            <label for="category_title" class="form-label">Category Title</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-tag"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       id="category_title" 
                                       name="category_title" 
                                       placeholder="Enter category title"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide a category title.
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="banner_image" class="form-label">Banner Image</label>
                            <div class="image-preview mb-3" id="imagePreview">
                                <div class="text-muted">
                                    <i class="bi bi-image fs-2 d-block mb-2"></i>
                                    Preview will appear here
                                </div>
                            </div>
                            <input type="file" 
                                   class="form-control" 
                                   id="banner_image" 
                                   name="banner_image" 
                                   accept="image/jpeg,image/png,image/webp"
                                   onchange="previewImage(this)">
                            <div class="form-text">
                                Recommended size: 1200x300px. Max size: 5MB. Supported formats: JPG, PNG, WebP
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="insert_category" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Insert Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Image preview functionality
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.innerHTML = `
                    <div class="text-muted">
                        <i class="bi bi-image fs-2 d-block mb-2"></i>
                        Preview will appear here
                    </div>`;
            }
        }

        // Form validation
        (function () {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html>