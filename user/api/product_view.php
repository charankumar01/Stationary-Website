<?php

include_once '../include/user.php';

$product_id = $_POST['product_id'];

// Fetch product data from your database (Example)
$query = "SELECT * FROM products WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

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

if ($product): ?>
    <div class="product-details">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="product-single-img">
                    <div class="modal-product">
                        <div class="item">                               
                            <img src="<?= USER_IMAGES_PATH . '/' . $product['image'] ?? '' ?>" 
                                alt="<?= htmlspecialchars($product['name']) ?>" 
                                onerror="this.src = '/user/assets/no-img.jpg';" 
                                style="object-fit: contain;" />
                        </div>
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
                    
                    <div>
                        <a class="theme-btn cursor-pointer text-decoration-none"
                           onclick="addToCart(<?= $product['id'] ?>, <?= $user['id'] ?>)">
                           Add to cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <p>Product not found.</p>
<?php endif; ?>
