<?php
include_once '../include/user.php';

if (!$user_logged_in) {
  header("Location: /user/pages/login.php?ref=/user/pages/order.php");
  die();
}

$user_id = $user['id'];

if (!isset($_GET['order_id'])) {
  echo "Order ID is required.";
  exit;
}

$order_id = intval($_GET['order_id']); // Get order_id from URL

// Get order details (order_id, order_num, status, order_date, total_items, sub_total)
$orderQuery = "SELECT id, order_num, status, created_at, sub_total,
              DATE_FORMAT(created_at, '%d / %m / %Y') AS order_date
              FROM orders 
              WHERE id = ? AND customer_id = ?";
$orderStmt = mysqli_prepare($conn, $orderQuery);
mysqli_stmt_bind_param($orderStmt, "ii", $order_id, $user['id']); // Ensure $user['id'] is an integer
mysqli_stmt_execute($orderStmt);
$orderResult = mysqli_stmt_get_result($orderStmt);
$order = mysqli_fetch_assoc($orderResult);

if (!$order) {
  echo "Order not found.";
  exit;
}

// Get all products in the order
$query = "SELECT 
          od.product_id,
          p.image AS product_image,
          p.name AS product_name,
          od.qty,
          od.amount
      FROM order_details od
      JOIN products p ON od.product_id = p.id
      WHERE od.order_id = ?
";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$total_items = 0;

$products = [];

while ($item = mysqli_fetch_assoc($result)) {
  $products[] = $item;
  $total_items += $item['qty'];
}

?>

<!DOCTYPE html>
<html lang="en" class="js no-touch cssanimations csstransitions">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="wpOceans">
  <link rel="shortcut icon" type="image/png" href="https://wpocean.com/html/tf/pengu/assets/images/favicon.png">
  <title>My Order - Draftsy</title>
  <?php
  include('../include/styles.php');
  ?>
  <style type="text/css">
    .fancybox-margin {
      margin-right: 17px;
    }
  </style>
</head>

<body>

  <!-- start page-wrapper -->
  <div class="page-wrapper">
    <!-- start preloader -->
    <div class="preloader" style="display: none;">
      <div class="vertical-centered-box">
        <div class="content">
          <div class="loader-circle"></div>
          <div class="loader-line-mask">
            <div class="loader-line"></div>
          </div>
          <img src="./order_files/preloader.png" alt="">
        </div>
      </div>
    </div>
    <!-- end preloader -->

    <!-- Start header -->
    <?php
    include('../include/header.php');
    ?>
    <br>
    <br>
    <br>
    <br>
    <!-- end of header -->

    <!-- start wpo-page-title -->
    <section class="wpo-page-title">
      <div class="container">
        <div class="row">
          <div class="col col-xs-12">
            <div class="wpo-breadcumb-wrap">
              <h2>Order Details</h2>
              <ol class="wpo-breadcumb-wrap">
                <li><a href="/user/pages/index.php">Home</a></li>
                <li>Orders</li>
              </ol>
            </div>
          </div>
        </div> <!-- end row -->
      </div> <!-- end container -->
    </section>
    <!-- end page-title -->

    <!-- cart-area start -->
    <div class="cart-area section-padding">
      <div class="container">
        <?php
          $status = strtolower($order['status']) ?? null;
          $status_code = ['delivered' => 'alert-success', 'pending' => 'alert-warning', 'cancelled' => 'alert-danger', 'processing' => 'alert-info', 'shipped' => 'alert-primary'];
        ?>
        <div class="alert text-capitalize text-center <?= $status_code[$status] ?>"><?= $status ?></div>

        <table class="cart-wrap mb-5 table-responsive">
          <thead>
            <tr>
              <th>Order #</th>
              <th class="product">Date</th>
              <th class="ptice">Total Items</th>
              <th class="">Total Price</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>#<?= $order['order_num'] ?></td>
              <td><?= $order['order_date'] ?></td>
              <td><?= $total_items ?></td>
              <td>$ <?= $order['sub_total'] ?></td>
            </tr>
          </tbody>
        </table>

        <div class="form">
          <div class="cart-wrapper">
            <div class="row">
              <div class="col-12">
                <form action="">
                  <table class="table-responsive cart-wrap">
                    <thead>
                      <tr>
                        <th>Product ID</th>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($products as $item) { ?>
                        <tr>
                          <td><?= htmlspecialchars($item['product_id']); ?></td>
                          <td style="padding: 0 !important;">
                            <img src="<?= USER_IMAGES_PATH . '/' . htmlspecialchars($item['product_image'] ?? ''); ?>" alt="<?= htmlspecialchars($item['product_name']); ?>" width="50" onerror="this.src = '/user/assets/no-img.jpg'">
                          </td>
                          <td><?= htmlspecialchars($item['product_name']); ?></td>
                          <td><?= htmlspecialchars($item['qty']); ?></td>
                          <td>$ <?= number_format($item['amount'], 2); ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- cart-area end -->

    <!-- start of wpo-site-footer-section -->
    <?php
    include('../include/footer.php');
    ?>
    <!-- end of wpo-site-footer-section -->


  </div>
  <!-- end of page-wrapper -->

  <?php
  include('../include/scripts.php');
  ?>


</body>

</html>