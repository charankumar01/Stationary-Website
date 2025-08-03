<?php
  include_once '../include/user.php';
  include_once '../include/helper.php';

  $items_per_page = 10; // How many products per page

  // Get current page number from the URL, default to 1 if not present
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $search = isset($_GET['search']) ? $_GET['search'] : ''; // Search parameter
  $min_price = !empty($_GET['min_price']) ? (float)$_GET['min_price'] : 0; // Min price filter
  $max_price = !empty($_GET['max_price']) ? (float)$_GET['max_price'] : PHP_INT_MAX; // Max price filter
  $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : ''; // Sort parameter
  $category_filter = isset($_GET['category']) ? $_GET['category'] : ''; // Category filter

  // Base query for products
  $query = "SELECT p.id, p.name, p.description, p.image, p.sku, 
                  p.regular_price, p.discounted_price, p.created_at, p.updated_at,
                  -- pd.stock,
                  AVG(pr.rating) AS avg_rating
            FROM products p
            LEFT JOIN product_reviews pr ON p.id = pr.prod_id
            WHERE 1=1
            ";

  // Initialize an array for bound parameters
  $bind_params = [];
  $bind_types = '';

  // If category filter is applied
  if (!empty($category_filter)) {
      $query .= " AND p.cat_id = ?";
      $bind_params[] = $category_filter;  // Add category filter parameter
      $bind_types .= 'i';  // Integer type for category filter
  }

  // Apply Search filter
  if (!empty($search)) {
      $query .= " AND p.name LIKE ?";
      $bind_params[] = '%' . $search . '%'; // Add search filter with wildcards
      $bind_types .= 's';  // String type for search
  }

  // Apply Price filter
  $query .= " AND (p.discounted_price BETWEEN ? AND ?)";
  $bind_params[] = $min_price;  // Add min price filter
  $bind_params[] = $max_price;  // Add max price filter
  $bind_types .= 'dd';  // Double type for price filter

  // Group by product ID to calculate the average rating
  $query .= " GROUP BY p.id";

  // Sorting logic based on the 'sort_by' parameter
  if ($sort_by == 'price_asc') {
      $query .= " ORDER BY discounted_price ASC";
  } elseif ($sort_by == 'price_desc') {
      $query .= " ORDER BY discounted_price DESC";
  } elseif ($sort_by == 'rating_asc') {
      $query .= " ORDER BY avg_rating ASC";
  } elseif ($sort_by == 'rating_desc') {
      $query .= " ORDER BY avg_rating DESC";
  } else {
    // Default sorting by product name
    $query .= " ORDER BY p.created_at ASC";
  }

  // Pagination logic
  $offset = ($current_page - 1) * $items_per_page;
  $query .= " LIMIT ?, ?";

  // Add pagination parameters
  $bind_params[] = $offset;
  $bind_params[] = $items_per_page;
  $bind_types .= 'ii';  // Integer type for offset and limit

  // Prepare and execute the query
  $stmt = mysqli_prepare($conn, $query);

  // Bind parameters
  mysqli_stmt_bind_param($stmt, $bind_types, ...$bind_params);

  // Execute the query
  mysqli_stmt_execute($stmt);

  // Get the result
  $result = mysqli_stmt_get_result($stmt);

  // Fetch results
  $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

  // Optionally, check the results (e.g., var_dump or echo the results for debugging)
  // var_dump($products);

  // Get total product count to calculate total pages
  $count_query = "SELECT COUNT(*) AS total_products
                  FROM products p
                  LEFT JOIN product_details pd ON p.id = pd.prod_id
                  -- WHERE pd.stock >= 1
                  ";

  // Bind parameters for count query
  $count_params = [];
  $count_types = '';

  // If category filter is applied, add it to the count query
  if (!empty($category_filter)) {
      $count_query .= " AND p.cat_id = ?";
      $count_params[] = $category_filter;
      $count_types .= 'i';  // Integer type for category filter
  }

  // Apply Search filter to count query
  if (!empty($search)) {
      $count_query .= " AND p.name LIKE ?";
      $count_params[] = '%' . $search . '%';  // Add search filter with wildcards
      $count_types .= 's';  // String type for search
  }

  $count_stmt = mysqli_prepare($conn, $count_query);

  // Bind parameters
  if (!empty($count_params)) {
      mysqli_stmt_bind_param($count_stmt, $count_types, ...$count_params);
  }

  // Execute the count query
  mysqli_stmt_execute($count_stmt);

  // Get the result
  $count_result = mysqli_stmt_get_result($count_stmt);
  $total_products = mysqli_fetch_assoc($count_result)['total_products'];

  // Calculate total pages
  $total_pages = ceil($total_products / $items_per_page);

  // Optionally, display total pages
  // echo "Total Pages: " . $total_pages;

  // Fetch categories for the filter
  $category_query = "SELECT * FROM categories";
  $category_result = mysqli_query($conn, $category_query);

  $categories = [];
  while ($category_row = mysqli_fetch_assoc($category_result)) {
      $categories[] = $category_row;
  }

  // var_dump($categories);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Shop - Draftsy</title>
    <?php
      include('../include/styles.php');
    ?>
    <style>
      .search--btn {
        background: #ffc4c4; height: 40px; width: 100%;margin-top: 10px;text-align: center;
        transition: 0.5s ease;
      }
      .search--btn:hover {
        background: #ff8e8e;
        color: white;
      }
      .search--btn:focus {
        box-shadow: none !important;
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
            <img src="https://wpocean.com/html/tf/pengu/assets/images/preloader.png" alt="" />
          </div>
        </div>
      </div>
      <!-- end preloader -->

      <!-- Start header -->
      <?php
        include('../include/header.php');
      ?>

      <br />
      <br />
      <br />
      <br />
      <!-- end of header -->

      <!-- start wpo-page-title -->
      <section class="wpo-page-title">
        <div class="container">
          <div class="row">
            <div class="col col-xs-12">
              <div class="wpo-breadcumb-wrap">
                <h2>Shop</h2>
                <ol class="wpo-breadcumb-wrap">
                  <li><a href="/user/pages/index.php">Home</a></li>
                  <li>Shop</li>
                </ol>
              </div>
            </div>
          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
      </section>
      <!-- end page-title -->

      <br />
      <br />
      <br />
      <br />

      <!-- shop-section  start-->

      <div class="shop-section">
        <div class="container">
          <div class="row">
            <div class="col-lg-4">
              <form method="GET">
              <div class="shop-filter-wrap">
                <div class="filter-item">
                  <div class="shop-filter-item">
                    <h2>Search</h2>
                    <div class="shop-filter-search">
                      <div>
                        <input type="text" class="form-control" name="search" placeholder="Enter Search" value="<?= $search ?>">
                      </div>
                    </div>
                    <div class="d-flex gap-1">
                      <button role="button" class="btn search--btn" style="background: #80808040; width: 40%; color: black !important;" type="button" onclick="window.location.href='/user/pages/shop.php'">Clear</button>
                      <button type="submit" role="button" class="btn search--btn"><i class="ti-search"></i> Search</button>
                    </div>
                  </div>
                </div>
                <div class="filter-item">
                  <div class="shop-filter-item">
                    <h2>Categories</h2>
                    <ul>
                      <li>
                        <label class="topcoat-radio-button__label">
                          All Categories
                          <input type="radio" name="category" value="" <?= empty($category_filter) ? 'checked' : '' ?> />
                          <span class="topcoat-radio-button"></span>
                        </label>
                      </li>
                      <?php foreach ($categories as $category): ?>
                        <li>
                          <label class="topcoat-radio-button__label">
                            <?= $category['name'] ?>
                            <input type="radio" name="category" value="<?= $category['id'] ?>" <?= $category['id'] == ((int) $category_filter ?? -1) ? 'checked' : '' ?> />
                            <span class="topcoat-radio-button"></span>
                          </label>
                        </li>
                      <?php endforeach ?>
                      
                      <!-- <li>
                        <label class="topcoat-radio-button__label">
                          Women
                          <input type="radio" name="topcoat3" />
                          <span class="topcoat-radio-button"></span>
                        </label>
                      </li>
                      <li>
                        <label class="topcoat-radio-button__label">
                          Kids
                          <input type="radio" name="topcoat3" />
                          <span class="topcoat-radio-button"></span>
                        </label>
                      </li>
                      <li>
                        <label class="topcoat-radio-button__label">
                          Sales
                          <input type="radio" name="topcoat3" />
                          <span class="topcoat-radio-button"></span>
                        </label>
                      </li> -->
                    </ul>
                  </div>
                </div>
                <div class="filter-item">
                  <div class="shop-filter-item">
                    <h2>Price</h2>
                    <ul>
                      <!-- <li>
                        <label class="topcoat-radio-button__label">
                          All prices
                          <input type="radio" name="topcoat" />
                          <span class="topcoat-radio-button"></span>
                        </label>
                      </li> -->
                      <li>
                        <div class="d-flex gap-3 shop-filter-search">
                          <input type="text" class="form-control" name="min_price" placeholder="Min Price" value="<?= isset($_GET['min_price']) ? $_GET['min_price'] : '' ?>">
                          <input type="text" class="form-control" name="max_price" placeholder="Max Price" value="<?= isset($_GET['max_price']) ? $_GET['max_price'] : '' ?>">
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="filter-item">
                  <div class="shop-filter-item">
                    <h2>Sort By</h2>
                    <ul>
                      <li>
                        <label class="topcoat-radio-button__label">
                          Default
                          <input type="radio" name="sort_by" value="" <?= empty($sort_by) ? 'checked' : '' ?> />
                          <span class="topcoat-radio-button"></span>
                        </label>
                      </li>
                      <li>
                        <label class="topcoat-radio-button__label">
                          Popular
                          <input type="radio" name="sort_by" value="rating_desc" <?= $sort_by == 'rating_desc' ? 'checked' : '' ?> />
                          <span class="topcoat-radio-button"></span>
                        </label>
                      </li>
                      <li>
                        <label class="topcoat-radio-button__label">
                          Price - Low to High
                          <input type="radio" name="sort_by" value="price_asc" <?= $sort_by == 'price_asc' ? 'checked' : '' ?> />
                          <span class="topcoat-radio-button"></span>
                        </label>
                      </li>
                      <li>
                        <label class="topcoat-radio-button__label">
                          Price - High to Low
                          <input type="radio" name="sort_by" value="price_desc" <?= $sort_by == 'price_desc' ? 'checked' : '' ?> />
                          <span class="topcoat-radio-button"></span>
                        </label>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="filter-item">
                  <button type="submit" role="button" class="btn search--btn"><i class="ti-search"></i> Search</button>
                </div>
                <!-- <div class="filter-item">
                  <div class="shop-filter-item color">
                    <h2>Color</h2>
                    <div class="color-name">
                      <ul>
                        <li class="color1">
                          <input id="cl1" type="radio" name="col" value="30" />
                          <label for="cl1"></label>
                        </li>
                        <li class="color2">
                          <input id="cl2" type="radio" name="col" value="30" />
                          <label for="cl2"></label>
                        </li>
                        <li class="color3">
                          <input id="cl3" type="radio" name="col" value="30" />
                          <label for="cl3"></label>
                        </li>
                        <li class="color4">
                          <input id="cl4" type="radio" name="col" value="30" />
                          <label for="cl4"></label>
                        </li>
                        <li class="color5">
                          <input id="cl5" type="radio" name="col" value="30" />
                          <label for="cl5"></label>
                        </li>
                        <li class="color6">
                          <input id="cl6" type="radio" name="col" value="30" />
                          <label for="cl6"></label>
                        </li>
                        <li class="color7">
                          <input id="cl7" type="radio" name="col" value="30" />
                          <label for="cl7"></label>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div> -->
              </div>
              </form>
            </div>
            <div class="col-lg-8">
              <div class="shop-section-top-inner">
                <div class="shoping-list">
                  <!-- <ul class="nav nav-mb-3 main-tab" id="tab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active nav-link-active" id="grid-tab" data-bs-toggle="pill" data-bs-target="#grid" type="button" role="tab" aria-controls="grid" aria-selected="true"><i class="fa fa-th"></i></button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link nav-link-active" id="list-tab" data-bs-toggle="pill" data-bs-target="#list" type="button" role="tab" aria-controls="list" aria-selected="false"><i class="fa fa-list"></i></button>
                    </li>
                  </ul> -->
                </div>
                <div class="shoping-product">
                  <span>Showing <?= ($items_per_page > $total_products) ? $total_products : $items_per_page ?> Of <?= $total_products ?> Products</span>
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
                    <?php foreach ($products as $product): ?>
                      <?= renderProduct($product, $user); ?>
                    <?php endforeach ?>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
          <div class="row">
            <!-- Pagination -->
            <ul class="pagination justify-content-center" style="
              --bs-pagination-bg: #ffffff73;
              --bs-pagination-color: var(--primary-color);
              --bs-pagination-border-color: #0000000f;
              --bs-pagination-hover-color: #4ea756;
              --bs-pagination-focus-color: black;
              --bs-pagination-focus-box-shadow: 0 0 0 0.25rem #4f6f5238;
              --bs-pagination-focus-bg: white;
            ">
            <?php
            // Previous page link
            if ($current_page > 1) {
              echo "<li class='page-item'>
                <a class='page-link' href='?page=" . ($current_page - 1) . "&search=" . $search . "&min_price=" . $min_price . "&max_price=" . $max_price . "&sort=" . $sort_by . "' aria-label='Previous'>
                  <span aria-hidden='true'>«</span>
                </a>
              </li>";
            }

            // Loop through the pages and create the page numbers
            for ($i = 1; $i <= $total_pages; $i++) {
              $active_class = ($i == $current_page) ? 'active' : ''; // Add the 'active' class to the current page
              echo "<li class='page-item $active_class'>
                <a class='page-link' href='?page=$i&search=$search&min_price=$min_price&max_price=$max_price&sort=$sort_by'>$i</a>
              </li>";
            }

            // Next page link
            if ($current_page < $total_pages) {
              echo "<li class='page-item'>
                <a class='page-link' href='?page=" . ($current_page + 1) . "&search=" . $search . "&min_price=" . $min_price . "&max_price=" . $max_price . "&sort=" . $sort_by . "' aria-label='Next'>
                  <span aria-hidden='true'>»</span>
                </a>
              </li>";
            }
            ?>
          </ul>
        </div>
        </div>
      </div>
      <!-- shop-area-end -->

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
  </body>
</html>
