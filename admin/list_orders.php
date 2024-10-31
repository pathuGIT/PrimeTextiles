<?php
include_once('../includes/connect.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.open('./admin_login.php','_self');</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .table-responsive {
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            min-width: 100px;
        }

        .order-details {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Orders</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Orders</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="search" class="form-control" id="searchOrder" placeholder="Search orders...">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="paid">Paid</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="col-md-5 text-md-end">
                        <span class="text-muted">Total Orders:
                            <?php
                            $count_query = "SELECT COUNT(*) as total FROM user_orders";
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
                        <th scope="col">Order ID</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Products</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $get_order_query = "SELECT o.*, u.username, u.user_email 
                                        FROM user_orders o 
                                        LEFT JOIN user_table u ON o.user_id = u.user_id 
                                        ORDER BY o.order_date DESC";
                    $get_order_result = mysqli_query($con, $get_order_query);

                    if (mysqli_num_rows($get_order_result) == 0) {
                        echo '<tr><td colspan="7" class="text-center py-4">No orders found</td></tr>';
                    } else {
                        while ($order = mysqli_fetch_array($get_order_result)) {
                            $status_class = match ($order['order_status']) {
                                'pending' => 'bg-warning',
                                'processing' => 'bg-info',
                                'paid' => 'bg-success',
                                'completed' => 'bg-primary',
                                default => 'bg-secondary'
                            };
                    ?>
                            <tr>
                                <td>
                                    <strong>#<?php echo $order['invoice_number']; ?></strong>
                                    <div class="small text-muted">ID: <?php echo $order['order_id']; ?></div>
                                </td>
                                <td>
                                    <div><?php echo $order['username']; ?></div>
                                    <div class="small text-muted"><?php echo $order['user_email']; ?></div>
                                </td>
                                <td>
                                    <strong>$<?php echo number_format($order['amount_due'], 2); ?></strong>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#orderDetails_<?php echo $order['order_id']; ?>">
                                        <?php echo $order['total_products']; ?> Products
                                    </button>
                                </td>
                                <td>
                                    <div><?php echo date('M d, Y', strtotime($order['order_date'])); ?></div>
                                    <div class="small text-muted"><?php echo date('h:i A', strtotime($order['order_date'])); ?></div>
                                </td>
                                <td>
                                    <span class="badge <?php echo $status_class; ?> status-badge">
                                        <?php echo ucfirst($order['order_status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal_<?php echo $order['order_id']; ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('searchOrder').addEventListener('keyup', function() {
            let searchValue = this.value.toLowerCase();
            let tableRows = document.querySelectorAll('tbody tr');

            tableRows.forEach(row => {
                let orderNumber = row.querySelector('strong').textContent.toLowerCase();
                let customerName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();

                if (orderNumber.includes(searchValue) || customerName.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        document.getElementById('statusFilter').addEventListener('change', function() {
            let filterValue = this.value.toLowerCase();
            let tableRows = document.querySelectorAll('tbody tr');

            tableRows.forEach(row => {
                let status = row.querySelector('.status-badge').textContent.trim().toLowerCase();
                if (filterValue === '' || status === filterValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>
