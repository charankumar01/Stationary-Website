<?php
include('../../includes/header.php');

$query = "SELECT * FROM categories";
$categoriesResult = mysqli_query($conn, $query);

if(isset($_POST['submit'])) {
  $name           = $_POST['name'];
  $description    = $_POST['description'];
  $sku            = $_POST['sku'];
  $regularPrice   = $_POST['regular_price'];
  $discountedPrice= $_POST['discounted_price'];
  $categoryid     = $_POST['category_id'];
  $availability   = $_POST['availability'];  // New field
  $stock          = $_POST['stock'];         // New field
  $image          = '';

  if(isset($_FILES['image']) && $_FILES['image']['name'] != '') {
      $filename  = $_FILES['image']['name'];
      $temp_name = $_FILES['image']['tmp_name'];
      move_uploaded_file($temp_name, '../../assets/images/'.$filename);
      $image = $filename;
  }

  // Insert into products table
  $query = "INSERT INTO `products` 
            (`name`,`image`,`description`, `sku`, `regular_price`, `discounted_price`, `cat_id`) 
            VALUES ('$name','$image','$description','$sku','$regularPrice','$discountedPrice','$categoryid')";
  $productResult = mysqli_query($conn, $query);

  if($productResult) {
    // Get the last inserted product id
    $product_id = mysqli_insert_id($conn);

    // Insert availability and stock into product_details table
    $queryDetails = "INSERT INTO `product_details` (`prod_id`, `availability`, `stock`) 
                     VALUES ('$product_id','$availability','$stock')";
    $detailsResult = mysqli_query($conn, $queryDetails);

    if($detailsResult) {
      echo "<script>window.location.href='index.php'</script>";
    } else {
      echo "Something went wrong while inserting product details!";
    }
  } else {
    echo "Something went wrong while inserting the product!";
  }
}
?>

<div class="dashboard-main-body">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
      <h6 class="fw-semibold mb-0">Products</h6>
      <ul class="d-flex align-items-center gap-2">
          <li class="fw-medium">
              <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                  <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                  Dashboard
              </a>
          </li>
          <li>-</li>
          <li class="fw-medium">Products</li>
      </ul>
  </div>

  <div class="row gy-4">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Add New Product</h5>
        </div>
        <div class="card-body">
          <form action="" method="post" enctype="multipart/form-data">
            <div class="row gy-3">
              <div class="col-12">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control" required>
                  <?php
                  if($categoriesResult && $categoriesResult->num_rows > 0) {
                    while($row = $categoriesResult->fetch_assoc()) {
                      echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Product Name" required>
              </div>
              <div class="col-12">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control" placeholder="Image">
              </div>
              <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" placeholder="Description" required></textarea>
              </div>
              <div class="col-12">
                <label class="form-label">Sku</label>
                <input type="text" name="sku" class="form-control" placeholder="Sku" required>
              </div>
              <div class="col-12">
                <label class="form-label">Regular Price</label>
                <input type="number" name="regular_price" class="form-control" placeholder="Regular Price" required>
              </div>
              <div class="col-12">
                <label class="form-label">Discounted Price</label>
                <input type="number" name="discounted_price" class="form-control" placeholder="Discounted Price" required>
              </div>
              <!-- New Fields for Product Details -->
              <div class="col-12">
                <label class="form-label">Availability</label>
                <div class="form-check">
                  <input type="radio" name="availability" value="1" class="form-check-input" id="availabilityYes" required>
                  <label class="form-check-label" for="availabilityYes">Yes</label>
                </div>
                <div class="form-check">
                  <input type="radio" name="availability" value="0" class="form-check-input" id="availabilityNo" required>
                  <label class="form-check-label" for="availabilityNo">No</label>
                </div>
              </div>
              <div class="col-12">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" placeholder="Stock" required>
              </div>
              <div class="col-12">
                <button type="submit" name="submit" class="btn btn-primary-600">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include('../../includes/footer.php');
?>
