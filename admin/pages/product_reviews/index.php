<?php
include('../../includes/header.php');

$query = "SELECT product_reviews.* , products.name as p_name from product_reviews join products on product_reviews.prod_id = products.id";

$result = mysqli_query($conn,$query);

?>
 
 
 <div class="dashboard-main-body">

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
<h6 class="fw-semibold mb-0">Product Reviews</h6>
<ul class="d-flex align-items-center gap-2">
<li class="fw-medium">
  <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
    Dashboard
  </a>
</li>
<li>-</li>
<li class="fw-medium">Product Reviews</li>
</ul>
</div>

<div class="card basic-data-table">
  <div class="card-header">
    <h5 class="card-title mb-0">All Products Reviews</h5>
  </div>
  <div class="card-body ">
   <div class="table-responsive">
   <table class="table bordered-table mb-0 " id="dataTable" data-page-length='10'>
      <thead>
        <tr>
            <th scope="col">Product</th>
            <th scope="col">Reviews</th>
            <th scope="col">Customer id</th>
            <th scope="col">Status</th>
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
                <td><?php echo $row['review']?></td>
                <td><?php echo $row['customer_id']?></td>
                <td><?php echo $row['status']?></td>
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