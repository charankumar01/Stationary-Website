<?php
include('../../includes/header.php');

$query = "SELECT * FROM customers";
$result = mysqli_query($conn, $query);
?>

<div class="dashboard-main-body">

  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Customers</h6>
    <ul class="d-flex align-items-center gap-2">
      <li class="fw-medium">
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/dashboard.php" class="d-flex align-items-center gap-1 hover-text-primary">
          <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
          Dashboard
        </a>
      </li>
      <li>-</li>
      <li class="fw-medium">Customers</li>
    </ul>
  </div>

  <div class="card basic-data-table">
    <div class="card-header">
      <h5 class="card-title mb-0">All Customers</h5>
    </div>
    <div class="card-body">
      <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
          ?>
              <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                  <?php 
                  if ($row['status'] == 'active') {
                    echo '<span class="badge bg-success">Active</span>';
                  } else if ($row['status'] == 'inactive') {
                    echo '<span class="badge bg-warning">Inactive</span>';
                  }  else {
                    echo '<span class="badge bg-danger">Suspended</span>';
                  }
                  ?>
                </td>
                <td>
                  <a href="delete.php?id=<?php echo $row['id']; ?>" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
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

  <?php
  include('../../includes/footer.php');
  ?>

</body>
</html>
