<?php
include_once('../includes/connect.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.open('./admin_login.php', '_self');</script>";
    exit();
}

$success_message = '';
$error_message = '';

if (isset($_POST['insert_user'])) {
    $admin_name = mysqli_real_escape_string($con, $_POST['admin_name']);
    $admin_email = mysqli_real_escape_string($con, $_POST['admin_email']);
    $admin_password = password_hash($_POST['admin_password'], PASSWORD_DEFAULT); // Hash the password

    // Check if email already exists
    $select_query = "SELECT * FROM `admin_table` WHERE admin_name = '$admin_name'";
    $select_result = mysqli_query($con, $select_query);

    if (mysqli_num_rows($select_result) > 0) {
        $error_message = "Username already exists in the database.";
    } else {
        // Handle admin image upload
        $admin_image = '';
        if (isset($_FILES['admin_image']) && $_FILES['admin_image']['error'] === 0) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
            $max_size = 5 * 1024 * 1024; // 5MB

            if (!in_array($_FILES['admin_image']['type'], $allowed_types)) {
                $error_message = "Only JPG, PNG, and WebP images are allowed.";
            } elseif ($_FILES['admin_image']['size'] > $max_size) {
                $error_message = "Image size should be less than 5MB.";
            } else {
                $file_extension = pathinfo($_FILES['admin_image']['name'], PATHINFO_EXTENSION);
                $admin_image = 'admin_' . time() . '.' . $file_extension;
                $upload_path = "./admin_images/" . $admin_image;

                if (!move_uploaded_file($_FILES['admin_image']['tmp_name'], $upload_path)) {
                    $error_message = "Failed to upload image. Please try again.";
                }
            }
        }

        if (empty($error_message)) {
            $insert_query = "INSERT INTO `admin_table` (admin_name, admin_email, admin_image, admin_password) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $insert_query);
            mysqli_stmt_bind_param($stmt, "ssss", $admin_name, $admin_email, $admin_image, $admin_password);

            if (mysqli_stmt_execute($stmt)) {
                $success_message = "User has been inserted successfully!";
            } else {
                $error_message = "Failed to insert user. Please try again.";
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
    <title>Insert User - Admin Dashboard</title>
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
                        <h2 class="mb-1">Insert User</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Add User</li>
                            </ol>
                        </nav>
                    </div>
                    <a href="index.php?list_users" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left"></i> Back to Users
                    </a>
                </div>

                <?php if ($success_message): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?php echo $success_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?php echo $error_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <div class="form-container">
                    <form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="mb-4">
                            <label for="admin_name" class="form-label">Name</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       id="admin_name" 
                                       name="admin_name" 
                                       placeholder="Enter name" 
                                       required>
                                <div class="invalid-feedback">
                                    Please provide a name.
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="admin_email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" 
                                       class="form-control" 
                                       id="admin_email" 
                                       name="admin_email" 
                                       placeholder="Enter email" 
                                       required>
                                <div class="invalid-feedback">
                                    Please provide an email.
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="admin_password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" 
                                       class="form-control" 
                                       id="admin_password" 
                                       name="admin_password" 
                                       placeholder="Enter password" 
                                       required>
                                <div class="invalid-feedback">
                                    Please provide a password.
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="admin_image" class="form-label">Profile Image</label>
                            <div class="image-preview mb-3" id="imagePreview">
                                <div class="text-muted">
                                    <i class="bi bi-image fs-2 d-block mb-2"></i>
                                    Preview will appear here
                                </div>
                            </div>
                            <input type="file" 
                                   class="form-control" 
                                   id="admin_image" 
                                   name="admin_image" 
                                   accept="image/jpeg,image/png,image/webp"
                                   onchange="previewImage(this)">
                            <div class="form-text">
                                Max size: 5MB. Supported formats: JPG, PNG, WebP.
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="insert_user" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Insert User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
                    </div>
                `;
            }
        }
    </script>
</body>
</html>
