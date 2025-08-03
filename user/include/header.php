<?php
include_once 'user.php';
?>

<!-- Start header -->
<header id="header" class="wpo-header-style-5">
    <!-- end topbar -->
    <div class="wpo-site-header">
        <nav class="navigation navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-3 d-lg-none dl-block">
                        <div class="mobail-menu">
                            <button type="button" class="navbar-toggler open-btn">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar first-angle"></span>
                                <span class="icon-bar middle-angle"></span>
                                <span class="icon-bar last-angle"></span>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-6">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="/user/pages/index.php">
                                <img src="<?= USER_IMAGES_PATH . '/' . $SETTINGS['main_logo'] ?>" alt="logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-1 col-1">
                        <div id="navbar" class="collapse navbar-collapse navigation-holder">
                            <button class="menu-close"><i class="ti-close"></i></button>
                            <ul class="nav navbar-nav mb-2 mb-lg-0">
                                <li class="menu-item-has-children">
                                    <a class="active" href="/user/pages/index.php">Home</a>
                                </li>
                                <!-- <li class="menu-item-has-children">
                                            <a class="active" href="category.php">Categories</a>                                     
                                        </li> -->

                                <li><a href="shop.php">Shop</a></li>
                                <li class="menu-item-has-children d-none">
                                    <a href="#">Pages</a>
                                    <ul class="sub-menu">
                                        <li><a href="/user/pages/about.php">About</a></li>
                                        <li><a href="/user/pages/cart.php">Cart</a></li>
                                        <!-- <li><a href="wishlist.html">Wishlist</a></li> -->
                                        <li><a href="/user/pages/checkout.php">Checkout</a></li>
                                        <li><a href="/user/pages/product.php">Product</a></li>
                                        <!-- <li><a href="product-single.html">Product Single</a></li> -->
                                        <li><a href="/user/pages/order.php">Order</a></li>
                                        <!-- <li><a href="login.html">Login</a></li> -->
                                        <!-- <li><a href="404.html">404 Error</a></li> -->
                                    </ul>
                                </li>
                                <!-- <li class="menu-item-has-children">
                                            <a href="#">Blog</a>
                                            <ul class="sub-menu">
                                                <li><a href="blog.html">Blog right sidebar</a></li>
                                                <li><a href="blog-left-sidebar.html">Blog left sidebar</a></li>
                                                <li><a href="blog-fullwidth.html">Blog fullwidth</a></li>
                                                <li class="menu-item-has-children">
                                                    <a href="#">Blog details</a>
                                                    <ul class="sub-menu">
                                                        <li><a href="blog-single.html">Blog details right sidebar</a>
                                                        </li>
                                                        <li><a href="blog-single-left-sidebar.html">Blog details left
                                                                sidebar</a></li>
                                                        <li><a href="blog-single-fullwidth.html">Blog details
                                                                fullwidth</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li> -->
                                <li><a href="/user/pages/about.php">About</a></li>
                                <li><a href="/user/pages/contact.php">Contact Us</a></li>
                            </ul>

                        </div><!-- end of nav-collapse -->
                    </div>
                    <div class="col-lg-2 col-md-2 col-2">
                        <div class="header-right">
                            <div class="mini-cart">
                                <button class="cart-toggle-btn" type="button" onclick="window.location.href='/user/pages/cart.php'"> <i class="fi flaticon-shopping-cart"></i></button>
                                <!-- <div class="mini-cart-content">
                                            <button class="mini-cart-close"><i class="ti-close"></i></button>
                                            <div class="mini-cart-items">
                                                <div class="mini-cart-item clearfix">
                                                    <div class="mini-cart-item-image">
                                                        <a href="shop.html"><img
                                                                src="assets/images/shop/mini-cart/img-1.jpg" alt></a>
                                                    </div>
                                                    <div class="mini-cart-item-des">
                                                        <a href="shop.html">White Wedding Shoe</a>
                                                        <span class="mini-cart-item-price">$100.15 x 1</span>
                                                        <span class="mini-cart-item-quantity"><a href="#"><i
                                                                    class="ti-close"></i></a></span>
                                                    </div>
                                                </div>
                                                <div class="mini-cart-item clearfix">
                                                    <div class="mini-cart-item-image">
                                                        <a href="shop.html"><img
                                                                src="assets/images/shop/mini-cart/img-2.jpg" alt></a>
                                                    </div>
                                                    <div class="mini-cart-item-des">
                                                        <a href="shop.html">Long Sleeve Tops</a>
                                                        <span class="mini-cart-item-price">$230.25 x 2</span>
                                                        <span class="mini-cart-item-quantity"><a href="#"><i
                                                                    class="ti-close"></i></a></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mini-cart-action clearfix">
                                                <span class="mini-checkout-price">Subtotal: <span>$330.35</span></span>
                                                <div class="mini-btn">
                                                    <a href="checkout.html" class="view-cart-btn s1">Checkout</a>
                                                    <a href="cart.html" class="view-cart-btn">View Cart</a>
                                                </div>
                                            </div>
                                        </div> -->
                            </div>
                            <div class="header-search-form-wrapper">
                                <div class="cart-search-contact">
                                    <!-- <button class="search-toggle-btn"><i class="fi flaticon-loupe"></i></button> -->
                                    <div class="header-search-form">
                                        <form>
                                            <div>
                                                <input type="text" class="form-control"
                                                    placeholder="Search here...">
                                                <button type="submit"><i class="fi flaticon-loupe"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="header-login">
                                <a class="login-btn" href="<?= !$user_logged_in ? '/user/pages/login.php' : '/user/pages/order.php' ?> ">
                                    <?php if ($user_logged_in) { ?>
                                        <i class="fas fa-user" style=" width: 17px; text-align: center; font-size: 1.3rem; color: #8fa9ff;"></i>
                                    <?php } else { ?>
                                        <i class="fi flaticon-user"></i>
                                    <?php } ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end of container -->
        </nav>
    </div>
</header>
<!-- end of header -->