<?php
include('../../includes/header.php');

if(isset($_POST['submit']))
{
  $name = $_POST['name'];
  $description = $_POST['description'];
  $image = '';
  if(isset($_FILES['image']))
  {
      $filename = $_FILES['image']['name'];
      $temp_name = $_FILES['image']['tmp_name'];
      move_uploaded_file($temp_name,'../../assets/images/'.$filename);
      $image = $filename;
  }

  $query = "INSERT INTO `categories` (`name`,`image`,`description`) VALUES ('$name','$image','$description')";

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
    <h6 class="fw-semibold mb-0">Categories</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
        <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
            Dashboard
        </a>
        </li>
        <li>-</li>
        <li class="fw-medium">Categories</li>
    </ul>
</div>

<div class="row gy-4">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Add New Category</h5>
      </div>
      <div class="card-body">
        <div class="row gy-3">
          <form action="" method="post" enctype="multipart/form-data">
          <div class="col-12">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter Your Name">
          </div>
          <div class="col-12">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control" placeholder="Image">
          </div>
          <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" id=""></textarea>
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
