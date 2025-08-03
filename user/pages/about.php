
  
        
    
    
   
    

<head>
    <title>About Us - Draftsy</title>
<?php
    include('../include/styles.php');
    ?>
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
                            <h2>about us</h2>
                            <ol class="wpo-breadcumb-wrap">
                                <li><a href="/user/pages/index.php">Home</a></li>
                                <li>about</li>
                            </ol>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </section>
        <!-- end page-title -->

        <!-- start of pengu-about-section-->
        <section class="pengu-about-section pengu-about-section-s2 section-padding">
            <div class="about-top-title">
                <h1>Well-know Brands</h1>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="about-wrap">
                            <p>Draftsy</p>
                            <p>At Draftsy we aim to become Pakistan’s largest online store for boutique and designer stationery. Our plan is to revive online arts and crafts materials shopping to help creators of all ages express their imagination with skill and originality.</p>
                            <p>You can head to our exclusive TSC stationery category for a distinctive and playful range of journals, notebooks, diaries, pens, pencils, fine paper and greeting cards. Along with a broad assortment of products from our exclusive TSC Stationery, we also offer a fabulous array of art materials, office supplies, School Supplies, Craft Supplies and Toys and Games.  </p>
                            <p>Our office supplies will help you organize your workspace from all kinds of desk essentials to top quality staplers, calculators and organizers.</p>
                            <p>We have our school supplies all geared up to get you ready for school with a broad range of school bags, pencil cases, school bottles, lunch boxes and much more.</p>
                            <p>In our crafts section you will find all the latest accessories and tools to help you with your creations. If you need to cut it, stamp it, or embellish it, we’ve got just what you need for your DIY and crafting projects.</p>
                            <p>For some fun, head to our toys and games section for the best kind of entertainment your child can get at home from educational toys for added learning to board games, puzzles, Lego and all kinds outdoor games.</p>
                            <p>We provide a shopping experience that inspires our customers to pursue their creative goals.</p>
                            <p>Our mission is to bring convenience to our customers’ lives by bringing all their desired products just a click away.</p>
                            <p>We also offer an exquisite collection of home ware and accessories, all beautifully packaged with simplicity, quality and functionality running through their core.    </p>
                        
                            <!-- <a class="about-btn" href="about.html">
                                <div class="about-bg">
                                    <img src="assets/images/about-bg.png" alt="">
                                </div>
                                <span>Our <br> Story</span>
                            </a> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="about-bottom-title">
                <h1>Best Collection</h1>
            </div>
        </section>
        <!-- end of pengu-about-section-->
        <br><br>
        <?php
include('../include/footer.php');
    ?>
        <!-- end of wpo-site-footer-section -->

        <!-- popup-quickview  -->
        <!-- <div id="popup-quickview" class="modal fade" tabindex="-1">
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
                                                <img src="assets/images/modal.jpg" alt="">
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
            -->
        </div>

    </div> -->
    <!-- end of page-wrapper -->

    <?php
    include('../include/scripts.php');
    ?>


 
</body>

</html>

 


