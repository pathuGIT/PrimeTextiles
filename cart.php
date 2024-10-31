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
    <title>Ecommerce Cart Details Page</title>
    <link rel="stylesheet" href="./assets/css/bootstrap.css" />
    <link rel="stylesheet" href="./assets/css/main.css" />
</head>

<body>
    <!-- upper-nav -->
    <?php include_once('./includes/discount.php'); ?>
    <!-- upper-nav -->
    <?php include_once("./includes/navbar.php"); ?>

    <!-- Start Table Section -->
    <div class="landing">
        <div class="container">
            <div class="row py-5 m-0">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <table class="table table-bordered table-hover table-striped table-group-divider text-center">

                        <!-- Display Data in Cart -->
                        <?php
                        $getIpAddress = getIPAddress();
                        $total_price = 0;
                        $cart_query = "SELECT * FROM `card_details` WHERE ip_address='$getIpAddress'";
                        $cart_result = mysqli_query($con, $cart_query);
                        $result_count = mysqli_num_rows($cart_result);

                        if ($result_count > 0) {
                            echo "
                                <thead>
                                    <tr class='d-flex flex-column d-md-table-row '>
                                        <th>Product Title</th>
                                        <th>Product Image</th>
                                        <th>Quantity</th>
                                        <th>Price (per item)</th>
                                        <th>Total Price</th>
                                        <th>Remove</th>
                                        <th>Operations</th>
                                    </tr>
                                </thead>
                                <tbody>
                            ";

                            while ($row = mysqli_fetch_array($cart_result)) {
                                $product_id = $row['product_id'];
                                $product_quantity = $row['quantity'];
                                $select_product_query = "SELECT * FROM `products` WHERE product_id=$product_id";
                                $select_product_result = mysqli_query($con, $select_product_query);

                                while ($row_product_price = mysqli_fetch_array($select_product_result)) {
                                    $price_per_item = $row_product_price['product_price'];
                                    $product_title = $row_product_price['product_title'];
                                    $product_image_one = $row_product_price['product_image_one'];
                                    $item_total_price = $price_per_item * $product_quantity;
                                    $total_price += $item_total_price;
                        ?>
                                    <tr class="d-flex flex-column d-md-table-row ">
                                        <td><?php echo $product_title; ?></td>
                                        <td><img src="<?= BASE_URL ?>/assets/images/products/<?php echo $product_image_one; ?>" class="img-thumbnail" alt="<?php echo $product_title; ?>"></td>
                                        <td>
                                            <input type="number" class="form-control w-50 mx-auto" min="1" name="qty_<?php echo $product_id; ?>" value="<?php echo $product_quantity; ?>">
                                        </td>
                                        <td><?php echo $price_per_item; ?></td>
                                        <td><?php echo $item_total_price; ?></td>
                                        <td><input type="checkbox" name="removeitem[]" value="<?php echo $product_id; ?>"></td>
                                        <td>
                                            <input type="submit" value="Update" class="btn btn-dark" name="update_cart">
                                            <input type="submit" value="Remove" class="btn btn-primary" name="remove_cart">
                                        </td>
                                    </tr>
                        <?php
                                }
                            }
                        } else {
                            echo "<h2 class='text-center text-danger'>Cart is empty</h2>
          <div class='d-flex justify-content-center' style='margin-top: 20px;'>
              <a href='./index.php' class='btn btn-dark'>Continue Shopping</a>
          </div>";
                        }
                        ?>
                        </tbody>
                    </table>

                    <!-- Subtotal Section -->
                    <div class="d-flex align-items-center gap-4 flex-wrap">
                        <?php
                        if ($result_count > 0) {
                            echo "
                                <h4>Sub-Total: <strong class='text-2'> $total_price</strong></h4>
                                <button type='button' class='btn btn-dark'><a class='text-light' href='./index.php'>Continue Shopping</a></button>
                                <button type='button' class='btn btn-dark'><a class='text-light' href='./users_area/checkout.php'>Checkout</a></button>
                            ";
                        }
                        ?>
                    </div>

                    <!-- Handling Cart Update -->
                    <?php
                    if (isset($_POST['update_cart'])) {
                        foreach ($_POST as $key => $value) {
                            if (strpos($key, 'qty_') === 0) {
                                $product_id = str_replace('qty_', '', $key);
                                $quantity = intval($value);
                                if ($quantity > 0) {
                                    $update_cart_query = "UPDATE `card_details` SET quantity = $quantity WHERE ip_address='$getIpAddress' AND product_id=$product_id";
                                    mysqli_query($con, $update_cart_query);
                                }
                            }
                        }
                        echo "<script>window.open('cart.php','_self');</script>";
                    }
                    ?>

                    <!-- Handling Cart Item Removal -->
                    <?php
                    if (isset($_POST['remove_cart'])) {
                        if (!empty($_POST['removeitem'])) {
                            foreach ($_POST['removeitem'] as $remove_id) {
                                $delete_query = "DELETE FROM `card_details` WHERE product_id=$remove_id AND ip_address='$getIpAddress'";
                                mysqli_query($con, $delete_query);
                            }
                            echo "<script>window.open('cart.php','_self');</script>";
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>

    <?php include_once('./includes/footer.php'); ?>
    <script src="./assets/js/bootstrap.bundle.js"></script>
</body>

</html>