<?php
include('../../includes/header.php');

$query = "SELECT orders.id, orders.order_num, orders.status, orders.sub_total, customers.name AS customer_name FROM orders JOIN customers ON orders.customer_id = customers.id";

$result = mysqli_query($conn, $query);
?>

<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Orders</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="../../index.php" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Orders</li>
        </ul>
    </div>

    <div class="card basic-data-table">
        <div class="card-header">
            <h5 class="card-title mb-0">All Orders</h5>
        </div>
        <div class="card-body">
            <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                <thead>
                    <tr>
                        <th scope="col">Order #</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Sub Total</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $row['order_num']; ?></td>
                            <td><?php echo $row['customer_name']; ?></td>
                            <td>
                                <?php 
                                $status = $row['status'];
                                $status_classes = [
                                    'pending'   => 'badge bg-warning',
                                    'shipped'   => 'badge bg-primary',
                                    'delivered' => 'badge bg-success',
                                    'cancelled' => 'badge bg-danger'
                                ];
                                ?>
                                <span class="fw-bold <?php echo $status_classes[$status] ?? ''; ?>">
                                    <?php echo ucfirst($status); ?>
                                </span>
                            </td>
                            <td>$<?php echo number_format($row['sub_total'], 2); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <i class="ri-edit-box-line"></i>
                                </a>
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
</div>

<?php
include('../../includes/footer.php');
?>