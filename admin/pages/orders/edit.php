<?php
include('../../includes/header.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];
    // Get order info along with customer name
    $query = "SELECT orders.*, customers.name AS customer_name 
              FROM orders 
              JOIN customers ON orders.customer_id = customers.id 
              WHERE orders.id = ".$id;
    $result = mysqli_query($conn, $query);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
    }
}

if(isset($_POST['submit'])){
    // Only update status
    $id = $_POST['id'];
    $status = $_POST['status'];
    
    $query = "UPDATE orders SET status = '$status' WHERE id = ".$id;
    $result = mysqli_query($conn, $query);
    
    if($result){
        echo "<script>window.location.href='index.php'</script>";
    } else {
        echo "Something went wrong!";
    }
}

// Query for ordered products
$order_details_query = "SELECT od.qty, od.amount, p.name AS product_name 
                        FROM order_details AS od 
                        JOIN products AS p ON od.product_id = p.id 
                        WHERE od.order_id = ".$id;
$order_details_result = mysqli_query($conn, $order_details_query);
?>

<div class="dashboard-main-body">

  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Orders</h6>
    <ul class="d-flex align-items-center gap-2">
      <li class="fw-medium">
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/dashboard.php" class="d-flex align-items-center gap-1 hover-text-primary">
          <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
          Dashboard
        </a>
      </li>
      <li>-</li>
      <li class="fw-medium">Edit Order</li>
    </ul>
  </div>

  <div class="row gy-4">
    <!-- Order Edit Form -->
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Edit Order</h5>
        </div>
        <div class="card-body">
          <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="col-12 mb-3">
              <label class="form-label">Order Number</label>
              <input type="text" name="order_num" class="form-control" value="<?php echo $row['order_num']; ?>" readonly>
            </div>
            <div class="col-12 mb-3">
              <label class="form-label">Customer Name</label>
              <input type="text" name="customer_name" class="form-control" value="<?php echo $row['customer_name']; ?>" readonly>
            </div>
            <div class="col-12 mb-3">
              <label class="form-label">Sub Total</label>
              <input type="text" name="sub_total" class="form-control" value="<?php echo $row['sub_total']; ?>" readonly>
            </div>
            <div class="col-12 mb-3">
              <label class="form-label">Status</label>
              <select name="status" class="form-control">
                <option value="pending" <?php if($row['status']=='pending') echo 'selected'; ?>>Pending</option>
                <option value="shipped" <?php if($row['status']=='shipped') echo 'selected'; ?>>Shipped</option>
                <option value="delivered" <?php if($row['status']=='delivered') echo 'selected'; ?>>Delivered</option>
                <option value="cancelled" <?php if($row['status']=='cancelled') echo 'selected'; ?>>Cancelled</option>
              </select>
            </div>
            <div class="col-12">
              <button type="submit" name="submit" class="btn btn-primary-600">Update Order</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Ordered Products Table -->
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Ordered Products</h5>
        </div>
        <div class="card-body">
          <table class="table bordered-table mb-0">
            <thead>
              <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Amount</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if($order_details_result && $order_details_result->num_rows > 0){
                while($detail = $order_details_result->fetch_assoc()){
              ?>
                <tr>
                  <td><?php echo htmlspecialchars($detail['product_name']); ?></td>
                  <td><?php echo $detail['qty']; ?></td>
                  <td>$<?php echo number_format($detail['amount'],2); ?></td>
                </tr>
              <?php
                }
              } else {
              ?>
                <tr>
                  <td colspan="3">No products found for this order.</td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include('../../includes/footer.php');
?>
