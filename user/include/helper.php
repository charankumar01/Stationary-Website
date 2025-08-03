<?php

include_once '../config.php';
 
function renderProduct($product, $user, $cls=null) {
    if ($cls === null) {
        $cls = 'col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12';
    }
    ?>
    <div class="<?= $cls ?>">
        <div class="product-single-item">
            <div class="image">
                <img src="<?= USER_IMAGES_PATH . '/' . $product['image'] ?? '' ?>" alt="<?= htmlspecialchars($product['name']) ?>"  onerror="this.src = '/user/assets/no-img.jpg';" style="height: 345px; object-fit: contain;"/>
                <ul class="cart-wrap">
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-html="true" 
                           title="Add To Cart" style="cursor: pointer; display: flex; justify-content: center; align-items: center;" 
                           onclick="addToCart(<?= htmlspecialchars($product['id']) . ',' . htmlspecialchars($user['id']) ?>)">
                            <i class="fi flaticon-shopping-cart"></i>
                        </a>
                    </li>
                    <li data-bs-toggle="modal">
                        <button data-bs-toggle="tooltip" data-bs-html="true" 
                                title="Quick View" type="button" 
                                onclick="productQuickView(<?= htmlspecialchars($product['id']) ?>)">
                            <i class="fi ti-eye"></i>
                        </button>
                    </li>
                </ul>
                <div class="shop-btn">
                    <a class="product-btn text-decoration-none" 
                       href="/user/pages/product.php?product_id=<?= htmlspecialchars($product['id']) ?>">
                       Shop Now
                    </a>
                </div>
            </div>
            <div class="text">
                <h2>
                    <a href="/user/pages/product.php?product_id=<?= htmlspecialchars($product['id']) ?>">
                        <?= htmlspecialchars($product['name']) ?>
                    </a>
                </h2>
                <div class="price">
                    <del class="old-price">$<?= htmlspecialchars($product['regular_price']) ?></del>
                    <span class="present-price">$<?= htmlspecialchars($product['discounted_price']) ?></span>
                </div>
            </div>
        </div>
    </div>
    <?php
}
