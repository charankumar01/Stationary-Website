<?php
include('../../includes/header.php');

$query = "SELECT * from products";

$result = mysqli_query($conn,$query);

if(isset($_POST['submit']))
{
  $productid = $_POST['prod_id'];
  $availability = $_POST['availability'];
  $stock = $_POST['stock'];

  // var_dump($availability);

  $query = "INSERT INTO `product_details`( `prod_id`, `availability`, `stock`) VALUES ('$productid','$availability','$stock')";

  $result = mysqli_query($conn,$query);
  if($result)
  {
    echo "<script>window.location.href='index.php'</script>";
  }
  else{
    echo "Something went wrong!";
  }
}
?>
<div class="dashboard-main-body">

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Products Details</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
        <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
            Dashboard
        </a>
        </li>
        <li>-</li>
        <li class="fw-medium">Products Details </li>
    </ul>
</div>

<div class="row gy-4">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Add Product Details</h5>
      </div>
      <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
        <div class="row gy-3">
          <div class="col-12">
            <label class="form-label">Product</label>
            <select name="prod_id" class="form-control">
              <?php
              if($result->num_rows > 0)
              {
                while($row = $result->fetch_assoc())
                {
              ?>
                  <option value="<?php echo $row['id']?>"><?php echo $row['name']?></option>
                  <?php
                }
              }
                  ?>

            </select>
          </div>
          <!-- <div class="col-12">
            <label class="form-label">Product ID</label>
            <input type="number" name="prod_id" class="form-control" placeholder="Product ID">
          </div> -->
          <div class="col-12">
            <label class="form-label">Availability</label>
            <div class="form-check">
              <input value="Yes" class="form-check-input" type="radio" name="availability" id="flexRadioDefault1">
              <label class="form-check-label" for="flexRadioDefault1">
              Yes
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" value="No" type="radio" name="availability" id="flexRadioDefault2">
              <label class="form-check-label" for="flexRadioDefault2">
              No
              </label>
            </div>
          </div>
          <div class="col-12">
            <label class="form-label">Stock</label>
            <input type="text" name="stock" class="form-control" placeholder="Stock">
          </div>
          <div class="col-12">
            <button type="submit" name="submit" class="btn btn-primary-600">Submit</button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php
include('../../includes/footer.php');
?>
