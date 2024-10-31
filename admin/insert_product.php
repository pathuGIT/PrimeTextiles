<?php
include_once('../includes/connect.php');
define('BASE_PATH', dirname(__DIR__));
if(isset($_POST['insert_product'])){
    $product_title=$_POST['product_title'];
    $product_description=$_POST['product_description'];
    $product_keywords=$_POST['product_keywords'];
    $product_category=$_POST['product_category'];
    $product_brand=$_POST['product_brand'];
    $product_price=$_POST['product_price'];
    $product_status='true';
    //access images
    $product_image_one=$_FILES['product_image_one']['name'];
    $product_image_two=$_FILES['product_image_two']['name'];
    $product_image_three=$_FILES['product_image_three']['name'];
    //access images tmp name
    $temp_image_one=$_FILES['product_image_one']['tmp_name'];
    $temp_image_two=$_FILES['product_image_two']['tmp_name'];
    $temp_image_three=$_FILES['product_image_three']['tmp_name'];
    //checking empty condition
    if($product_title == '' || $product_description == '' || $product_keywords == '' || $product_category == '' || $product_brand == '' || empty($product_price) || empty($product_image_one) || empty($product_image_two) || empty($product_image_three)){
        echo "<script>alert(\"Fields should not be empty\");</script>";
        exit();
    }else{
        //move folders
        // echo BASE_PATH . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "product" . DIRECTORY_SEPARATOR;
        // move_uploaded_file($temp_image_one, BASE_PATH . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "product" . DIRECTORY_SEPARATOR . $product_image_one);
        // move_uploaded_file($temp_image_two, BASE_PATH . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "product" . DIRECTORY_SEPARATOR . $product_image_two);
        // move_uploaded_file($temp_image_three, BASE_PATH . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "product" . DIRECTORY_SEPARATOR . $product_image_three);

        
        if (!move_uploaded_file($temp_image_one, BASE_PATH . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . $product_image_one)) {
            echo "Failed to upload product image one.";
        }
        if (!move_uploaded_file($temp_image_two, BASE_PATH . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . $product_image_two)) {
            echo "Failed to upload product image two.";
        }
        if (!move_uploaded_file($temp_image_three, BASE_PATH . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . $product_image_three)) {
            echo "Failed to upload product image three.";
        }

        
        //insert query in db
        $insert_query = "INSERT INTO `products` (product_title,product_description,product_keywords,category_id,brand_id,product_image_one,product_image_two,product_image_three,product_price,date,status) VALUES ('$product_title','$product_description','$product_keywords','$product_category','$product_brand','$product_image_one','$product_image_two','$product_image_three','$product_price',NOW(),'$product_status')";
        $insert_result=mysqli_query($con,$insert_query);
        if($insert_result){
        echo "<script>alert(\"Product Inserted Successfully\");</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Products - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container p-4">
                    <h2 class="text-center mb-4">Insert Product</h2>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="product_title" class="form-label">Product Title</label>
                            <input type="text" class="form-control" id="product_title" name="product_title" placeholder="Enter Product Title" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_description" class="form-label">Product Description</label>
                            <textarea class="form-control" id="product_description" name="product_description" rows="3" placeholder="Enter Product Description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="product_keywords" class="form-label">Product Keywords</label>
                            <input type="text" class="form-control" id="product_keywords" name="product_keywords" placeholder="Enter Product Keywords" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="product_category" class="form-label">Category</label>
                                <select class="form-select" id="product_category" name="product_category" required>
                                    <option value="" selected disabled>Select a Category</option>
                                    <?php
                                    $select_query = 'SELECT * FROM `categories`';
                                    $select_result = mysqli_query($con, $select_query);
                                    while ($row = mysqli_fetch_assoc($select_result)) {
                                        $category_title = $row['category_title'];
                                        $category_id = $row['category_id'];
                                        echo "<option value='$category_id'>$category_title</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="product_brand" class="form-label">Brand</label>
                                <select class="form-select" id="product_brand" name="product_brand" required>
                                    <option value="" selected disabled>Select a Brand</option>
                                    <?php
                                    $select_query = 'SELECT * FROM `brands`';
                                    $select_result = mysqli_query($con, $select_query);
                                    while ($row = mysqli_fetch_assoc($select_result)) {
                                        $brand_title = $row['brand_title'];
                                        $brand_id = $row['brand_id'];
                                        echo "<option value='$brand_id'>$brand_title</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="product_image_one" class="form-label">Product Image One</label>
                            <input type="file" class="form-control" id="product_image_one" name="product_image_one" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_image_two" class="form-label">Product Image Two</label>
                            <input type="file" class="form-control" id="product_image_two" name="product_image_two" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_image_three" class="form-label">Product Image Three</label>
                            <input type="file" class="form-control" id="product_image_three" name="product_image_three" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_price" class="form-label">Product Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="product_price" name="product_price" placeholder="Enter Product Price" step="0.01" required>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" name="insert_product">Insert Product</button>
                            <a href="index.php" class="btn btn-secondary">Back to Admin Dashboard</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>