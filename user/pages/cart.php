<?php
include_once('../include/user.php');

if (!$user_logged_in) {
  header('Location: /user/pages/login.php?ref=/user/pages/cart.php');
  die();
}

$user_id = $user['id'];

// get all cart items
$cartQuery = "SELECT 
                c.id AS cart_id,
                p.id AS product_id,
                p.name AS product_name,
                p.image AS product_image,
                c.amount AS quantity,
                pd.availability AS product_availability,
                pd.stock AS product_stock,
                p.discounted_price AS price
            FROM cart c
            JOIN products p ON c.product_id = p.id
            JOIN product_details pd ON pd.prod_id = p.id
            WHERE c.customer_id = ?
";

$cartStmt = mysqli_prepare($conn, $cartQuery);
mysqli_stmt_bind_param($cartStmt, "i", $user_id);
mysqli_stmt_execute($cartStmt);
$cartResult = mysqli_stmt_get_result($cartStmt);

$cartItems = [];
while ($row = mysqli_fetch_assoc($cartResult)) {
  $cartItems[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Cart - Draftsy</title>
  <?php
  include('../include/styles.php');
  ?>
  <style>
    .quantity .qtybutton {
      user-select: none;
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
              <h2>Cart</h2>
              <ol class="wpo-breadcumb-wrap">
                <li><a href="index.html">Home</a></li>
                <li>Cart</li>
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
        <div class="form">
          <div class="cart-wrapper">
            <div class="row">
              <div class="col-12">
                <form action="cart">
                  <table class="table-responsive cart-wrap">
                    <thead>
                      <tr>
                        <th class=""></th>
                        <th class="images images-b">Image</th>
                        <th class="product-2">Product Name</th>
                        <th class="pr">Quantity</th>
                        <th class="ptice">Price (x1 item)</th>
                        <!-- <th class="stock">Total Price</th> -->
                        <th class="remove remove-b">Action</th>
                      </tr>
                    </thead>
                    <tbody id="cart-items">
                      <?php if (!empty($cartItems)): ?>
                        <?php foreach ($cartItems as $item): ?>
                          <?php
                            $item_available = $item['product_stock'] > 0;
                          ?>
                          <tr
                            data-id="<?= $item['cart_id'] ?>"
                            data-product-id="<?= $item['product_id'] ?>"
                            <?= $item_available ? '' : '
                              title="Item Out of Stock"
                              style="background: #f25e5e1f;"
                            ' ?>
                          >
                            <td>
                              <?php if ($item_available): ?>
                                <input type="checkbox" class="form-check-input">
                              <?php else: ?>
                                <p>OUT OF STOCK</p>
                              <?php endif ?>
                            </td>
                            <td class="images">
                              <img src="<?= USER_IMAGES_PATH . '/' . htmlspecialchars($item['product_image']); ?>" onerror="this.src = '/user/assets/no-img.jpg';" width="50" style="object-fit: contain;">
                            </td>
                            <td class="product">
                              <ul>
                                <li class="first-cart"><?= htmlspecialchars($item['product_name']); ?></li>
                              </ul>
                            </td>
                            <td class="stock">
                              <?php if ($item_available): ?>
                                <ul class="input-style">
                                  <li class="quantity cart-plus-minus">
                                    <input type="number" value="<?= $item['quantity']; ?>" min="1" max="<?= $item['product_stock'] ?>" />
                                  </li>
                                </ul>
                              <?php endif ?>
                            </td>
                            
                            <td class="price ptice" data-value="<?= number_format($item['price'], 2); ?>">$ <?= number_format($item['price'], 2); ?></td>
                            <td class="action">
                              <ul>
                                <li class="w-btn">
                                  <a class="remove-from-cart--btn" data-cart-id="<?= $item['cart_id'] ?>" href="#"
                                    data-bs-toggle="tooltip" data-bs-html="true" title="Remove from Cart">
                                    <i class="fi ti-trash"></i>
                                  </a>
                                </li>
                              </ul>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="6" class="text-center">Your cart is empty.</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </form>
                <div class="submit-btn-area">
                  <!-- <ul>
                    <li><a class="theme-btn" href="shop.html">Continue Shopping <i
                      class="fa fa-angle-double-right"></i></a></li>
                    <li><button class="theme-btn" type="submit">Update Cart</button></li>
                  </ul> -->
                </div>
                <div id="cart-purchase-info" class="cart-product-list">
                  <ul>
                    <li>Total products<span class="total-products">( xx )</span></li>
                    <li>Sub Price<span class="subprice">$xxx</span></li>
                    <!-- <li class="vat">Vat<span>$50</span></li>
                    <li class="eco-tax">Eco Tax<span>$100</span></li>
                    <li class="delivery-charges">Delivery Charge<span>$100</span></li>
                    <li class="cart-b">Total Price<span>$2500</span></li> -->
                  </ul>
                </div>

                <div class="submit-btn-area">
                  <ul>
                    <li>
                      <button id="proceed-to-check--btn" type="button" class="theme-btn">
                        Proceed to Checkout
                        <i class="fa fa-angle-double-right"></i>
                      </button>
                    </li>
                  </ul>
                </div>
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
  <script>
    function recalcCart() {
      let totalProducts = 0;
      let subPrice = 0;

      $('#cart-items tr').each(function() {
        const checkbox = $(this).find('.form-check-input');
        if (checkbox.is(':checked')) {
          let quantity = parseInt($(this).find('.quantity input[type=number]').val());
          let priceVal = $(this).find('.price').attr('data-value');
          let price = parseFloat(priceVal);

          if (price == NaN || price <= 0) {
            throw `Price of element ${this} is <= 0`;
          }

          if (!isNaN(quantity) && !isNaN(price)) {
            totalProducts += quantity;
            subPrice += price * quantity;
          }
        }
      });

      $('#cart-purchase-info .total-products').text('( ' + totalProducts + ' )');
      $('#cart-purchase-info .subprice').text('$' + subPrice.toFixed(2));
      // $('#vat').text('$' + (subPrice > 0 ? VAT.toFixed(2) : '0.00'));
      // $('#eco-tax').text('$' + (subPrice > 0 ? ecoTax.toFixed(2) : '0.00'));
      // $('#delivery-charge').text('$' + (subPrice > 0 ? deliveryCharge.toFixed(2) : '0.00'));
      // $('#total-price').text('$' + totalPrice.toFixed(2));
    }

    function proceedToCheckout() {
      let data = {
        'products': {},
      };

      $('#cart-items tr').each(function() {
        const checkbox = $(this).find('.form-check-input');
        
        if (!checkbox.is(':checked')) {
          return;
        }

        const prod_id = $(this).attr('data-product-id');
        const quantity = $(this).find('.quantity input').val();

        data['products'][prod_id] = {
          id: prod_id,
          quantity: quantity,
        };
      });

      // if there are no products
      if (Object.keys(data.products).length === 0) {
        console.warn('no products selected');
        return;
      }

      let hash = btoa(JSON.stringify(data)).replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/, '');
      window.location.href = `/user/pages/checkout.php?cod=${hash}`
    }

    function removeFromCart(parent, cart_id) {
      $.ajax({
        url: `/user/api/remove_from_cart.php?id=${cart_id}`,
        type: "GET",
        dataType: "json",
        success: function(response) {
          if (response.success) {
            $(parent).animate({
              marginLeft: "-100px",
              opacity: 0
            }, 400, function() {
              $(this).remove();
            });
          } else {
            console.log(response.message);
          }
        },
        error: function() {
          alert("Error removing item. Try again.");
        }
      });
    }

    document.querySelectorAll('#cart-items [data-id] .remove-from-cart--btn').forEach((el) =>
      el.addEventListener('click', (ev) => {
        ev.preventDefault();
        let cart_id = $(el).attr('data-cart-id');
        let parent = $(el).closest('#cart-items [data-id]');
        removeFromCart(parent, cart_id);
      })
    );

    $('#cart-items').on('change', 'input[type="checkbox"], .quantity input', function() {
      recalcCart();
    });

    $('#proceed-to-check--btn').on('click', proceedToCheckout);

    recalcCart();
  </script>
</body>

</html>