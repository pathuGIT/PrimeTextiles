<?php
include_once('../includes/connect.php');

// Check if admin is logged in
if(!isset($_SESSION['admin_username'])){
    echo "<script>window.open('./admin_login.php','_self');</script>";
    exit();
}

$success_message = '';
$error_message = '';

if(isset($_POST['insert_brand'])){
    $brand_title = mysqli_real_escape_string($con, $_POST['brand_title']);
    
    // Check if brand exists
    $select_query = "SELECT * FROM `brands` WHERE brand_title = '$brand_title'";
    $select_result = mysqli_query($con, $select_query);
    
    if(mysqli_num_rows($select_result) > 0){
        $error_message = "This brand already exists in the database.";
    } else {
        // Handle logo upload
        $brand_logo = '';
        if(isset($_FILES['brand_logo']) && $_FILES['brand_logo']['error'] === 0) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'];
            $max_size = 2 * 1024 * 1024; // 2MB
            
            if(!in_array($_FILES['brand_logo']['type'], $allowed_types)) {
                $error_message = "Only JPG, PNG, WebP, and SVG files are allowed.";
            } elseif($_FILES['brand_logo']['size'] > $max_size) {
                $error_message = "Logo size should be less than 2MB.";
            } else {
                $file_extension = pathinfo($_FILES['brand_logo']['name'], PATHINFO_EXTENSION);
                $brand_logo = 'brand_' . time() . '.' . $file_extension;
                $upload_path = "../assets/images/brands/" . $brand_logo;
                
                if(!move_uploaded_file($_FILES['brand_logo']['tmp_name'], $upload_path)) {
                    $error_message = "Failed to upload logo. Please try again.";
                }
            }
        }
        
        if(empty($error_message)) {
            $insert_query = "INSERT INTO `brands` (brand_title, brand_logo) VALUES (?, ?)";
            $stmt = mysqli_prepare($con, $insert_query);
            mysqli_stmt_bind_param($stmt, "ss", $brand_title, $brand_logo);
            
            if(mysqli_stmt_execute($stmt)) {
                $success_message = "Brand has been inserted successfully!";
            } else {
                $error_message = "Failed to insert brand. Please try again.";
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
    <title>Insert Brand - Admin Dashboard</title>
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
        .logo-preview {
            width: 150px;
            height: 150px;
            border: 2px dashed #ddd;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin: 0 auto;
        }
        .logo-preview img {
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
                        <h2 class="mb-1">Insert Brand</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Insert Brand</li>
                            </ol>
                        </nav>
                    </div>
                    <a href="index.php?view_brands" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left"></i> Back to Brands
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
                            <label for="brand_title" class="form-label">Brand Title</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-tag"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       id="brand_title" 
                                       name="brand_title" 
                                       placeholder="Enter brand title"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide a brand title.
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 text-center">
                            <label for="brand_logo" class="form-label d-block">Brand Logo</label>
                            <div class="logo-preview mb-3" id="logoPreview">
                                <div class="text-muted">
                                    <i class="bi bi-image fs-2 d-block mb-2"></i>
                                    Preview
                                </div>
                            </div>
                            <input type="file" 
                                   class="form-control" 
                                   id="brand_logo" 
                                   name="brand_logo" 
                                   accept="image/jpeg,image/png,image/webp,image/svg+xml"
                                   onchange="previewLogo(this)">
                            <div class="form-text">
                                Recommended size: 200x200px. Max size: 2MB. Supported formats: JPG, PNG, WebP, SVG
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="insert_brand" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Insert Brand
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Logo preview functionality
        function previewLogo(input) {
            const preview = document.getElementById('logoPreview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Logo Preview">`;
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.innerHTML = `
                    <div class="text-muted">
                        <i class="bi bi-image fs-2 d-block mb-2"></i>
                        Preview
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