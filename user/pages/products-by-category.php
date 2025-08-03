
<?php
    include('../include/header.php');
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $query = "Select * from products where cat_id =".$id;
        $result = mysqli_query($conn,$query);
    }
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

        <!-- Start header -->

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
                            <h2>Shop</h2>
                            <ol class="wpo-breadcumb-wrap">
                                <li><a href="index.html">Home</a></li>
                                <li>Shop</li>
                            </ol>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </section>
        <!-- end page-title -->

        <br>
        <br>
        <br>
        <br>

        <!-- shop-section  start-->

        <div class="shop-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="shop-filter-wrap">
                            <div class="filter-item">
                                <div class="shop-filter-item">
                                    <h2>Search</h2>
                                    <div class="shop-filter-search">
                                        <form>
                                            <div>
                                                <input type="text" class="form-control" placeholder="Search">
                                                <button type="submit"><i class="ti-search"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-item">
                                <div class="shop-filter-item">
                                    <h2>Price</h2>
                                    <ul>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                All prices
                                                <input type="radio" name="topcoat">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                $50 – $100 (1)
                                                <input type="radio" name="topcoat">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                $100 – $200 (21)
                                                <input type="radio" name="topcoat">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                $200 – $300 (13)
                                                <input type="radio" name="topcoat">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                $300 – $400 (3)
                                                <input type="radio" name="topcoat">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                $400 and more (2)
                                                <input type="radio" name="topcoat">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="filter-item">
                                <div class="shop-filter-item">
                                    <h2>Size</h2>
                                    <ul>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                Small Size
                                                <input type="radio" name="topcoat2">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                Large Size
                                                <input type="radio" name="topcoat2">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                Medium Size
                                                <input type="radio" name="topcoat2">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                Extra large Size
                                                <input type="radio" name="topcoat2">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="filter-item">
                                <div class="shop-filter-item color">
                                    <h2> Color</h2>
                                    <div class="color-name">
                                        <ul>
                                            <li class="color1"><input id="cl1" type="radio" name="col" value="30">
                                                <label for="cl1"></label>
                                            </li>
                                            <li class="color2"><input id="cl2" type="radio" name="col" value="30">
                                                <label for="cl2"></label>
                                            </li>
                                            <li class="color3"><input id="cl3" type="radio" name="col" value="30">
                                                <label for="cl3"></label>
                                            </li>
                                            <li class="color4"><input id="cl4" type="radio" name="col" value="30">
                                                <label for="cl4"></label>
                                            </li>
                                            <li class="color5"><input id="cl5" type="radio" name="col" value="30">
                                                <label for="cl5"></label>
                                            </li>
                                            <li class="color6"><input id="cl6" type="radio" name="col" value="30">
                                                <label for="cl6"></label>
                                            </li>
                                            <li class="color7"><input id="cl7" type="radio" name="col" value="30">
                                                <label for="cl7"></label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-item">
                                <div class="shop-filter-item">
                                    <h2>Brand</h2>
                                    <ul>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                Men
                                                <input type="radio" name="topcoat3">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                Women
                                                <input type="radio" name="topcoat3">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                Kids
                                                <input type="radio" name="topcoat3">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                Sales
                                                <input type="radio" name="topcoat3">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="shop-section-top-inner">
                            <div class="shoping-list">
                                <ul class="nav nav-mb-3 main-tab" id="tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active nav-link-active" id="grid-tab" data-bs-toggle="pill"
                                            data-bs-target="#grid" type="button" role="tab" aria-controls="grid"
                                            aria-selected="true"><i class="fa fa-th "></i></button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link nav-link-active" id="list-tab" data-bs-toggle="pill"
                                            data-bs-target="#list" type="button" role="tab" aria-controls="list"
                                            aria-selected="false"><i class="fa fa-list "></i></button>
                                    </li>
                                </ul>
                            </div>
                            <div class="shoping-product">
                                <span>Showing Products 1 - 9 Of 13 Result</span>
                            </div>
                            <!-- <div class="short-by">
                                <ul>
                                    <li>Short By :</li>
                                    <li>
                                        <select name="show">
                                            <option value="">Show 9 Items</option>
                                            <option value="">Show 18 Items</option>
                                            <option value="">Show 27 Items</option>
                                        </select>
                                    </li>
                                </ul>
                            </div> -->
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="grid" role="tabpanel" aria-labelledby="grid-tab">
                                <div class="product-wrap">
                                    <div class="row align-items-center">
                                        <?php 
                                        if($result->num_rows > 0)
                                        {
                                        while($row = $result->fetch_assoc())
                                        {
                                        ?>
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                           <div class="product-single-item">
                                                <div class="image">
                                                    <img src="../../admin/assets/images/<?php echo $row['image']?>" alt="">
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
                                                    <h2><a href="product-single.html"><?php echo $row['name']?></a></h2>
                                                    <div class="price">
                                                        <del class="old-price">Rs.<?php echo $row['regular_price']?></del>
                                                        <span class="present-price">Rs.<?php echo $row['discounted_price']?></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <?php 
  }
}
?>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade product-list" id="list" role="tabpanel"
                                aria-labelledby="list-tab">
                                <div class="product-wrap">
                                    <div class="row align-items-center">
                                        <div class="col-xl-12 col-12">
                                            <div class="product-single-item product-single-item-s2">
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
                                                            <a href="cart.html" data-bs-toggle="tooltip"
                                                                data-bs-html="true" title="Add To Cart"><i
                                                                    class="fi flaticon-shopping-cart"></i></a>
                                                        </li>
                                                        <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                                                            <button data-bs-toggle="tooltip" data-bs-html="true"
                                                                title="Quick View"><i class="fi ti-eye"></i></button>
                                                        </li>
                                                        <li>
                                                            <a href="compare.html" data-bs-toggle="tooltip"
                                                                data-bs-html="true" title="Compare"><i
                                                                    class="fa fa-compress" aria-hidden="true"></i></a>
                                                        </li>
                                                    </ul>
                                                    <div class="shop-btn">
                                                        <a class="product-btn" href="shop.html">Shop Now</a>
                                                    </div>
                                                </div>
                                                <div class="text">
                                                    <h2><a href="product-single.html">Long Chain With Lockel</a></h2>
                                                    <div class="price">
                                                        <del class="old-price">$120.50</del>
                                                        <span class="present-price">$100.30</span>
                                                    </div>
                                                    <div class="product-ratting">
                                                        <ul>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><span><i class="fa fa-star"
                                                                        aria-hidden="true"></i></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aperiam
                                                        consequuntur laudantium quod ratione nulla modi? Repudiandae
                                                        quidem dicta quia eveniet dignissimos.</p>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-12">
                                            <div class="product-single-item product-single-item-s2">
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
                                                            <a href="cart.html" data-bs-toggle="tooltip"
                                                                data-bs-html="true" title="Add To Cart"><i
                                                                    class="fi flaticon-shopping-cart"></i></a>
                                                        </li>
                                                        <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                                                            <button data-bs-toggle="tooltip" data-bs-html="true"
                                                                title="Quick View"><i class="fi ti-eye"></i></button>
                                                        </li>
                                                        <li>
                                                            <a href="compare.html" data-bs-toggle="tooltip"
                                                                data-bs-html="true" title="Compare"><i
                                                                    class="fa fa-compress" aria-hidden="true"></i></a>
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
                                                    <div class="product-ratting">
                                                        <ul>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><span><i class="fa fa-star"
                                                                        aria-hidden="true"></i></span></li>
                                                            <li><span><i class="fa fa-star"
                                                                        aria-hidden="true"></i></span></li>
                                                            <li><span><i class="fa fa-star"
                                                                        aria-hidden="true"></i></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aperiam
                                                        consequuntur laudantium quod ratione nulla modi? Repudiandae
                                                        quidem dicta quia eveniet dignissimos.</p>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-12">
                                            <div class="product-single-item product-single-item-s2">
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
                                                            <a href="cart.html" data-bs-toggle="tooltip"
                                                                data-bs-html="true" title="Add To Cart"><i
                                                                    class="fi flaticon-shopping-cart"></i></a>
                                                        </li>
                                                        <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                                                            <button data-bs-toggle="tooltip" data-bs-html="true"
                                                                title="Quick View"><i class="fi ti-eye"></i></button>
                                                        </li>
                                                        <li>
                                                            <a href="compare.html" data-bs-toggle="tooltip"
                                                                data-bs-html="true" title="Compare"><i
                                                                    class="fa fa-compress" aria-hidden="true"></i></a>
                                                        </li>
                                                    </ul>
                                                    <div class="shop-btn">
                                                        <a class="product-btn" href="shop.html">Shop Now</a>
                                                    </div>
                                                </div>
                                                <div class="text">
                                                    <h2><a href="product-single.html">Winter Jacket</a></h2>
                                                    <div class="price">
                                                        <del class="old-price">$120.50</del>
                                                        <span class="present-price">$100.30</span>
                                                    </div>
                                                    <div class="product-ratting">
                                                        <ul>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><span><i class="fa fa-star"
                                                                        aria-hidden="true"></i></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aperiam
                                                        consequuntur laudantium quod ratione nulla modi? Repudiandae
                                                        quidem dicta quia eveniet dignissimos.</p>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-12">
                                            <div class="product-single-item product-single-item-s2">
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
                                                            <a href="cart.html" data-bs-toggle="tooltip"
                                                                data-bs-html="true" title="Add To Cart"><i
                                                                    class="fi flaticon-shopping-cart"></i></a>
                                                        </li>
                                                        <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                                                            <button data-bs-toggle="tooltip" data-bs-html="true"
                                                                title="Quick View"><i class="fi ti-eye"></i></button>
                                                        </li>
                                                        <li>
                                                            <a href="compare.html" data-bs-toggle="tooltip"
                                                                data-bs-html="true" title="Compare"><i
                                                                    class="fa fa-compress" aria-hidden="true"></i></a>
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
                                                    <div class="product-ratting">
                                                        <ul>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><span><i class="fa fa-star"
                                                                        aria-hidden="true"></i></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aperiam
                                                        consequuntur laudantium quod ratione nulla modi? Repudiandae
                                                        quidem dicta quia eveniet dignissimos.</p>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-12">
                                            <div class="product-single-item product-single-item-s2">
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
                                                            <a href="cart.html" data-bs-toggle="tooltip"
                                                                data-bs-html="true" title="Add To Cart"><i
                                                                    class="fi flaticon-shopping-cart"></i></a>
                                                        </li>
                                                        <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                                                            <button data-bs-toggle="tooltip" data-bs-html="true"
                                                                title="Quick View"><i class="fi ti-eye"></i></button>
                                                        </li>
                                                        <li>
                                                            <a href="compare.html" data-bs-toggle="tooltip"
                                                                data-bs-html="true" title="Compare"><i
                                                                    class="fa fa-compress" aria-hidden="true"></i></a>
                                                        </li>
                                                    </ul>
                                                    <div class="shop-btn">
                                                        <a class="product-btn" href="shop.html">Shop Now</a>
                                                    </div>
                                                </div>
                                                <div class="text">
                                                    <h2><a href="product-single.html">Long Chain With Lockel</a></h2>
                                                    <div class="price">
                                                        <del class="old-price">$120.50</del>
                                                        <span class="present-price">$100.30</span>
                                                    </div>
                                                    <div class="product-ratting">
                                                        <ul>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><span><i class="fa fa-star"
                                                                        aria-hidden="true"></i></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aperiam
                                                        consequuntur laudantium quod ratione nulla modi? Repudiandae
                                                        quidem dicta quia eveniet dignissimos.</p>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-12">
                                            <div class="product-single-item product-single-item-s2">
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
                                                            <a href="cart.html" data-bs-toggle="tooltip"
                                                                data-bs-html="true" title="Add To Cart"><i
                                                                    class="fi flaticon-shopping-cart"></i></a>
                                                        </li>
                                                        <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                                                            <button data-bs-toggle="tooltip" data-bs-html="true"
                                                                title="Quick View"><i class="fi ti-eye"></i></button>
                                                        </li>
                                                        <li>
                                                            <a href="compare.html" data-bs-toggle="tooltip"
                                                                data-bs-html="true" title="Compare"><i
                                                                    class="fa fa-compress" aria-hidden="true"></i></a>
                                                        </li>
                                                    </ul>
                                                    <div class="shop-btn">
                                                        <a class="product-btn" href="shop.html">Shop Now</a>
                                                    </div>
                                                </div>
                                                <div class="text">
                                                    <h2><a href="product-single.html">Long Sleeve Tops</a></h2>
                                                    <div class="price">
                                                        <del class="old-price">$120.50</del>
                                                        <span class="present-price">$100.30</span>
                                                    </div>
                                                    <div class="product-ratting">
                                                        <ul>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><span><i class="fa fa-star"
                                                                        aria-hidden="true"></i></span></li>
                                                            <li><span><i class="fa fa-star"
                                                                        aria-hidden="true"></i></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aperiam
                                                        consequuntur laudantium quod ratione nulla modi? Repudiandae
                                                        quidem dicta quia eveniet dignissimos.</p>

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
        <!-- shop-area-end -->

        <!-- start of wpo-site-footer-section -->
        <?php
    include('../include/footer.php');
    ?>
