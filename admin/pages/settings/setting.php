<?php
include('../../includes/header.php');

// Fetch the settings row
$settingsQuery = "SELECT * FROM settings WHERE id = 1";
$resultSetting = mysqli_query($conn, $settingsQuery);
$settingsExists = mysqli_num_rows($resultSetting) > 0;

if ($settingsExists) {
    $row = mysqli_fetch_assoc($resultSetting);
}

if (isset($_POST['submit'])) {
    $siteTitle = $_POST['site_title'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $facebook = $_POST['facebook'];
    $instagram = $_POST['instagram'];
    $twitter = $_POST['twitter'];
    $linkedin = $_POST['linkedin'];
    $about = $_POST['about'];
    
    // Handle logo upload
    $logo = $row['main_logo'] ?? ''; // Keep existing logo if no new one is uploaded
    if (!empty($_POST['logo'])) {
        $logo = $_POST['logo']; 
    } elseif (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $filename = $_FILES['logo']['name'];
        $temp_name = $_FILES['logo']['tmp_name'];
        move_uploaded_file($temp_name, '../../assets/images/' . $filename);
        $logo = $filename;
    }

    if ($settingsExists) {
        // Update the existing settings row
        $query = "UPDATE settings 
                  SET site_title = '$siteTitle', 
                      main_logo = '$logo', 
                      email = '$email', 
                      phone = '$phone', 
                      address = '$address', 
                      fb = '$facebook', 
                      insta = '$instagram', 
                      x = '$twitter', 
                      linkedin = '$linkedin', 
                      about = '$about'
                  WHERE id = 1";
    } else {
        // Insert new settings row
        $query = "INSERT INTO settings (id, site_title, main_logo, email, phone, address, fb, insta, x, linkedin, about) 
                  VALUES (1, '$siteTitle', '$logo', '$email', '$phone', '$address', '$facebook', '$instagram', '$twitter', '$linkedin', '$about')";
    }

    $result = mysqli_query($conn, $query);
    if ($result) {
        // echo "Settings saved successfully!";
    } else {
        // echo "Something went wrong!";
    }
}

?>
<div class="dashboard-main-body">

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Settings</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
        <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
            Dashboard
        </a>
        </li>
        <li>-</li>
        <li class="fw-medium">Settings</li>
    </ul>
</div>

<div class="row gy-4">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Add Settings</h5>
      </div>
      <div class="card-body">
        <div class="row gy-3">
          <form action="" method="post" enctype="multipart/form-data">
          <div class="col-12">
            <label class="form-label">Site Title</label>
            <input type="text" name="site_title" class="form-control" placeholder="Enter Site Title" value="<?= $row['site_title'] ?? '' ?>">
          </div>
          <div class="col-12">
            <label class="form-label">Main Logo</label>
            <input type="file" name="logo" class="form-control" placeholder="Main Logo" value="<?= $row['main_logo'] ?? '' ?>">
          </div>
          <div class="col-12">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter Email" value="<?= $row['email'] ?? '' ?>">
          </div>
          <div class="col-12">
            <label class="form-label">Phone</label>
            <input type="number" name="phone" class="form-control" placeholder="Enter Your Number" value="<?= $row['phone'] ?? '' ?>">
          </div>
          <div class="col-12">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" placeholder="Enter Your Address" value="<?= $row['address'] ?? '' ?>">
          </div>
          <div class="col-12">
            <label class="form-label">FaceBook</label>
            <input type="text" name="facebook" class="form-control" placeholder="Facebook" value="<?= $row['facebook'] ?? '' ?>">
          </div>
          <div class="col-12">
            <label class="form-label">Instagram</label>
            <input type="text" name="instagram" class="form-control" placeholder="Instagram" value="<?= $row['instagram'] ?? '' ?>">
          </div>
          <div class="col-12">
            <label class="form-label">Twitter</label>
            <input type="text" name="twitter" class="form-control" placeholder="Twitter" value="<?= $row['twitter'] ?? '' ?>">
          </div>
          <div class="col-12">
            <label class="form-label">Linkedin</label>
            <input type="text" name="linkedin" class="form-control" placeholder="Linkedin" value="<?= $row['linkedin'] ?? '' ?>">
          </div>
          <div class="col-12">
            <label class="form-label">About</label>
            <input type="text" name="about" class="form-control" placeholder="About" value="<?= $row['about'] ?? '' ?>">
          </div>
          <br>
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
