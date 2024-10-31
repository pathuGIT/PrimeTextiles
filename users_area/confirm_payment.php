<?php
include_once("../includes/connect.php");
include_once("../functions/common_functions.php");
session_start();
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $select_order_query = "SELECT * FROM `user_orders` WHERE order_id = '$order_id'";
    $select_order_result = mysqli_query($con,$select_order_query);
    $row_fetch = mysqli_fetch_array($select_order_result);
    $invoice_number = $row_fetch['invoice_number'];
    $amount_due = $row_fetch['amount_due'];

}
if(isset($_POST['confirm_payment'])){
    //insert user payment
    $invoice_number = $_POST['invoice_number'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $insert_payment_query = "INSERT INTO `user_payments` (order_id,invoice_number,amount,payment_method) VALUES ($order_id,$invoice_number,$amount,'$payment_method')";
    $insert_payment_result = mysqli_query($con,$insert_payment_query);
    if($insert_payment_result){
        echo "<script>window.alert('Payment completed successfully');</script>";
        echo "<script>window.open('profile.php?my_orders','_self');</script>";
    }
    //update user orders
    $update_orders_query = "UPDATE `user_orders` SET order_status = 'paid' WHERE order_id = $order_id";
    $update_orders_result = mysqli_query($con,$update_orders_query);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
</head>

<body>
    <?php include_once("../includes/navbar.php"); ?>
    
    <script src="../assets/js/bootstrap.bundle.js"></script>
</body>

</html>