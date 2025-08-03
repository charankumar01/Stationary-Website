<?php
// Fetch categories for the filter
$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_query);

$categories = [];
while ($category_row = mysqli_fetch_assoc($category_result)) {
    $categories[] = $category_row;
}
?>

<footer class="wpo-site-footer">
    <div class="wpo-upper-footer">
        <div class="container">
            <div class="row">
                <div class="col col-lg-5 col-md-6 col-sm-12 col-12">
                    <div class="widget about-widget">
                        <div class="logo widget-title">
                            <img src="<?= USER_IMAGES_PATH . '/' . $SETTINGS['main_logo'] ?>" alt="blog">
                        </div>
                        <p>At Draftsy, we curate high-quality notebooks, pens, planners, and desk essentials designed to elevate your everyday writing experience. Our mission is to make organization and creativity effortless by providing stationery that is both practical and beautifully crafted.</p>
                        <div class="social-widget">
                            <ul>
                                <li><a href="<?= $SETTINGS['fb'] ?? '#' ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="<?= $SETTINGS['x'] ?? '#' ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="<?= $SETTINGS['linkedin'] ?? '#' ?>" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="widget link-widget">
                        <div class="widget-title">
                            <h3>Categories</h3>
                        </div>
                        <ul style="display: grid;
                                grid-template-columns: 1fr 1fr;
                                justify-content: center;
                                align-items: center;
                                row-gap: 7px;
                                padding-left: 0;">
                            <?php foreach ($categories as $category): ?>
                                <li><a href="/user/pages/shop.php?category=<?= $category['id'] ?>">
                                        <?= $category['name'] ?>
                                    </a></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
                <!-- <div class="col col-lg-4 col-md-6 col-sm-12 col-12">
                            <div class="widget blog-widget">
                                <div class="widget-title">
                                    <h3>Blog Post</h3>
                                </div>
                                <ul>
                                    <li>
                                        <div class="image">
                                            <img src="assets/images/news/img-01.jpg" alt="">
                                        </div>
                                        <div class="text">
                                            <p><a href="blog-single.html">It is a long established fact that a reader
                                                    will be distracted.</a></p>
                                            <span>12 December, 2023</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image">
                                            <img src="assets/images/news/img-02.jpg" alt="">
                                        </div>
                                        <div class="text">
                                            <p><a href="blog-single.html">It is a long established fact that a reader
                                                    will be distracted.</a></p>
                                            <span>12 December, 2023</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div> -->

                <div class="col col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="widget newsletter-widget">
                        <div class="widget-title">
                            <h3>Newsletter</h3>
                        </div>
                        <p>Subscribe to our newsletter and get 10% off your first purchase.</p>
                        <form onsubmit="event.preventDefault(); subscribeNewsletter();">
                            <div class="input-1">
                                <input type="email" id="newsletter-email" class="form-control" placeholder="Your Email Address.. " required>
                            </div>
                            <div class="submit clearfix">
                                <button type="submit">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- end container -->
    </div>
    <!-- <div class="wpo-lower-footer">
                <div class="container">
                    <div class="row">
                        <div class="col col-xs-12">
                            <p class="copyright"> Copyright &copy; 2023 Canun by <a href="index.html">wpOceans</a>. All
                                Rights Reserved.</p>
                        </div>
                    </div>
                </div>
            </div> -->
</footer>
<!-- end of wpo-site-footer-section -->