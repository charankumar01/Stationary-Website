<?php
include('../../includes/header.php');

$query = "SELECT * from products";

$products = mysqli_query($conn,$query);

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = 'Select * from product_images where id ='.$id;
    $result = mysqli_query($conn,$query);
    if($result->num_rows >0){
      $row = $result->fetch_assoc();
    }
   
}

if(isset($_POST['submit']))
{
  
  if(isset($_FILES['image']))
  {

      $filename = $_FILES['image']['name'];
      $temp_name = $_FILES['image']['tmp_name'];
      move_uploaded_file($temp_name,'../../assets/images/'.$filename);
      $image = $filename;

      $id = $_POST['id'];
      $productid = $_POST['prod_id'];


      $query = "UPDATE `product_images` SET `prod_id`='$productid',`images`='$image' WHERE id=".$id;
      var_dump($query);
      $result = mysqli_query($conn,$query);

      if($result)
      {
        echo "<script>window.location.href='index.php'</script>";
      }
      else{
        echo "Something went wrong!";
      }
  }
  else
  {
      $id = $_POST['id'];
      $productid = $_POST['prod_id'];
      

      $query = "UPDATE `product_images` SET `prod_id`='$productid',`images`='$image' WHERE id=".$id;
      var_dump($query);
      $result = mysqli_query($conn,$query);

      if($result)
      {
        echo "<script>window.location.href='index.php'</script>";
      }
      else{
        echo "Something went wrong!";
      }
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
        <div class="row gy-3">
          <form action="" method="post" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?php echo $row['id']?>">
          <div class="col-12">
            <label class="form-label">Category</label>
            <select name="prod_id" class="form-control">
              <?php
              if($products->num_rows > 0)
              {
                while($pro = $products->fetch_assoc())
                {
              ?>
                  <option value="<?php echo $pro['id']?>" <?php if($pro['id'] == $row['prod_id']) {?> selected<?php }?>><?php echo $pro['name']?></option>
                  <?php
                }
              }
                  ?>

            </select>
          </div>
          <div class="col-12">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control" placeholder="Image">
          </div>
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
