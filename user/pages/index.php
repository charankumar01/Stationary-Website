<?php

include_once '../include/user.php';
include_once '../include/helper.php';

/*----------------------------------------------------
  1) Latest Products
-----------------------------------------------------*/
$sql_latest = "SELECT *
               FROM products
               ORDER BY created_at DESC
               LIMIT 4";

$result_latest = mysqli_query($conn, $sql_latest);

if (!$result_latest) {
  die("Error fetching latest products: " . mysqli_error($conn));
}

$latest_products = [];

while ($row = mysqli_fetch_assoc($result_latest)) {
  $latest_products[] = $row;
}

/*----------------------------------------------------
  2) Popular Products
  - Combines delivered sales and product review ratings.
  - Uses subqueries to calculate sales (only for orders with status 'delivered')
    and average ratings from product_reviews.
-----------------------------------------------------*/
$sql_popular = "SELECT
    p.id AS id,
    p.name AS name,
    p.description as description,
    p.image as image,
    p.sku as sku,
    p.regular_price as regular_price,
    p.discounted_price as discounted_price,

    IFNULL(s.total_sold, 0) AS total_sold,
    IFNULL(r.avg_rating, 0) AS avg_rating,
    (IFNULL(s.total_sold, 0) * 0.7 + IFNULL(r.avg_rating, 0) * 0.3) AS popularity_score
FROM products p
LEFT JOIN (
    SELECT 
         od.product_id, SUM(od.qty) AS total_sold
    FROM order_details od
    JOIN orders o ON o.id = od.order_id
    WHERE o.status = 'delivered'
    GROUP BY od.product_id
) s ON p.id = s.product_id
LEFT JOIN (
    SELECT prod_id, AVG(rating) AS avg_rating
    FROM product_reviews
    GROUP BY prod_id
) r ON p.id = r.prod_id
ORDER BY popularity_score DESC
LIMIT 8;
";

$result_popular = mysqli_query($conn, $sql_popular);

if (!$result_popular) {
  die("Error fetching popular products: " . mysqli_error($conn));
}

$popular_products = [];

while ($row = mysqli_fetch_assoc($result_popular)) {
  $popular_products[] = $row;
}

/*----------------------------------------------------
  3) Best Selling Products
  - Calculates the total number of delivered units sold for each product.
-----------------------------------------------------*/
$sql_best_selling = "SELECT 
    p.id AS id, 
    p.name AS name,
    p.description as description,
    p.image as image,
    p.sku as sku,
    p.regular_price as regular_price,
    p.discounted_price as discounted_price,

    SUM(od.qty) AS total_sold
FROM order_details od
JOIN orders o ON o.id = od.order_id
JOIN products p ON p.id = od.product_id
WHERE o.status = 'delivered'
GROUP BY p.id, p.name
ORDER BY total_sold DESC
LIMIT 4;
";

$result_best_selling = mysqli_query($conn, $sql_best_selling);

if (!$result_best_selling) {
  die("Error fetching best selling products: " . mysqli_error($conn));
}

$best_selling_products = [];

while ($row = mysqli_fetch_assoc($result_best_selling)) {
  $best_selling_products[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Draftsy</title>

  <?php
  include('../include/styles.php');
  ?>
  <style>
    .bg-shape {
      display: none !important;
    }


  </style>

</head>

<body>

  <?php
  include('../include/header.php');
  ?>

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
          <img src="https://wpocean.com/html/tf/pengu/assets/images/preloader.png" alt="">
        </div>
      </div>
    </div>
    <!-- end preloader -->


    <!-- start of wpo-hero-section-1 -->
    <section class="hero hero-style-4">
      <div class="hero-slider">
        <div class="slide">
          <div class="container">
            <div class="row">
              <div class="col col-lg-7 col-md-8 col-sm-12 slide-caption"  style="background: white; padding: 40px; border-radius: 20px;">
                <div class="slide-title">
                  <h2>High-Quality Stationary</h2>
                </div>
                <div class="slide-subtitle">
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Libero, vel, facilisis
                    purus,
                    turpis tincidunt vel. Aliquet egestas in nibh mattis.</p>
                </div>
                <div class="pordact-content">
                  <div class="filter-item">
                    <div class="shop-filter-item price">
                      <h3>Price :</h3>
                      <span><small>From</small> $20</span>
                    </div>
                  </div>
                  <!-- <div class="filter-item">
                    <div class="shop-filter-item color">
                      <h3>Color :</h3>
                      <div class="color-name">
                        <div>
                          <input type="radio" name="color" id="001" class="aggree color1" checked />
                          <span style="margin:5px"></span>
                          <input type="radio" name="color" class="aggree color2" />
                          <span style="margin:5px"> </span>
                          <input type="radio" name="color" class="aggree color3" />
                          <span style="margin:5px"> </span>
                          <input type="radio" name="color" class="aggree color4" />
                        </div>

                      </div>
                    </div>
                  </div>
                  <div class="filter-item">
                    <div class="shop-filter-item size">
                      <h3>Size :</h3>
                      <div class="size-item">
                        <div class="button-group">
                          <input type="radio" id="1" name="size" class="size1" value="1" />
                          <label class="size-btn" for="1">9</label>
                        </div>
                        <div class="button-group">
                          <input type="radio" id="2" name="size" class="size1" value="1" />
                          <label class="size-btn" for="2">10</label>
                        </div>
                        <div class="button-group">
                          <input type="radio" id="3" name="size" class="size1" value="1" />
                          <label class="size-btn" for="3">11</label>
                        </div>
                        <div class="button-group">
                          <input type="radio" id="4" name="size" class="size1" value="1" />
                          <label class="size-btn" for="4">12</label>
                        </div>
                        <div class="button-group">
                          <input type="radio" id="5" name="size" class="size1" value="1" />
                          <label class="size-btn" for="5">13</label>
                        </div>

                      </div>
                    </div>
                  </div> -->
                </div>
                <div class="hero-btn">
                  <a href="/user/pages/shop.php" class="theme-btn s1">40% Off</a>
                  <a href="/user/pages/shop.php" class="theme-btn">Shop Now</a>
                </div>
                <div class="slider-pic" style=" justify-content: center; align-items: center; left: 450px; top: 500px; box-shadow: 3px 20px 20px 20px #0000001a; height: auto; border-radius: 100px; top: 50%;">
                <img src="https://images.unsplash.com/photo-1494319827402-c4b839aed26b?q=80&amp;w=1738&amp;auto=format&amp;fit=crop&amp;ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="" style="width: 1000px; object-fit: cover;">
                </div>
                <div class="bg-shape"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="slide">
          <div class="container">
            <div class="row">
              <div class="col col-lg-7 col-md-8 col-sm-12 slide-caption">
                <div class="slide-title">
                  <h2>Sneakers For Women</h2>
                </div>
                <div class="slide-subtitle">
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Libero, vel, facilisis
                    purus,
                    turpis tincidunt vel. Aliquet egestas in nibh mattis.</p>
                </div>
                <div class="pordact-content">
                  <div class="filter-item">
                    <div class="shop-filter-item price">
                      <h3>Price :</h3>
                      <span>$25.60</span>
                    </div>
                  </div>
                  <div class="filter-item">
                    <div class="shop-filter-item color">
                      <h3>Color :</h3>
                      <div class="color-name">
                        <div>
                          <input type="radio" name="color" id="01" class="aggree color1" checked />
                          <span style="margin:5px"></span>
                          <input type="radio" name="color" class="aggree color2" />
                          <span style="margin:5px"> </span>
                          <input type="radio" name="color" class="aggree color3" />
                          <span style="margin:5px"> </span>
                          <input type="radio" name="color" class="aggree color4" />
                        </div>

                      </div>
                    </div>
                  </div>
                  <div class="filter-item">
                    <div class="shop-filter-item size">
                      <h3>Size :</h3>
                      <div class="size-item">
                        <div class="button-group">
                          <input type="radio" id="6" name="size" class="size1" value="1" />
                          <label class="size-btn" for="6">9</label>
                        </div>
                        <div class="button-group">
                          <input type="radio" id="7" name="size" class="size1" value="1" />
                          <label class="size-btn" for="7">10</label>
                        </div>
                        <div class="button-group">
                          <input type="radio" id="8" name="size" class="size1" value="1" />
                          <label class="size-btn" for="8">11</label>
                        </div>
                        <div class="button-group">
                          <input type="radio" id="9" name="size" class="size1" value="1" />
                          <label class="size-btn" for="9">12</label>
                        </div>
                        <div class="button-group">
                          <input type="radio" id="10" name="size" class="size1" value="1" />
                          <label class="size-btn" for="10">13</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="hero-btn">
                  <a href="shop.html" class="theme-btn s1">50% Off</a>
                  <a href="shop.html" class="theme-btn">Shop Now</a>
                </div>
                <div class="slider-pic">
                  <img src="https://wpocean.com/html/tf/pengu/assets/images/slider/9.png" alt>
                </div>
                <div class="bg-shape"></div>
              </div>
            </div>
          </div>
        </div> -->
      </div>
    </section>
    <!-- end of wpo-hero-section-1 -->

    <!-- start of pengu-product-section -->
    <section class="pengu-product-section section-padding">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 col-12">
            <div class="wpo-section-title">
              <h2>New Arrivals</h2>
              <p>Here is our new arrival products that you may like.</p>
            </div>
          </div>
        </div>
        <div class="product-wrap">
          <div class="row">
            <?php foreach ($latest_products as $l_product) { ?>
              <?= renderProduct($l_product, $user, 'col-lg-3 col-md-6 col-12') ?>
            <?php } ?>
            <!-- <div class="col-lg-3 col-md-6 col-12">
              <div class="product-single-item">
                <div class="image">
                  <img src="https://wpocean.com/html/tf/pengu/assets/images/product-single/1.jpg" alt="">
                  <div class="card-icon">
                    <a class="icon" href="wishlist.html">
                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                    </a>
                    <a class="icon-active" href="wishlist.html">
                      <i class="fa fa-heart" aria-hidden="true"></i>
                    </a>
                  </div>
                  <ul class="cart-wrap">
                    <li>
                      <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true"
                        title="Add To Cart"><i class="fi flaticon-shopping-cart"></i></a>
                    </li>
                    <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                      <button data-bs-toggle="tooltip" data-bs-html="true" title="Quick View"><i
                          class="fi ti-eye"></i></button>
                    </li>
                    <li>
                      <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true"
                        title="Compare"><i class="fa fa-compress" aria-hidden="true"></i></a>
                    </li>
                  </ul>
                  <div class="shop-btn">
                    <a class="product-btn" href="shop.html">Shop Now</a>
                  </div>
                </div>
                <div class="text">
                  <h2><a href="product-single.html">Long Sleeve Tops</a></h2>
                  <div class="price">
                    <del class="old-price">$85.50</del>
                    <span class="present-price">$70.30</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
              <div class="product-single-item active">
                <div class="image">
                  <img src="https://wpocean.com/html/tf/pengu/assets/images/product-single/2.jpg" alt="">
                  <div class="card-icon">
                    <a class="icon" href="wishlist.html">
                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                    </a>
                    <a class="icon-active" href="wishlist.html" data-bs-toggle="tooltip"
                      data-bs-html="true" title="Add To Wishlist">
                      <i class="fa fa-heart" aria-hidden="true"></i>
                    </a>
                  </div>
                  <ul class="cart-wrap">
                    <li>
                      <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true"
                        title="Add To Cart"><i class="fi flaticon-shopping-cart"></i></a>
                    </li>
                    <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                      <button data-bs-toggle="tooltip" data-bs-html="true" title="Quick View"><i
                          class="fi ti-eye"></i></button>
                    </li>
                    <li>
                      <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true"
                        title="Compare"><i class="fa fa-compress" aria-hidden="true"></i></a>
                    </li>
                  </ul>
                  <div class="shop-btn">
                    <a class="product-btn" href="shop.html">Shop Now</a>
                  </div>
                </div>
                <div class="text">
                  <h2><a href="product-single.html">White Wedding Shoe</a></h2>
                  <div class="price">
                    <del class="old-price">$150.20</del>
                    <span class="present-price">$120.50</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
              <div class="product-single-item">
                <div class="image">
                  <img src="https://wpocean.com/html/tf/pengu/assets/images/product-single/3.jpg" alt="">
                  <div class="card-icon">
                    <a class="icon" href="wishlist.html">
                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                    </a>
                    <a class="icon-active" href="wishlist.html">
                      <i class="fa fa-heart" aria-hidden="true"></i>
                    </a>
                  </div>
                  <ul class="cart-wrap">
                    <li>
                      <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true"
                        title="Add To Cart"><i class="fi flaticon-shopping-cart"></i></a>
                    </li>
                    <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                      <button data-bs-toggle="tooltip" data-bs-html="true" title="Quick View"><i
                          class="fi ti-eye"></i></button>
                    </li>
                    <li>
                      <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true"
                        title="Compare"><i class="fa fa-compress" aria-hidden="true"></i></a>
                    </li>
                  </ul>
                  <div class="shop-btn">
                    <a class="product-btn" href="shop.html">Shop Now</a>
                  </div>
                </div>
                <div class="text">
                  <h2><a href="product-single.html">Long Chain With Lockel</a></h2>
                  <div class="price">
                    <del class="old-price">$85.50</del>
                    <span class="present-price">$70.30</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
              <div class="product-single-item">
                <div class="image">
                  <img src="https://wpocean.com/html/tf/pengu/assets/images/product-single/4.jpg" alt="">
                  <div class="card-icon">
                    <a class="icon" href="wishlist.html">
                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                    </a>
                    <a class="icon-active" href="wishlist.html">
                      <i class="fa fa-heart" aria-hidden="true"></i>
                    </a>
                  </div>
                  <ul class="cart-wrap">
                    <li>
                      <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true"
                        title="Add To Cart"><i class="fi flaticon-shopping-cart"></i></a>
                    </li>
                    <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                      <button data-bs-toggle="tooltip" data-bs-html="true" title="Quick View"><i
                          class="fi ti-eye"></i></button>
                    </li>
                    <li>
                      <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true"
                        title="Compare"><i class="fa fa-compress" aria-hidden="true"></i></a>
                    </li>
                  </ul>
                  <div class="shop-btn">
                    <a class="product-btn" href="shop.html">Shop Now</a>
                  </div>
                </div>
                <div class="text">
                  <h2><a href="product-single.html">Winter Jacket</a></h2>
                  <div class="price">
                    <del class="old-price">$100.50</del>
                    <span class="present-price">$80.30</span>
                  </div>
                </div>
              </div>
            </div> -->
          </div>
        </div>
      </div>
    </section>
    <!-- end of pengu-product-section -->

    <!-- start of pengu-banner-section -->
    <section class="pengu-banner-section">
      <div class="container">
        <div class="banner-wrap">
          <div class="row">
            <div class="col-lg-7 col-md-9 col-12">
              <div class="content">
                <div class="bg-text">
                  <h1>Stationery</h1>
                </div>
                <h2>Premium Notebooks & Writing Essentials</h2>
                <p>Elegant, Functional, and High-Quality</p>
                <a href="/user/pages/shop.php">Shop Now</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- end of pengu-banner-section -->

    <!-- start of pengu-product-category-section -->
    <section class="pengu-product-category-section section-padding">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 col-12">
            <div class="wpo-section-title">
              <h2>Popular Products</h2>
              <p>Here are our most popular products collection that you may like.</p>
            </div>
          </div>
        </div>
        <div class="category-wrap">
          <div class="row">
            <div class="col col-xs-12 sortable-gallery">
              <div class="gallery-filters">
                <div class="row justify-content-center">
                  <div class="col-lg-6 col-12">
                    <!-- <ul class="category-item">
                      <li><a data-filter=".all" href="#" class="product-btn current">
                          All Products
                        </a>
                      </li>
                      <li>
                        <a data-filter=".men" href="#" class="product-btn">
                          Men
                        </a>
                      </li>
                      <li>
                        <a data-filter=".women" href="#" class="product-btn">
                          Women
                        </a>
                      </li>
                      <li><a data-filter=".kids" href="#" class="product-btn">
                          Kids
                        </a>
                      </li>
                      <li><a data-filter=".sales" href="#" class="product-btn">
                          Sales
                        </a>
                      </li>
                      <li><a data-filter=".offers" href="#" class="product-btn">
                          Offers
                        </a>
                      </li>
                    </ul> -->
                  </div>
                </div>
              </div>
              <div class="gallery-container gallery-fancybox masonry-gallery row">
                <?php foreach($popular_products as $p_product) { ?>
                  <?= renderProduct($p_product, $user, 'col-lg-3 col-md-6 col-12 custom-grid IllustAtor all sales women zoomIn') ?>
                <?php } ?>
                <!-- <div class="col-lg-3 col-md-6 col-12 custom-grid IllustAtor all sales women zoomIn" data-wow-duration="2000ms">
                  <div class="product-single-item">
                    <div class="image">
                      <img src="https://wpocean.com/html/tf/pengu/assets/images/product-category/1.jpg" alt="">
                      <div class="card-icon">
                        <a class="icon" href="wishlist.html">
                          <i class="fa fa-heart-o" aria-hidden="true"></i>
                        </a>
                        <a class="icon-active" href="wishlist.html">
                          <i class="fa fa-heart" aria-hidden="true"></i>
                        </a>
                      </div>
                      <ul class="cart-wrap">
                        <li>
                          <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true"
                            title="Add To Cart"><i
                              class="fi flaticon-shopping-cart"></i></a>
                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                          <button data-bs-toggle="tooltip" data-bs-html="true"
                            title="Quick View"><i class="fi ti-eye"></i></button>
                        </li>
                        <li>
                          <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true"
                            title="Compare"><i class="fa fa-compress"
                              aria-hidden="true"></i></a>
                        </li>
                      </ul>
                      <div class="shop-btn">
                        <a class="product-btn" href="shop.html">Shop Now</a>
                      </div>
                    </div>
                    <div class="text">
                      <h2><a href="product-single.html">Long Sleeve Tops</a></h2>
                      <div class="price">
                        <del class="old-price">$85.50</del>
                        <span class="present-price">$70.30</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 custom-grid all  women men offers kids zoomIn"
                  data-wow-duration="2000ms">
                  <div class="product-single-item">
                    <div class="image">
                      <img src="https://wpocean.com/html/tf/pengu/assets/images/product-category/2.jpg" alt="">
                      <div class="card-icon">
                        <a class="icon" href="wishlist.html">
                          <i class="fa fa-heart-o" aria-hidden="true"></i>
                        </a>
                        <a class="icon-active" href="wishlist.html">
                          <i class="fa fa-heart" aria-hidden="true"></i>
                        </a>
                      </div>
                      <ul class="cart-wrap">
                        <li>
                          <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true"
                            title="Add To Cart"><i
                              class="fi flaticon-shopping-cart"></i></a>
                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                          <button data-bs-toggle="tooltip" data-bs-html="true"
                            title="Quick View"><i class="fi ti-eye"></i></button>
                        </li>
                        <li>
                          <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true"
                            title="Compare"><i class="fa fa-compress"
                              aria-hidden="true"></i></a>
                        </li>
                      </ul>
                      <div class="shop-btn">
                        <a class="product-btn" href="shop.html">Shop Now</a>
                      </div>
                    </div>
                    <div class="text">
                      <h2><a href="product-single.html">White Wedding Shoe</a></h2>
                      <div class="price">
                        <del class="old-price">$150.50</del>
                        <span class="present-price">$120.30</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 custom-grid all women men offers kids zoomIn"
                  data-wow-duration="2000ms">
                  <div class="product-single-item">
                    <div class="image">
                      <img src="https://wpocean.com/html/tf/pengu/assets/images/product-category/3.jpg" alt="">
                      <div class="card-icon">
                        <a class="icon" href="wishlist.html">
                          <i class="fa fa-heart-o" aria-hidden="true"></i>
                        </a>
                        <a class="icon-active" href="wishlist.html">
                          <i class="fa fa-heart" aria-hidden="true"></i>
                        </a>
                      </div>
                      <ul class="cart-wrap">
                        <li>
                          <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true"
                            title="Add To Cart"><i
                              class="fi flaticon-shopping-cart"></i></a>
                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                          <button data-bs-toggle="tooltip" data-bs-html="true"
                            title="Quick View"><i class="fi ti-eye"></i></button>
                        </li>
                        <li>
                          <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true"
                            title="Compare"><i class="fa fa-compress"
                              aria-hidden="true"></i></a>
                        </li>
                      </ul>
                      <div class="shop-btn">
                        <a class="product-btn" href="shop.html">Shop Now</a>
                      </div>
                    </div>
                    <div class="text">
                      <h2><a href="product-single.html">Long Chain With Lockel</a></h2>
                      <div class="price">
                        <del class="old-price">$180.50</del>
                        <span class="present-price">$150.30</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 custom-grid women  kids all zoomIn"
                  data-wow-duration="2000ms">
                  <div class="product-single-item">
                    <div class="image">
                      <img src="https://wpocean.com/html/tf/pengu/assets/images/product-category/4.jpg" alt="">
                      <div class="card-icon">
                        <a class="icon" href="wishlist.html">
                          <i class="fa fa-heart-o" aria-hidden="true"></i>
                        </a>
                        <a class="icon-active" href="wishlist.html">
                          <i class="fa fa-heart" aria-hidden="true"></i>
                        </a>
                      </div>
                      <ul class="cart-wrap">
                        <li>
                          <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true"
                            title="Add To Cart"><i
                              class="fi flaticon-shopping-cart"></i></a>
                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                          <button data-bs-toggle="tooltip" data-bs-html="true"
                            title="Quick View"><i class="fi ti-eye"></i></button>
                        </li>
                        <li>
                          <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true"
                            title="Compare"><i class="fa fa-compress"
                              aria-hidden="true"></i></a>
                        </li>
                      </ul>
                      <div class="shop-btn">
                        <a class="product-btn" href="shop.html">Shop Now</a>
                      </div>
                    </div>
                    <div class="text">
                      <h2><a href="product-single.html">Winter Jacket </a></h2>
                      <div class="price">
                        <del class="old-price">$100.50</del>
                        <span class="present-price">$70.30</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 all custom-grid  women sales kidszoomIn"
                  data-wow-duration="2000ms">
                  <div class="product-single-item">
                    <div class="image">
                      <img src="https://wpocean.com/html/tf/pengu/assets/images/product-category/5.jpg" alt="">
                      <div class="card-icon">
                        <a class="icon" href="wishlist.html">
                          <i class="fa fa-heart-o" aria-hidden="true"></i>
                        </a>
                        <a class="icon-active" href="wishlist.html">
                          <i class="fa fa-heart" aria-hidden="true"></i>
                        </a>
                      </div>
                      <ul class="cart-wrap">
                        <li>
                          <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true"
                            title="Add To Cart"><i
                              class="fi flaticon-shopping-cart"></i></a>
                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                          <button data-bs-toggle="tooltip" data-bs-html="true"
                            title="Quick View"><i class="fi ti-eye"></i></button>
                        </li>
                        <li>
                          <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true"
                            title="Compare"><i class="fa fa-compress"
                              aria-hidden="true"></i></a>
                        </li>
                      </ul>
                      <div class="shop-btn">
                        <a class="product-btn" href="shop.html">Shop Now</a>
                      </div>
                    </div>
                    <div class="text">
                      <h2><a href="product-single.html">Long Sleeve Tops</a></h2>
                      <div class="price">
                        <del class="old-price">$85.50</del>
                        <span class="present-price">$70.30</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 custom-grid all men offers zoomIn"
                  data-wow-duration="2000ms">
                  <div class="product-single-item">
                    <div class="image">
                      <img src="https://wpocean.com/html/tf/pengu/assets/images/product-category/6.jpg" alt="">
                      <div class="card-icon">
                        <a class="icon" href="wishlist.html">
                          <i class="fa fa-heart-o" aria-hidden="true"></i>
                        </a>
                        <a class="icon-active" href="wishlist.html">
                          <i class="fa fa-heart" aria-hidden="true"></i>
                        </a>
                      </div>
                      <ul class="cart-wrap">
                        <li>
                          <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true"
                            title="Add To Cart"><i
                              class="fi flaticon-shopping-cart"></i></a>
                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                          <button data-bs-toggle="tooltip" data-bs-html="true"
                            title="Quick View"><i class="fi ti-eye"></i></button>
                        </li>
                        <li>
                          <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true"
                            title="Compare"><i class="fa fa-compress"
                              aria-hidden="true"></i></a>
                        </li>
                      </ul>
                      <div class="shop-btn">
                        <a class="product-btn" href="shop.html">Shop Now</a>
                      </div>
                    </div>
                    <div class="text">
                      <h2><a href="product-single.html">White Wedding Shoe</a></h2>
                      <div class="price">
                        <del class="old-price">$120.50</del>
                        <span class="present-price">$100.30</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 custom-grid all  men  zoomIn"
                  data-wow-duration="2000ms">
                  <div class="product-single-item">
                    <div class="image">
                      <img src="https://wpocean.com/html/tf/pengu/assets/images/product-category/7.jpg" alt="">
                      <div class="card-icon">
                        <a class="icon" href="wishlist.html">
                          <i class="fa fa-heart-o" aria-hidden="true"></i>
                        </a>
                        <a class="icon-active" href="wishlist.html">
                          <i class="fa fa-heart" aria-hidden="true"></i>
                        </a>
                      </div>
                      <ul class="cart-wrap">
                        <li>
                          <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true"
                            title="Add To Cart"><i
                              class="fi flaticon-shopping-cart"></i></a>
                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                          <button data-bs-toggle="tooltip" data-bs-html="true"
                            title="Quick View"><i class="fi ti-eye"></i></button>
                        </li>
                        <li>
                          <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true"
                            title="Compare"><i class="fa fa-compress"
                              aria-hidden="true"></i></a>
                        </li>
                      </ul>
                      <div class="shop-btn">
                        <a class="product-btn" href="shop.html">Shop Now</a>
                      </div>
                    </div>
                    <div class="text">
                      <h2><a href="product-single.html">Long Chain With Lockel</a></h2>
                      <div class="price">
                        <del class="old-price">$150.50</del>
                        <span class="present-price">$130.30</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 custom-grid all  men  zoomIn"
                  data-wow-duration="2000ms">
                  <div class="product-single-item">
                    <div class="image">
                      <img src="https://wpocean.com/html/tf/pengu/assets/images/product-category/8.jpg" alt="">
                      <div class="card-icon">
                        <a class="icon" href="wishlist.html">
                          <i class="fa fa-heart-o" aria-hidden="true"></i>
                        </a>
                        <a class="icon-active" href="wishlist.html">
                          <i class="fa fa-heart" aria-hidden="true"></i>
                        </a>
                      </div>
                      <ul class="cart-wrap">
                        <li>
                          <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true"
                            title="Add To Cart"><i
                              class="fi flaticon-shopping-cart"></i></a>
                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                          <button data-bs-toggle="tooltip" data-bs-html="true"
                            title="Quick View"><i class="fi ti-eye"></i></button>
                        </li>
                        <li>
                          <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true"
                            title="Compare"><i class="fa fa-compress"
                              aria-hidden="true"></i></a>
                        </li>
                      </ul>
                      <div class="shop-btn">
                        <a class="product-btn" href="shop.html">Shop Now</a>
                      </div>
                    </div>
                    <div class="text">
                      <h2><a href="product-single.html">Winter Jacket </a></h2>
                      <div class="price">
                        <del class="old-price">$100.50</del>
                        <span class="present-price">$70.30</span>
                      </div>
                    </div>
                  </div>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- end of pengu-product-category-section -->

    <!-- start of pengu-spacing-section -->
    <section class="pengu-spacing-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-12">
            <div class="lookbook-benner">
              <div class="bg-image">
                <img src="/user/assets/img/pens.jpg" alt="">
              </div>
              <div class="content" style="padding: 20px 20px;background: #00000026;">
                <h2>High-Quality Stationary</h2>
                <p>Best quality stationary supplies</p>
                <a class="theme-btn" href="/user/pages/shop.php">View Collection</a>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-12">
            <div class="winter-benner">
              <div class="bg-image">
                <img src="/user/assets/img/art-supply.jpg">
              </div>
              <div class="content">
                <span>Art Supply</span>
                <h2>Big Discounts</h2>
                <a class="theme-btn" href="/user/pages/shop.php">Shop Now</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- end of pengu-spacing-section -->

    <!-- start of pengu-bestseller-section -->
    <section class="pengu-bestseller-section section-padding">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 col-12">
            <div class="wpo-section-title">
              <h2>Best Seller</h2>
              <p>Top products in this season.</p>
            </div>
          </div>
        </div>
        <div class="bestseller-wrap">
          <div class="row">
            <?php foreach ($best_selling_products as $b_product) { ?>
              <?= renderProduct($b_product, $user, 'col-lg-3 col-md-6 col-12') ?>
            <?php } ?>
            <!-- <div class="col-lg-3 col-md-6 col-12">
              <div class="product-single-item">
                <div class="image">
                  <img src="https://wpocean.com/html/tf/pengu/assets/images/bestseller/img-1.jpg" alt="">
                  <div class="card-icon">
                    <a class="icon" href="wishlist.html">
                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                    </a>
                    <a class="icon-active" href="wishlist.html">
                      <i class="fa fa-heart" aria-hidden="true"></i>
                    </a>
                  </div>
                  <ul class="cart-wrap">
                    <li>
                      <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true"
                        title="Add To Cart"><i class="fi flaticon-shopping-cart"></i></a>
                    </li>
                    <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                      <button data-bs-toggle="tooltip" data-bs-html="true" title="Quick View"><i
                          class="fi ti-eye"></i></button>
                    </li>
                    <li>
                      <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true"
                        title="Compare"><i class="fa fa-compress" aria-hidden="true"></i></a>
                    </li>
                  </ul>
                  <div class="shop-btn">
                    <a class="product-btn" href="shop.html">Shop Now</a>
                  </div>
                </div>
                <div class="text">
                  <h2><a href="product-single.html">Long Sleeve Tops</a></h2>
                  <div class="price">
                    <del class="old-price">$850.50</del>
                    <span class="present-price">$70.30</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
              <div class="product-single-item">
                <div class="image">
                  <img src="https://wpocean.com/html/tf/pengu/assets/images/bestseller/img-2.jpg" alt="">
                  <div class="card-icon">
                    <a class="icon" href="wishlist.html">
                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                    </a>
                    <a class="icon-active" href="wishlist.html">
                      <i class="fa fa-heart" aria-hidden="true"></i>
                    </a>
                  </div>
                  <ul class="cart-wrap">
                    <li>
                      <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true"
                        title="Add To Cart"><i class="fi flaticon-shopping-cart"></i></a>
                    </li>
                    <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                      <button data-bs-toggle="tooltip" data-bs-html="true" title="Quick View"><i
                          class="fi ti-eye"></i></button>
                    </li>
                    <li>
                      <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true"
                        title="Compare"><i class="fa fa-compress" aria-hidden="true"></i></a>
                    </li>
                  </ul>
                  <div class="shop-btn">
                    <a class="product-btn" href="shop.html">Shop Now</a>
                  </div>
                </div>
                <div class="text">
                  <h2><a href="product-single.html">White Wedding Shoe</a></h2>
                  <div class="price">
                    <del class="old-price">$150.50</del>
                    <span class="present-price">$120.30</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
              <div class="product-single-item">
                <div class="image">
                  <img src="https://wpocean.com/html/tf/pengu/assets/images/bestseller/img-3.jpg" alt="">
                  <div class="card-icon">
                    <a class="icon" href="wishlist.html">
                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                    </a>
                    <a class="icon-active" href="wishlist.html">
                      <i class="fa fa-heart" aria-hidden="true"></i>
                    </a>
                  </div>
                  <ul class="cart-wrap">
                    <li>
                      <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true"
                        title="Add To Cart"><i class="fi flaticon-shopping-cart"></i></a>
                    </li>
                    <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                      <button data-bs-toggle="tooltip" data-bs-html="true" title="Quick View"><i
                          class="fi ti-eye"></i></button>
                    </li>
                    <li>
                      <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true"
                        title="Compare"><i class="fa fa-compress" aria-hidden="true"></i></a>
                    </li>
                  </ul>
                  <div class="shop-btn">
                    <a class="product-btn" href="shop.html">Shop Now</a>
                  </div>
                </div>
                <div class="text">
                  <h2><a href="product-single.html">Long Chain With Lockel</a></h2>
                  <div class="price">
                    <del class="old-price">$85.50</del>
                    <span class="present-price">$60.30</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
              <div class="product-single-item">
                <div class="image">
                  <img src="https://wpocean.com/html/tf/pengu/assets/images/bestseller/img-4.jpg" alt="">
                  <div class="card-icon">
                    <a class="icon" href="wishlist.html">
                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                    </a>
                    <a class="icon-active" href="wishlist.html">
                      <i class="fa fa-heart" aria-hidden="true"></i>
                    </a>
                  </div>
                  <ul class="cart-wrap">
                    <li>
                      <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true"
                        title="Add To Cart"><i class="fi flaticon-shopping-cart"></i></a>
                    </li>
                    <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                      <button data-bs-toggle="tooltip" data-bs-html="true" title="Quick View"><i
                          class="fi ti-eye"></i></button>
                    </li>
                    <li>
                      <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true"
                        title="Compare"><i class="fa fa-compress" aria-hidden="true"></i></a>
                    </li>
                  </ul>
                  <div class="shop-btn">
                    <a class="product-btn" href="shop.html">Shop Now</a>
                  </div>
                </div>
                <div class="text">
                  <h2><a href="product-single.html">Winter Jacket</a></h2>
                  <div class="price">
                    <del class="old-price">$100.50</del>
                    <span class="present-price">$80.30</span>
                  </div>
                </div>
              </div>
            </div> -->
          </div>
        </div>
      </div>

    </section>
    <!-- end of pengu-bestseller-section -->

    <!-- start of wpo-blog-section -->
    <!-- <section class="wpo-blog-section section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-12">
                        <div class="wpo-section-title">
                            <h2>Latest News</h2>
                            <p>Here is our top newses for your fasion guide.</p>
                        </div>
                    </div>
                </div>
                <div class="blog-wrap">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="blog-item">
                                <div class="post-image">
                                    <div class="post-img-title">
                                        <span>Fasion</span>
                                    </div>
                                    <img src="https://wpocean.com/html/tf/pengu/assets/images/blog/img-1.jpg" alt="">
                                </div>
                                <div class="post-content">
                                    <ul class="post-date">
                                        <li>By Jastin Wastal</li>
                                        <li>15 Sep 2023</li>
                                    </ul>
                                    <h2><a href="blog-single.html">New season modern scarf</a></h2>
                                    <p>Etiam facisis urna dignissim dui quisque in mauris viverra Nulla placerat
                                        suscipit integer enim.</p>
                                    <a class="post-btn" href="blog-single.html">Read More...</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="blog-item">
                                <div class="post-image">
                                    <div class="post-img-title">
                                        <span>Trending</span>
                                    </div>
                                    <img src="https://wpocean.com/html/tf/pengu/assets/images/blog/img-2.jpg" alt="">
                                </div>
                                <div class="post-content">
                                    <ul class="post-date">
                                        <li>By Jastin Wastal</li>
                                        <li>20 Sep 2023</li>
                                    </ul>
                                    <h2><a href="blog-single.html">Summer Trending 2023</a></h2>
                                    <p>Etiam facisis urna dignissim dui quisque in mauris viverra Nulla placerat
                                        suscipit integer enim.</p>
                                    <a class="post-btn" href="blog-single.html">Read More...</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="blog-item">
                                <div class="post-image">
                                    <div class="post-img-title">
                                        <span>Lifestyle</span>
                                    </div>
                                    <img src="https://wpocean.com/html/tf/pengu/assets/images/blog/img-3.jpg" alt="">
                                </div>
                                <div class="post-content">
                                    <ul class="post-date">
                                        <li>By Jastin Wastal</li>
                                        <li>25 Sep 2023</li>
                                    </ul>
                                    <h2><a href="blog-single.html">Top 10 Curley Hairstyle</a></h2>
                                    <p>Etiam facisis urna dignissim dui quisque in mauris viverra Nulla placerat
                                        suscipit integer enim.</p>
                                    <a class="post-btn" href="blog-single.html">Read More...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
    <!-- end of wpo-blog-section -->

    <!-- start of wpo-site-footer-section -->


    <!-- popup-quickview  -->
    <div id="popup-quickview" class="modal fade" tabindex="-1">
      <div class="modal-dialog quickview-dialog">
        <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
              class="ti-close"></i></button>
          <div class="modal-body d-flex">
            <div class="product-details">
              <div class="row align-items-center">
                <div class="col-lg-5">
                  <div class="product-single-img">
                    <div class="modal-product">
                      <div class="item">
                        <img src="https://wpocean.com/html/tf/pengu/assets/images/modal.jpg" alt="">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-7">
                  <div class="product-single-content">
                    <h5>White Wedding Shoe</h5>
                    <h6>120.00 USD</h6>
                    <ul class="rating">
                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                    </ul>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quis ultrices
                      lectus lobortis, dolor et tempus porta, leo mi efficitur ante, in varius
                      felis
                      sem ut mauris. Proin volutpat lorem inorci sed vestibulum tempus. Lorem
                      ipsum
                      dolor sit amet, consectetur adipiscing elit. Aliquam
                      hendrerit.
                    </p>
                    <div class="pro-single-btn">
                      <div class="quantity cart-plus-minus">
                        <input type="text" value="1">
                        <div class="dec qtybutton">-</div>
                        <div class="inc qtybutton"></div>
                      </div>
                      <a href="#" class="theme-btn">Add to cart</a>
                    </div>
                    <div class="social-share">
                      <span>Share with : </span>
                      <ul class="socialLinks">
                        <li><a href='#'><i class="fa fa-facebook"></i></a></li>
                        <li><a href='#'><i class="fa fa-linkedin"></i></a></li>
                        <li><a href='#'><i class="fa fa-twitter"></i></a></li>
                        <li><a href='#'><i class="fa fa-instagram"></i></a></li>
                        <li><a href='#'><i class="fa fa-youtube-play"></i></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- popup-quickview -->
    </div>
    <?php
    include('../include/footer.php');

    ?>

  </div>
  <!-- end of page-wrapper -->

  <?php
  include('../include/scripts.php');

  ?>

</body>

</html>