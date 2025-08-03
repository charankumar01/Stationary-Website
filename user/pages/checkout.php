<?php
include_once('../include/user.php');

if (!$user_logged_in) {
  header('Location: /user/pages/login.php?ref=/user/pages/cart.php');
  die();
}

$user_id = $user['id'];
$cod = $_GET['cod'];

if (!isset($cod)) {
  die();
}

$checkout_data = base64_decode($cod);
if ($checkout_data === false) {
  http_response_code(400);
  echo json_encode(['error' => 'Invalid data']);
  exit;
}

$checkout_data = json_decode($checkout_data, true);
$products_to_buy = $checkout_data['products'];

// Extract product IDs
$product_ids = array_keys($products_to_buy);
$placeholders = implode(',', array_fill(0, count($product_ids), '?'));

// query to fetch product info + availability/stock
$productQuery = "SELECT 
                  p.id, p.name, p.regular_price, p.discounted_price, 
                  pd.availability, pd.stock
    FROM products p
    LEFT JOIN product_details pd ON p.id = pd.prod_id
    WHERE p.id IN ($placeholders)
";

$productStmt = mysqli_prepare($conn, $productQuery);

// Bind parameters dynamically
$types = str_repeat('i', count($product_ids));
mysqli_stmt_bind_param($productStmt, $types, ...$product_ids);

mysqli_stmt_execute($productStmt);
$productResult = mysqli_stmt_get_result($productStmt);

$products = [];
while ($row = mysqli_fetch_assoc($productResult)) {
  $row['quantity'] = $products_to_buy[$row['id']]['quantity']; // Add quantity to product
  $products[] = $row;
}

// Query to fetch customer details
$customerQuery = "SELECT id, name, email, phone, city, state, address, zipcode, status
  FROM customers 
  WHERE id = ?
";

$customerStmt = mysqli_prepare($conn, $customerQuery);
mysqli_stmt_bind_param($customerStmt, "i", $user_id);
mysqli_stmt_execute($customerStmt);
$customerResult = mysqli_stmt_get_result($customerStmt);
$customer = mysqli_fetch_assoc($customerResult);

$total_products_count = 0;

$price_data = [
  'subtotal' => 0,
  'discounted_price' => 0,
  'delivery_charges' => 0,  // 5% of  the total order charges
  'total_amount' => 0,
];

$stock_insufficient = false;

foreach($products as $product) {
  $qty = (int) $product['quantity'];

  // echo "qty: $qty, stock: ". $product['stock'] . ', quantity: ' . $product['quantity'] . "\n\n<br>";

  if ($qty > ((int) $product['stock'])) {
    $product['quantity'] = (int) $product['stock'];
    $qty = $product['quantity'];
    $stock_insufficient = true;
  }

  $total_products_count += $qty;

  $price_data['subtotal'] += $product['regular_price'] * $qty;
  $price_data['total_amount'] += $product['discounted_price'] * $qty;
}

// echo "stock insufficient: ". (int)$stock_insufficient;

$price_data['discounted_price'] = $price_data['total_amount'] - $price_data['subtotal'];
$price_data['delivery_charges'] = round($price_data['total_amount'] * (5 / 100), 2); // 5% of the total

$price_data['total_amount'] += round($price_data['delivery_charges'], 2);

$response = [
  "success" => true,
  "customer" => $customer,
  "products" => $products
];

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $phone       = $_POST['phone'];
  $country     = $_POST['country'];
  $city        = $_POST['city'];
  $address     = $_POST['address'];
  $postal_code = $_POST['postal_code'];
  $email       = $_POST['email'];
  
  $card_name   = $_POST['card_name'];
  $card_num    = $_POST['card_num'];
  $card_CVV    = $_POST['card_CVV'];
  $card_date   = $_POST['card_date'];

  $updateCustomerQuery = "
    UPDATE customers 
    SET phone = ?, state = ?, city = ?, address = ?, zipcode = ?, email = ?
    WHERE id = ?
  ";
  $updateStmt = mysqli_prepare($conn, $updateCustomerQuery);
  mysqli_stmt_bind_param($updateStmt, "ssssssi", $phone, $country, $city, $address, $postal_code, $email, $user_id);
  mysqli_stmt_execute($updateStmt);
  mysqli_stmt_close($updateStmt);

  sleep(1);

  $order_num = "ORD" . mt_rand(100000, 999999);
  $status = 'pending';
  $orderQuery = "
    INSERT INTO orders (order_num, customer_id, status, total_amount, sub_total, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?, NOW(), NOW())
  ";
  $orderStmt = mysqli_prepare($conn, $orderQuery);
  mysqli_stmt_bind_param($orderStmt, "sisdd", $order_num, $user_id, $status, $price_data['total_amount'], $price_data['subtotal']);
  mysqli_stmt_execute($orderStmt);
  $order_id = mysqli_insert_id($conn);
  mysqli_stmt_close($orderStmt);

  $orderDetailQuery = "
    INSERT INTO order_details (order_id, product_id, qty, amount, created_at, updated_at)
    VALUES (?, ?, ?, ?, NOW(), NOW())
  ";
  $orderDetailStmt = mysqli_prepare($conn, $orderDetailQuery);
  foreach ($products as $product) {
      $qty    = (int)$product['quantity'];
      $amount = $product['discounted_price'] * $qty;
      mysqli_stmt_bind_param($orderDetailStmt, "iiid", $order_id, $product['id'], $qty, $amount);
      mysqli_stmt_execute($orderDetailStmt);
  }
  mysqli_stmt_close($orderDetailStmt);

  $updateStockQuery = "UPDATE product_details SET stock = stock - ? WHERE prod_id = ?";
  $updateStockStmt = mysqli_prepare($conn, $updateStockQuery);
  foreach ($products as $product) {
      $qty = (int)$product['quantity'];
      mysqli_stmt_bind_param($updateStockStmt, "ii", $qty, $product['id']);
      mysqli_stmt_execute($updateStockStmt);
  }
  mysqli_stmt_close($updateStockStmt);

  echo json_encode([
    "success"  => true,
    "order_id" => $order_id,
    "message"  => "Order processed successfully"
  ]);
  header("Location: /user/pages/order_details.php?order_id=$order_id&n=1");
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Checkout - Draftsy</title>
  <?php
  include('../include/styles.php');
  ?>
  <style>
    .wpo-checkout-area .payment-area .form-style input, .wpo-checkout-area .payment-area .form-style select, .wpo-checkout-area .billing-adress .form-style input, .wpo-checkout-area .billing-adress .form-style select, .wpo-checkout-area .note-area textarea {
      border-radius: 0px !important;
    }
  </style>
</head>

<body>

  <!-- start page-wrapper -->
  <div class="page-wrapper">
    <!-- start preloader -->
    <div class="preloader">
      <div class="vertical-centered-box">
        <div class="content">
          <div class="loader-circle"></div>
          <div class="loader-line-mask">
            <div class="loader-line"></div>
          </div>
          <img src="assets/images/preloader.png" alt="">
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
              <h2>Checkout</h2>
              <ol class="wpo-breadcumb-wrap">
                <li><a href="/user/pages/index.php">Home</a></li>
                <li>Checkout</li>
              </ol>
            </div>
          </div>
        </div> <!-- end row -->
      </div> <!-- end container -->
    </section>
    <!-- end page-title -->

    <!-- wpo-checkout-area start-->
    <div class="wpo-checkout-area section-padding">
      <div class="container">
        <form method="POST">
          <div class="checkout-wrap">
            <div class="row">
              <div class="col-lg-8 col-12">
                <div class="caupon-wrap s2">
                  <div class="biling-item">
                    <div class="coupon coupon-3">
                      <label id="toggle2">Billing Address</label>
                    </div>
                    <div class="billing-adress">
                      <div class="contact-form form-style">
                        <div class="row">
                          <div class="col-lg-6 col-md-12 col-12">
                            <label for="fname1">Full Name</label>
                            <input required type="text" placeholder="" id="name" name="name" value="<?= $customer['name'] ?? '' ?>">
                          </div>
                          <div class="col-lg-6 col-md-12 col-12">
                            <label for="email2">Phone No.</label>
                            <input required type="text" placeholder="" id="phone" name="phone" value="<?= $customer['phone'] ?? '' ?>">
                          </div>
                          <div class="col-lg-6 col-md-12 col-12">
                            <label for="Country">Country</label>
                            <select name="country" id="country" class="form-control" required>
                              <option selected>Pakistan</option>
                              <option>United States</option>
                              <option>India</option>
                              <option>Srilanka</option>
                              <option>Bangladesh</option>
                            </select>
                          </div>
                          <div class="col-lg-6 col-md-12 col-12">
                            <label for="City">City</label>
                            <input required type="text" placeholder="" id="city" name="city" value="<?= $customer['city'] ?? '' ?>">
                          </div>
                          <div class="col-lg-12 col-md-12 col-12">
                            <label for="Address">Address</label>
                            <input required type="text" placeholder="" id="address" name="address" value="<?= $customer['address'] ?? '' ?>">
                          </div>
                          <div class="col-lg-6 col-md-12 col-12">
                            <label for="Post2">Postal Code</label>
                            <input required type="text" placeholder="" id="postal_code" name="postal_code" value="<?= $customer['zipcode'] ?? '' ?>">
                          </div>
                          <div class="col-lg-6 col-md-12 col-12">
                            <label for="email4">Email Adress</label>
                            <input required type="text" placeholder="" id="email" name="email" value="<?= $customer['email'] ?? '' ?>">
                          </div>
                        </div>
                      </div>
                      <div class="biling-item-2">
                        <!-- <input id="toggle3" type="checkbox">
                        <label class="fontsize" for="toggle3">Ship to a different
                          address?</label>
                        <div class="billing-adress" id="open3">
                          <div class="contact-form form-style">
                            <div class="row">
                              <div class="col-lg-6 col-md-12 col-12">
                                <label for="fname4">First Name</label>
                                <input type="text" placeholder="" id="fname4"
                                  name="fname">
                              </div>
                              <div class="col-lg-6 col-md-12 col-12">
                                <label for="fname3">Last Name</label>
                                <input type="text" placeholder="" id="fname3"
                                  name="fname">
                              </div>
                              <div class="col-lg-6 col-md-12 col-12">
                                <label for="Country2">Country</label>
                                <select name="address" id="Country2"
                                  class="form-control">
                                  <option disabled="" selected="">United State
                                  </option>
                                  <option>Bangladesh</option>
                                  <option>India</option>
                                  <option>Srilanka</option>
                                  <option>Pakisthan</option>
                                  <option>Afgansthan</option>
                                </select>
                              </div>
                              <div class="col-lg-6 col-md-12 col-12">
                                <label for="City2">Dristrict</label>
                                <input type="text" placeholder="" id="City2"
                                  name="City">
                              </div>
                              <div class="col-lg-12 col-md-12 col-12">
                                <label for="Adress2">Address</label>
                                <input type="text" placeholder="" id="Adress2"
                                  name="Adress">
                              </div>
                              <div class="col-lg-6 col-md-12 col-12">
                                <label for="Post">Post Code</label>
                                <input type="text" placeholder="" id="Post" name="Post">
                              </div>
                              <div class="col-lg-6 col-md-12 col-12">
                                <label for="emails">Email Adress</label>
                                <input type="text" placeholder="" id="emails"
                                  name="email">
                              </div>
                              <div class="col-lg-12 col-md-12 col-12">
                                <label for="emaild">Phone No.</label>
                                <input type="text" placeholder="" id="emaild"
                                  name="email">
                              </div>
                            </div>
                          </div>
                        </div> -->
                        <!-- <div class="note-area">
                          <p>Order Notes </p>
                          <textarea name="massage" placeholder="Note about your order" style="min-height: 200px;"></textarea>
                        </div> -->
                        <!-- <div class="submit-btn-area">
                          <ul>
                            <li><button class="theme-btn" type="submit">Save &
                                continue</button></li>
                          </ul>
                        </div> -->
                      </div>
                    </div>
                  </div>
                </div>
                <div class="caupon-wrap s3">
                  <div class="payment-area">
                    <div class="row">
                      <div class="col-12">
                        <div class="coupon coupon-3">
                          <label>Payment Method</label>
                        </div>
                        <div class="payment-option pt-0">
                          <div class="payment-select" style="display: none;">
                            <ul>
                              <li class="addToggle">
                                <input id="add" type="radio" name="payment"
                                  checked="checked" value="30">
                                <label for="add">Payment By Card</label>
                              </li>
                              <li class="removeToggle">
                                <input id="remove" type="radio" name="payment"
                                  value="30">
                                <label for="remove">Cash On delivery</label>
                              </li>
                            </ul>
                          </div>
                          <div class="payment-name active">
                            <!-- <ul>
                              <li class="visa"><input id="1" type="radio" name="size"
                                  value="30">
                                <label for="1"><img
                                    src="assets/images/checkout/img-1.png"
                                    alt=""></label>
                              </li>
                              <li class="mas"><input id="2" type="radio" name="size"
                                  value="30">
                                <label for="2"><img
                                    src="assets/images/checkout/img-2.png"
                                    alt=""></label>
                              </li>
                              <li class="ski"><input id="3" type="radio" name="size"
                                  value="30">
                                <label for="3"><img
                                    src="assets/images/checkout/img-3.png"
                                    alt=""></label>
                              </li>
                              <li class="pay"><input id="4" type="radio" name="size"
                                  value="30">
                                <label for="4"><img
                                    src="assets/images/checkout/img-4.png"
                                    alt=""></label>
                              </li>
                            </ul> -->
                            <div class="contact-form form-style">
                              <div class="row">
                                <div class="col-lg-6 col-md-12 col-12">
                                  <label for="holder">Card holder Name</label>
                                  <input type="text" placeholder="" id="holder" required name="card_name" value="<?= $customer['name'] ?>">
                                </div>
                                <div class="col-lg-6 col-md-12 col-12">
                                  <label for="card">Card Number</label>
                                  <input type="text" placeholder="" id="card" required name="card_num">
                                </div>
                                <div class="col-lg-6 col-md-12 col-12">
                                  <label for="CVV">CVV</label>
                                  <input type="text" placeholder="" id="CVV" required name="card_CVV">
                                </div>
                                <div class="col-lg-6 col-md-12 col-12">
                                  <label for="date">Expire Date</label>
                                  <input type="date" placeholder="" id="date" required name="card_date">
                                </div>
                                <div class="col-lg-12 col-md-12 col-12">
                                  <div class="submit-btn-area text-center">
                                    <button class="theme-btn" type="submit">Place Order</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-12">
                <div class="cout-order-area">
                  <div class="oreder-item ">
                    <ul>
                      <?php if ($stock_insufficient) { ?>
                        <div class="alert alert-warning rounded-0">
                          Some products have been reduced due to stock being insufficient
                        </div>
                      <?php } ?>
                      <li class="o-header">Your Order<span>( <?= $total_products_count ?> )</span></li>
                      <?php foreach($products as $product) { ?>
                        <li>
                          <?= $product['name'] ?>
                          <small>x<?= $product['quantity'] ?></small>
                          <span>$<?= $product['regular_price'] * $product['quantity'] ?></span>
                        </li>
                      <?php } ?>
                      <!-- <li>Product 2 X 1<span>50$</span></li>
                      <li>Product 3 X 2<span>100$</span></li>
                      <li>Product 4 X 1<span>50$</span></li>
                      <li class="o-middle">Product 5 X 1<span>50$</span></li> -->
                      <li class="s-total">Sub Total<span>$<?= $price_data['subtotal'] ?></span></li>
                      <!-- <li>( + ) VAT<span>10$</span></li> -->
                      <li>( + ) Delivery Charges<span>$<?= $price_data['delivery_charges'] ?></span></li>
                      <!-- <li>( + ) Eco Tax <span>100$</span></li> -->
                      <li>( - ) Discounted Price<span><?= $price_data['discounted_price'] ?>$</span></li>
                      <li class="o-bottom">Total price <span>$ <?= $price_data['total_amount'] ?></span></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- wpo-checkout-area end-->

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