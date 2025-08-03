<?php
include('../../includes/header.php');

// Fetch categories for the dropdown
$query = "SELECT * FROM categories";
$categories = mysqli_query($conn, $query);

// Fetch product info along with its details (availability and stock)
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT products.*, product_details.availability, product_details.stock 
              FROM products 
              LEFT JOIN product_details ON products.id = product_details.prod_id 
              WHERE products.id = " . $id;
    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}

if (isset($_POST['submit'])) {
    $id              = $_POST['id'];
    $name            = $_POST['name'];
    $description     = $_POST['description'];
    $sku             = $_POST['sku'];
    $regularPrice    = $_POST['regular_price'];
    $discountedPrice = $_POST['discounted_price'];
    $categoryid      = $_POST['category_id'];
    $availability    = $_POST['availability'];
    $stock           = $_POST['stock'];

    // Check if a new image is uploaded
    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
        $filename  = $_FILES['image']['name'];
        $temp_name = $_FILES['image']['tmp_name'];
        move_uploaded_file($temp_name, '../../assets/images/' . $filename);
        $image = $filename;

        $query = "UPDATE `products` SET 
                    `name` = '$name',
                    `description` = '$description',
                    `image` = '$image',
                    `sku` = '$sku',
                    `regular_price` = '$regularPrice',
                    `discounted_price` = '$discountedPrice',
                    `cat_id` = '$categoryid'
                  WHERE id = " . $id;
    } else {
        // No new image uploaded, so update the rest of the fields only
        $query = "UPDATE `products` SET 
                    `name` = '$name',
                    `description` = '$description',
                    `sku` = '$sku',
                    `regular_price` = '$regularPrice',
                    `discounted_price` = '$discountedPrice',
                    `cat_id` = '$categoryid'
                  WHERE id = " . $id;
    }
    $result = mysqli_query($conn, $query);

    // Update product_details table with availability and stock
    $query_details = "UPDATE `product_details` SET 
                        `availability` = '$availability',
                        `stock` = '$stock'
                      WHERE prod_id = " . $id;
    $result_details = mysqli_query($conn, $query_details);

    if ($result && $result_details) {
        echo "<script>window.location.href='index.php'</script>";
    } else {
        echo "Something went wrong!";
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
          <h5 class="card-title mb-0">Edit Product</h5>
        </div>
        <div class="card-body">
          <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="row gy-3">
              <!-- Category -->
              <div class="col-12">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control" required>
                  <?php
                  if ($categories->num_rows > 0) {
                      while ($cate = $categories->fetch_assoc()) {
                          ?>
                          <option value="<?php echo $cate['id']; ?>" <?php if ($cate['id'] == $row['cat_id']) { echo "selected"; } ?>>
                              <?php echo $cate['name']; ?>
                          </option>
                          <?php
                      }
                  }
                  ?>
                </select>
              </div>
              <!-- Name -->
              <div class="col-12">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Product Name" value="<?php echo $row['name']; ?>" required>
              </div>
              <!-- Image -->
              <div class="col-12">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control" placeholder="Image">
                <?php if (!empty($row['image'])) { ?>
                  <small>Current image: <?php echo $row['image']; ?></small>
                  <img style="width: 200px; height: auto; object-fit: cover;" src="<?= ADMIN_ASSET_URL . 'images/' . $row['image'] ?>">
                <?php } ?>
              </div>
              <!-- Description -->
              <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" placeholder="Description" required><?php echo $row['description']; ?></textarea>
              </div>
              <!-- SKU -->
              <div class="col-12">
                <label class="form-label">Sku</label>
                <input type="text" name="sku" class="form-control" placeholder="Sku" value="<?php echo $row['sku']; ?>" required>
              </div>
              <!-- Regular Price -->
              <div class="col-12">
                <label class="form-label">Regular Price</label>
                <input type="number" name="regular_price" class="form-control" placeholder="Regular Price" value="<?php echo $row['regular_price']; ?>" required>
              </div>
              <!-- Discounted Price -->
              <div class="col-12">
                <label class="form-label">Discounted Price</label>
                <input type="number" name="discounted_price" class="form-control" placeholder="Discounted Price" value="<?php echo $row['discounted_price']; ?>" required>
              </div>
              <!-- Availability -->
              <div class="col-12">
                <label class="form-label">Availability</label>
                <div class="form-check">
                  <input type="radio" name="availability" value="1" class="form-check-input" id="availabilityYes" <?php if ($row['availability'] == 1) { echo "checked"; } ?> required>
                  <label class="form-check-label" for="availabilityYes">Yes</label>
                </div>
                <div class="form-check">
                  <input type="radio" name="availability" value="0" class="form-check-input" id="availabilityNo" <?php if ($row['availability'] == 0) { echo "checked"; } ?> required>
                  <label class="form-check-label" for="availabilityNo">No</label>
                </div>
              </div>
              <!-- Stock -->
              <div class="col-12">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" placeholder="Stock" value="<?php echo $row['stock']; ?>" required>
              </div>
              <!-- Submit -->
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
