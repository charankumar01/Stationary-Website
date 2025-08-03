<?php
include('../../includes/header.php');

$query = "SELECT product_images.* , products.name as p_name from product_images join products on product_images.prod_id = products.id";

$result = mysqli_query($conn,$query);

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

<div class="card basic-data-table">
  <div class="card-header">
    <h5 class="card-title mb-0">All Products</h5>
  </div>
  <div class="card-body ">
   <div class="table-responsive">
   <table class="table bordered-table mb-0 " id="dataTable" data-page-length='10'>
      <thead>
        <tr>
          <th scope="col">Product</th>
          <th scope="col">Image</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
        <tbody>
        <?php
          if($result->num_rows > 0)
          {
            
            while($row = $result->fetch_assoc())
            {
          ?>
            <tr>
                <td><?php echo $row['p_name']?></td>
                <td><img src="../../assets/images/<?php echo $row['images']?>" alt="user 1" class="img-fluid rounded" style=""></td>
                <td>
                <a href="edit.php?id=<?php echo $row['id']?>" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                  <!-- <iconify-icon icon="lucide:edit"></iconify-icon> -->
                  <i class="ri-edit-box-line"></i>
                </a>
                <a href="delete.php?id=<?php echo $row['id']?>" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                <i class="ri-delete-bin-line"></i>
                </a>
              </td>
            </tr>
            <?php
            }
          }
        ?>
        </tbody>
    </table>
   </div>
</div>
        </div>
  
<?php
include('../../includes/footer.php');
?>

</body>
</html>