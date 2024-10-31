<?php
include_once('../includes/connect.php');

// Check if admin is logged in
if(!isset($_SESSION['admin_username'])){
    echo "<script>window.open('./admin_login.php','_self');</script>";
    exit();
}

if(isset($_GET['delete_order'])){
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_order']);
    
    // Validate order exists
    $check_order = "SELECT invoice_number FROM user_orders WHERE order_id = ?";
    $stmt = mysqli_prepare($con, $check_order);
    mysqli_stmt_bind_param($stmt, "i", $delete_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if(mysqli_num_rows($result) > 0) {
        $order_data = mysqli_fetch_assoc($result);
        $invoice_number = $order_data['invoice_number'];
        
        // Begin transaction
        mysqli_begin_transaction($con);
        
        try {
            // Delete from orders_pending first (child table)
            $delete_pending = "DELETE FROM orders_pending WHERE order_id = ?";
            $stmt_pending = mysqli_prepare($con, $delete_pending);
            mysqli_stmt_bind_param($stmt_pending, "i", $delete_id);
            mysqli_stmt_execute($stmt_pending);
            
            // Delete from user_orders (parent table)
            $delete_order = "DELETE FROM user_orders WHERE order_id = ?";
            $stmt_order = mysqli_prepare($con, $delete_order);
            mysqli_stmt_bind_param($stmt_order, "i", $delete_id);
            mysqli_stmt_execute($stmt_order);
            
            // Commit transaction
            mysqli_commit($con);
            
            // Success message and redirect
            echo "<script>
                    alert('Order #" . htmlspecialchars($invoice_number) . " has been deleted successfully');
                    window.location.href='index.php?list_orders';
                  </script>";
            
        } catch (Exception $e) {
            // Rollback transaction on error
            mysqli_rollback($con);
            
            // Error message and redirect
            echo "<script>
                    alert('Error deleting order. Please try again.');
                    window.location.href='index.php?list_orders';
                  </script>";
        }
        
        // Close prepared statements
        mysqli_stmt_close($stmt_pending);
        mysqli_stmt_close($stmt_order);
        
    } else {
        // Order not found
        echo "<script>
                alert('Order not found.');
                window.location.href='index.php?list_orders';
              </script>";
    }
    
    mysqli_stmt_close($stmt);
} else {
    // Invalid request
    echo "<script>window.location.href='index.php?list_orders';</script>";
}
?>