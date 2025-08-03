<?php
include('../../includes/header.php');

$query = "SELECT name, email, message FROM contact";
$result = mysqli_query($conn, $query);
?>

<div class="dashboard-main-body">

  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Contacts</h6>
    <ul class="d-flex align-items-center gap-2">
      <li class="fw-medium">
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/dashboard.php" class="d-flex align-items-center gap-1 hover-text-primary">
          <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
          Dashboard
        </a>
      </li>
      <li>-</li>
      <li class="fw-medium">Contacts</li>
    </ul>
  </div>

  <div class="card basic-data-table">
    <div class="card-header">
      <h5 class="card-title mb-0">All Contacts</h5>
    </div>
    <div class="card-body">
      <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Message</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
          ?>
              <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
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
