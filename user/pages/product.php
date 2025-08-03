<?php
include_once '../include/user.php';
include '../include/helper.php';

if (!$user_logged_in) {
  header("Location: /user/pages/login.php?ref=/user/pages/shop.php");
  die();
}

if (!isset($_GET['product_id'])) {
  echo "Product ID is required.";
  exit;
}

$product_id = intval($_GET['product_id']); // Get product_id from URL

// Query: Get Single Product + Category
$productQuery = "SELECT 
                  p.*, 
                  c.name AS category_name, 
                  c.image AS category_image, 
                  c.description AS category_description
                FROM products p
                JOIN categories c ON p.cat_id = c.id
                WHERE p.id = ?
";
$productStmt = mysqli_prepare($conn, $productQuery);
mysqli_stmt_bind_param($productStmt, "i", $product_id);
mysqli_stmt_execute($productStmt);
$productResult = mysqli_stmt_get_result($productStmt);
$product = mysqli_fetch_assoc($productResult);

if (!$product) {
  echo "Product not found.";
  exit;
}

// Query: Get Product Details
$productDetailsQuery = "SELECT * FROM product_details WHERE prod_id = ?";
$productDetailsStmt = mysqli_prepare($conn, $productDetailsQuery);
mysqli_stmt_bind_param($productDetailsStmt, "i", $product_id);
mysqli_stmt_execute($productDetailsStmt);
$productDetailsResult = mysqli_stmt_get_result($productDetailsStmt);
$productDetails = mysqli_fetch_assoc($productDetailsResult);

// Query: Get Product Images
$productImagesQuery = "SELECT images FROM product_images WHERE prod_id = ?";
$productImagesStmt = mysqli_prepare($conn, $productImagesQuery);
mysqli_stmt_bind_param($productImagesStmt, "i", $product_id);
mysqli_stmt_execute($productImagesStmt);
$productImagesResult = mysqli_stmt_get_result($productImagesStmt);
$productImages = [];
while ($row = mysqli_fetch_assoc($productImagesResult)) {
  $productImages[] = $row['images'];
}

// Query: Get Product Reviews + Customer Names
$productReviewsQuery = "SELECT pr.*, c.name AS customer_name
    FROM product_reviews pr
    JOIN customers c ON pr.customer_id = c.id
    WHERE pr.prod_id = ? AND pr.status = 'approved'
";
$productReviewsStmt = mysqli_prepare($conn, $productReviewsQuery);
mysqli_stmt_bind_param($productReviewsStmt, "i", $product_id);
mysqli_stmt_execute($productReviewsStmt);
$productReviewsResult = mysqli_stmt_get_result($productReviewsStmt);
$productReviews = [];
while ($row = mysqli_fetch_assoc($productReviewsResult)) {
  $productReviews[] = $row;
}

// Fetch average rating from product_reviews
$ratingQuery = "SELECT COALESCE(AVG(rating), 0) AS avg_rating
                FROM product_reviews WHERE prod_id = ?
                AND status = 'approved'
";
$ratingStmt = mysqli_prepare($conn, $ratingQuery);
mysqli_stmt_bind_param($ratingStmt, "i", $product_id);
mysqli_stmt_execute($ratingStmt);
$ratingResult = mysqli_stmt_get_result($ratingStmt);
$rating = mysqli_fetch_assoc($ratingResult);
$avg_rating = round($rating['avg_rating'], 1);

// Query: Get Related Products (Same Category)
$relatedProductsQuery = "SELECT * FROM products WHERE cat_id = ? AND id != ? LIMIT 4";
$relatedProductsStmt = mysqli_prepare($conn, $relatedProductsQuery);
mysqli_stmt_bind_param($relatedProductsStmt, "ii", $product['cat_id'], $product_id);
mysqli_stmt_execute($relatedProductsStmt);
$relatedProductsResult = mysqli_stmt_get_result($relatedProductsStmt);
$relatedProducts = [];
while ($row = mysqli_fetch_assoc($relatedProductsResult)) {
  $relatedProducts[] = $row;
}

$customer_id = $user['id'];

// Query to check if the user has already reviewed the product
$checkReviewQuery = "SELECT id FROM product_reviews WHERE prod_id = ? AND customer_id = ?";
$checkReviewStmt = mysqli_prepare($conn, $checkReviewQuery);
mysqli_stmt_bind_param($checkReviewStmt, "ii", $product_id, $user['id']);
mysqli_stmt_execute($checkReviewStmt);
$checkReviewResult = mysqli_stmt_get_result($checkReviewStmt);

// Query to check if the user has ordered this product
$checkPurchaseQuery = "SELECT od.id FROM order_details od 
  JOIN orders o ON od.order_id = o.id
  WHERE o.customer_id = ? AND od.product_id = ? AND o.status = 'delivered'
";
$checkPurchaseStmt = mysqli_prepare($conn, $checkPurchaseQuery);
mysqli_stmt_bind_param($checkPurchaseStmt, "ii", $customer_id, $product_id);
mysqli_stmt_execute($checkPurchaseStmt);
$checkPurchaseResult = mysqli_stmt_get_result($checkPurchaseStmt);


// if the user has purchased the product and not reviewed it yet
if (mysqli_num_rows($checkPurchaseResult) > 0) {
  // The user has purchased the product
  if (mysqli_num_rows($checkReviewResult) > 0) {
      // If the user has already reviewed the product, hide the form
      $productReviewedByUser = true;
  } else {
      // The user has not reviewed the product, show the form
      $productReviewedByUser = false;
  }
} else {
  // The user has not purchased the product, hide the form
  $productReviewedByUser = true; // set this to true to hide the form and inform the user
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title> <?= $product['name'] ?> - Draftsy </title>
  <?php
  include('../include/styles.php');
  ?>
  <style>
    .search--btn {
      background: #ffc4c4;
      height: 40px;
      width: 100%;
      margin-top: 10px;
      text-align: center;
      transition: 0.5s ease;
    }

    .search--btn:hover {
      background: #ff8e8e;
      color: white;
    }

    .search--btn:focus {
      box-shadow: none !important;
    }

    .quantity .qtybutton {
      user-select: none;
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
          <img src="https://wpocean.com/html/tf/pengu/assets/images/preloader.png" alt="">
        </div>
      </div>
    </div>
    <!-- end preloader -->

    <!-- Start header -->
    <?php
    include('../include/header.php');
    ?>
    <!-- end of header -->

    <!-- start wpo-page-title -->
    <!-- <section class="wpo-page-title">
      <div class="container">
        <div class="row">
          <div class="col col-xs-12">
            <div class="wpo-breadcumb-wrap">
              <h2>Product Single</h2>
              <ol class="wpo-breadcumb-wrap">
                <li><a href="/user/pages/index.php">Home</a></li>
                <li>Product</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </section> -->
    <!-- end page-title -->

    <!-- product-single-section  start-->
    <div class="product-single-section section-padding">
      <div class="container">
        <div class="product-details">
          <div class="row align-items-center">
            <div class="col-lg-5">
              <div class="product-single-img">
                <div class="product-active owl-carousel owl-loaded owl-drag">
                  <div class="owl-stage-outer">
                    <div class="owl-stage" style="transform: translate3d(-527px, 0px, 0px); transition: 0.5s; width: 2638px;">
                      <div class="owl-item" style="width: 527.5px;">
                          <div class="item" style="position: relative; overflow: hidden;">
                            <img src="<?= USER_IMAGES_PATH . '/' . $product['image'] ?? '' ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="object-fit: contain;" onerror="this.src = '/user/assets/no-img.jpg';" />
                            <img role="presentation" src="<?= $product['image'] ?? '' ?>" alt="<?= htmlspecialchars($product['name']) ?>" onerror="this.src = '/user/assets/no-img.jpg';" class="zoomImg" style="position: absolute; top: -131.787px; left: -135.629px; opacity: 0; width: 700px; height: 700px; border: medium; max-width: none; max-height: none;">
                          </div>
                        </div>
                      <!-- <?php foreach ($productImages as $image) : ?>
                        <div class="owl-item" style="width: 527.5px;">
                          <div class="item" style="position: relative; overflow: hidden;">
                            <img src="../..<?= $image ?? '' ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="object-fit: contain;" onerror="this.src = '/user/assets/no-img.jpg';" />
                            <img role="presentation" src="<?= $image ?? '' ?>" alt="<?= htmlspecialchars($product['name']) ?>" onerror="this.src = '/user/assets/no-img.jpg';" class="zoomImg" style="position: absolute; top: -131.787px; left: -135.629px; opacity: 0; width: 700px; height: 700px; border: medium; max-width: none; max-height: none;">
                          </div>
                        </div>
                      <?php endforeach; ?> -->
                     
                    </div>
                  </div>
                  <div class="owl-nav disabled"><button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button><button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button></div>
                  <div class="owl-dots disabled"></div>
                </div>
                <div class="product-thumbnil-active owl-carousel owl-loaded owl-drag" style="display: <?= (count($productImages) > 1) ? '' : 'none' ?> !important;">
                  <div class="owl-stage-outer">
                    <div class="owl-stage" style="transform: translate3d(-134px, 0px, 0px); transition: 0.25s; width: 672px;">
                      <?php foreach ($productImages as $image) : ?>
                        <div class="owl-item" style="width: 124.375px; margin-right: 10px;">
                          <div class="item">
                            <img src="<?= USER_IMAGES_PATH . '/' . $image ?? '' ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="object-fit: contain;" onerror="this.src = '/user/assets/no-img.jpg';">
                          </div>
                        </div>
                      <?php endforeach; ?>

                     
                    </div>
                  </div>
                  <div class="owl-nav"><button type="button" role="presentation" class="owl-prev"><i class="fa fa-angle-double-left"></i></button><button type="button" role="presentation" class="owl-next disabled"><i class="fa fa-angle-double-right"></i></button></div>
                  <div class="owl-dots disabled"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-7">
              <div class="product-single-content">
                <h5><?= htmlspecialchars($product['name']) ?></h5>
                <h6><?= htmlspecialchars($product['discounted_price'] ?? $product['regular_price']) ?> USD</h6>

                <ul class="rating">
                  <?php
                  $fullStars = floor($avg_rating); // Whole stars
                  $halfStar = ($avg_rating - $fullStars) >= 0.5 ? 1 : 0; // Half star logic
                  $emptyStars = 5 - ($fullStars + $halfStar); // Remaining empty stars

                  // Full stars
                  for ($i = 0; $i < $fullStars; $i++) { ?>
                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                  <?php }

                  // Half star
                  if ($halfStar) { ?>
                    <li><i class="fa fa-star-half-o" aria-hidden="true"></i></li>
                  <?php }

                  // Empty stars
                  for ($i = 0; $i < $emptyStars; $i++) { ?>
                    <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                  <?php } ?>
                </ul>

                <p><?= htmlspecialchars($product['description']) ?></p>

                <div class="pro-single-btn">
                  <div class="quantity cart-plus-minus">
                    <input id="add-to-cart--amount" type="number" value="1" min="1">
                    <div class="dec qtybutton"></div>
                    <div class="inc qtybutton"></div>
                    <div class="dec qtybutton">-</div>
                    <div class="inc qtybutton">+</div>
                  </div>
                  <button id="add-to-cart--btn" type="button" class="theme-btn">Add to cart</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="product-tab-area">
          <ul class="nav nav-mb-3 main-tab" id="tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="descripton-tab" data-bs-toggle="pill" data-bs-target="#descripton" type="button" role="tab" aria-controls="descripton" aria-selected="false">Descripton</button>
            </li>
            <!-- <li class="nav-item" role="presentation">
              <button class="nav-link" id="Information-tab" data-bs-toggle="pill" data-bs-target="#Information" type="button" role="tab" aria-controls="Information" aria-selected="false">Additional Information</button>
            </li> -->
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="Ratings-tab" data-bs-toggle="pill" data-bs-target="#Ratings" type="button" role="tab" aria-controls="Ratings" aria-selected="true">Ratings</button>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade" id="descripton" role="tabpanel" aria-labelledby="descripton-tab">
              <div class="container">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="Descriptions-item">
                      <p><?= htmlspecialchars($product['description']) ?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade active show" id="Ratings" role="tabpanel" aria-labelledby="Ratings-tab">
              <div class="container">
                <div class="rating-section">
                  <div class="row">
                    <div class="col-lg-10 offset-lg-2">
                      <div class="rating-top">
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="rating-sub">
                              <ul>
                                <?php
                                $fullStars = floor($avg_rating); // Whole stars
                                $halfStar = ($avg_rating - $fullStars) >= 0.5 ? 1 : 0; // Half star logic
                                $emptyStars = 5 - ($fullStars + $halfStar); // Remaining empty stars

                                // Full stars
                                for ($i = 0; $i < $fullStars; $i++) { ?>
                                  <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <?php }

                                // Half star
                                if ($halfStar) { ?>
                                  <li><i class="fa fa-star-half-o" aria-hidden="true"></i></li>
                                <?php }

                                // Empty stars
                                for ($i = 0; $i < $emptyStars; $i++) { ?>
                                  <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                <?php } ?>
                              </ul>
                              <span>( Based on <?= count($productReviews) ?> reviews )</span>
                            </div>
                          </div>
                          <div class="col-lg-8">
                            <!-- <div class="rating-right">
                              <div class="rating-right-item">
                                <ul>
                                  <li>
                                    <ul>
                                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                    </ul>
                                  </li>
                                  <li>
                                    <div class="progress">
                                      <div class="bar" style="width:70%">
                                      </div>
                                    </div>
                                  </li>
                                  <li>70% ( 32.10k)</li>
                                </ul>
                              </div>
                              <div class="rating-right-item">
                                <ul>
                                  <li>
                                    <ul>
                                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                    </ul>
                                  </li>
                                  <li>
                                    <div class="progress">
                                      <div class="bar" style="width:60%">
                                      </div>
                                    </div>
                                  </li>
                                  <li>15% (6.88k)</li>
                                </ul>
                              </div>
                              <div class="rating-right-item">
                                <ul>
                                  <li>
                                    <ul>
                                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                    </ul>
                                  </li>
                                  <li>
                                    <div class="progress">
                                      <div class="bar" style="width:40%">
                                      </div>
                                    </div>
                                  </li>
                                  <li>10% ( 4.55k)</li>
                                </ul>
                              </div>
                              <div class="rating-right-item">
                                <ul>
                                  <li>
                                    <ul>
                                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                    </ul>
                                  </li>
                                  <li>
                                    <div class="progress">
                                      <div class="bar" style="width:20%">
                                      </div>
                                    </div>
                                  </li>
                                  <li>5% (2.29k)</li>
                                </ul>
                              </div>
                              <div class="rating-right-item">
                                <ul>
                                  <li>
                                    <ul>
                                      <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                      <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                    </ul>
                                  </li>
                                  <li>
                                    <div class="progress">
                                      <div class="bar" style="width:0">
                                      </div>
                                    </div>
                                  </li>
                                  <li>0% ( 0.00)</li>
                                </ul>
                              </div>
                            </div> -->
                            <?php

                            $productReviewsCopy = $productReviews;

                            usort($productReviewsCopy, function ($a, $b) {
                              return $b['rating'] - $a['rating'];
                            });

                            $totalReviews = count($productReviewsCopy);

                            $ratingsCount = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

                            foreach ($productReviewsCopy as $review) {
                              if(isset($ratingsCount[$review['rating']])) {
                                $ratingsCount[$review['rating']]++;
                              }                             
                            }

                            $ratingsPercentage = [];
                            foreach ($ratingsCount as $stars => $count) {
                              $ratingsPercentage[$stars] = ($totalReviews > 0) ? round(($count / $totalReviews) * 100) : 0;
                            }
                            ?>
                            <div class="rating-right">
                              <?php for ($i = 5; $i >= 1; $i--): ?>
                                <div class="rating-right-item">
                                  <ul>
                                    <li>
                                      <ul>
                                        <?php for ($j = 1; $j <= 5; $j++): ?>
                                          <li>
                                            <i class="fa <?= $j <= $i ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                                          </li>
                                        <?php endfor; ?>
                                      </ul>
                                    </li>
                                    <li>
                                      <div class="progress">
                                        <div class="bar" style="width:<?= $ratingsPercentage[$i] ?>%">
                                        </div>
                                      </div>
                                    </li>
                                    <li><?= $ratingsPercentage[$i] ?>% (<?= number_format($ratingsCount[$i]) ?>)</li>
                                  </ul>
                                </div>
                              <?php endfor; ?>
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12 col-12">
                      <div class="rating-bottom">
                        
                        <!-- <div class="write-review-btn">
                          <button class="theme-btn">Write A Review</button>
                        </div> -->

                        <div class="rating-give-section-items d-block">
                          <!-- <div class="review-btn-btn">
                            <button class="theme-btn s2">Cancel Review</button>
                          </div> -->
                          <?php if (!$productReviewedByUser) { ?>
                          <div class="rating-give-section">
                            <div class="rating-give-section-wrap">
                              <form action="/user/pages/submit_review.php" method="post">
                                <span>Give A Review</span>
                                <div class="give-rating">
                                  <label>
                                    <input type="radio" name="stars" value="1">
                                    <span class="icon">★</span>
                                  </label>
                                  <label>
                                    <input type="radio" name="stars" value="2">
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                  </label>
                                  <label>
                                    <input type="radio" name="stars" value="3">
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                  </label>
                                  <label>
                                    <input type="radio" name="stars" value="4">
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                  </label>
                                  <label>
                                    <input type="radio" name="stars" value="5">
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                  </label>
                                </div>
                                
                                <div class="form-group">
                                  <input type="hidden" name="customer_id" value="<?= $user['id'] ?>">
                                  <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                  <textarea name="review" id="rv" cols="30" rows="10" placeholder="Your Review..." required></textarea>
                                </div>

                                <div class="form-group">
                                  <button type="submit" class="theme-btn">Submit Review</button>
                                </div>
                              </form>
                            </div>
                          </div>
                          <?php } ?>
                        </div>

                        <div class="review-rating-wrap">
                          <?php foreach ($productReviews as $review) { ?>
                            <div class="rating-review">
                              <div class="rating-review-author">
                                <!-- <div class="rating-review-author-img">
                                  <img src="https://wpocean.com/html/tf/pengu/assets/images/product-details/author.png" alt="">
                                </div> -->

                                <div class="rating-review-author-text">
                                  <p class="text-start"><strong><?= htmlspecialchars($review['customer_name']); ?></strong></p>
                                  <div class="rating-review-author-text-inner">
                                    <?php if (isset($review['rating']) && !empty($review['rating'])) { ?>
                                      <ul class="ratting me-2">
                                        <?php
                                        $filledStars = round($review['rating']); // Number of filled stars
                                        $emptyStars = 5 - $filledStars; // Remaining empty stars

                                        // Loop for filled stars
                                        for ($i = 0; $i < $filledStars; $i++) { ?>
                                          <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <?php } ?>

                                        <!-- Loop for empty stars -->
                                        <?php for ($i = 0; $i < $emptyStars; $i++) { ?>
                                          <li><i class="fa fa-star-o" aria-hidden="true"></i></li> <!-- Empty star -->
                                        <?php } ?>
                                      </ul>
                                    <?php } ?>

                                    <span><?= htmlspecialchars(date('d/m/Y', strtotime($product['created_at']))); ?></span>
                                  </div>
                                </div>
                              </div>
                              <p class="text-start"><?= htmlspecialchars($review['review']); ?></p>
                            </div>
                          <?php } ?>
                          <!-- <div class="rating-review">
                            <a href="#">Load More</a>
                          </div> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="tab-pane fade" id="Information" role="tabpanel" aria-labelledby="Information-tab">
              <div class="container">
                <div class="Additional-wrap">
                  <div class="row">
                    <div class="col-12">
                      <table class="table-responsive">
                        <tbody>
                          <tr>
                            <td>Ratings</td>
                            <td class="ratting">
                              <ul>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star-half-o" aria-hidden="true"></i>
                                </li>
                                <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                              </ul>
                            </td>
                          </tr>
                          <tr>
                            <td>Material Type</td>
                            <td>Man</td>
                          </tr>
                          <tr>
                            <td>weight</td>
                            <td>250 gm</td>
                          </tr>
                          <tr>
                            <td>Seller</td>
                            <td>Pengu</td>
                          </tr>
                          <tr>
                            <td>Size</td>
                            <td>XL</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
          </div>
        </div>
      </div>
    </div>
    <!-- product-single-section  end-->

    <!-- start of pengu-product-section -->
    <section class="pengu-product-section section-padding">
      <?php if (count($relatedProducts)) { ?>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6 col-12">
              <div class="wpo-section-title">
                <h2>Related products</h2>
                <p>Here is our new arrival products that you may like.</p>
              </div>
            </div>
          </div>
          <div class="product-wrap">
            <div class="row">
              <?php foreach ($relatedProducts as $rel_product) { ?>
                <?= renderProduct($rel_product, $user); ?>
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
                      <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-original-title="Add To Cart" aria-label="Add To Cart"><i class="fi flaticon-shopping-cart"></i></a>
                    </li>
                    <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                      <button data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-original-title="Quick View" aria-label="Quick View"><i class="fi ti-eye"></i></button>
                    </li>
                    <li>
                      <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-original-title="Compare" aria-label="Compare"><i class="fa fa-compress" aria-hidden="true"></i></a>
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
                    <a class="icon-active" href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-original-title="Add To Wishlist">
                      <i class="fa fa-heart" aria-hidden="true"></i>
                    </a>
                  </div>
                  <ul class="cart-wrap">
                    <li>
                      <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-original-title="Add To Cart" aria-label="Add To Cart"><i class="fi flaticon-shopping-cart"></i></a>
                    </li>
                    <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                      <button data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-original-title="Quick View" aria-label="Quick View"><i class="fi ti-eye"></i></button>
                    </li>
                    <li>
                      <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-original-title="Compare" aria-label="Compare"><i class="fa fa-compress" aria-hidden="true"></i></a>
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
                      <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-original-title="Add To Cart" aria-label="Add To Cart"><i class="fi flaticon-shopping-cart"></i></a>
                    </li>
                    <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                      <button data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-original-title="Quick View" aria-label="Quick View"><i class="fi ti-eye"></i></button>
                    </li>
                    <li>
                      <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-original-title="Compare" aria-label="Compare"><i class="fa fa-compress" aria-hidden="true"></i></a>
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
                      <a href="cart.html" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-original-title="Add To Cart" aria-label="Add To Cart"><i class="fi flaticon-shopping-cart"></i></a>
                    </li>
                    <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                      <button data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-original-title="Quick View" aria-label="Quick View"><i class="fi ti-eye"></i></button>
                    </li>
                    <li>
                      <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-original-title="Compare" aria-label="Compare"><i class="fa fa-compress" aria-hidden="true"></i></a>
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
      <?php } ?>
    </section>
    <!-- end of pengu-product-section -->


    <!-- start of wpo-site-footer-section -->
    <!-- start of wpo-site-footer-section -->
    <?php
    include('../include/footer.php');
    ?>
    <!-- end of wpo-site-footer-section -->

    <!-- popup-quickview  -->
    <div id="popup-quickview" class="modal fade" tabindex="-1">
      <div class="modal-dialog quickview-dialog">
        <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="ti-close"></i></button>
          <div class="modal-body d-flex">
            <div class="product-details">
              <div class="row align-items-center">
                <div class="col-lg-5">
                  <div class="product-single-img">
                    <div class="modal-product">
                      <div class="item">
                        <img src="https://wpocean.com/html/tf/pengu/assets/images/modal.jpg" alt="" />
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
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quis ultrices lectus lobortis, dolor et tempus porta, leo mi efficitur ante, in varius felis sem ut mauris. Proin volutpat lorem inorci sed vestibulum
                      tempus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam hendrerit.
                    </p>

                    <div>
                      <a href="#" class="theme-btn text-decoration-none">Add to cart</a>
                    </div>
                    <!-- <div class="pro-single-btn">
                        <div class="quantity cart-plus-minus">
                          <input type="text" value="1" />
                          <div class="dec qtybutton">-</div>
                          <div class="inc qtybutton"></div>
                        </div>
                        <a href="#" class="theme-btn">Add to cart</a>
                      </div> -->
                    <!-- <div class="social-share">
                        <span>Share with : </span>
                        <ul class="socialLinks">
                          <li>
                            <a href="#"><i class="fa fa-facebook"></i></a>
                          </li>
                          <li>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                          </li>
                          <li>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                          </li>
                          <li>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                          </li>
                          <li>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                          </li>
                        </ul>
                      </div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- popup-quickview -->
    </div>
  </div>
  <!-- end of page-wrapper -->

  <?php
  include('../include/scripts.php');
  ?>

  <script>
    document.getElementById('add-to-cart--btn').addEventListener('click', () => {
      // addToCart(1, 8, )
      const el = document.getElementById('add-to-cart--amount');
      let amount = parseInt(el.value);
      addToCart(
        <?= htmlspecialchars($product['id']) ?>,
        <?= htmlspecialchars($user['id']) ?>,
        amount
      );
    });
  </script>
</body>

</html>