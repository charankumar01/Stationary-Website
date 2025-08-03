<?php
include('../config.php');

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $adress = $_POST['adress'];
  $message = $_POST['message'];

  // Insert data into the contact table
  $query = "INSERT INTO `contact` (`name`, `email`, `adress`, `message`) 
            VALUES ('$name', '$email', '$adress', '$message')";
  $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="wpOceans">
  <link rel="shortcut icon" type="image/png" href="../assets/images/favicon.png">
  <title>Contact Us - Draftsy</title>

  <?php
  include('../include/styles.php');
  ?>

</head>

<body>

  <!-- start page-wrapper -->
  <div class="page-wrapper">
    <!-- start preloader -->
    <div class="preloader">
      <div class="vertical-centered-box">
        <div class="content">
          <div class="loader-circle"></div>
          <div class="loader-line-mask">
            <div class="loader-line"></div>
          </div>
          <img src="assets/images/preloader.png" alt="">
        </div>
      </div>
    </div>
    <!-- end preloader -->

    <!-- Start header -->
    <?php
      include('../include/header.php');
    ?>
    <!-- end of header -->
    <br>
    <br>
    <br>
    <br>

    <!-- start wpo-page-title -->
    <section class="wpo-page-title">
      <div class="container">
        <div class="row">
          <div class="col col-xs-12">
            <div class="wpo-breadcumb-wrap">
              <h2>Contact</h2>
              <ol class="wpo-breadcumb-wrap">
                <li><a href="index.php">Home</a></li>
                <li>Contact</li>
              </ol>
            </div>
          </div>
        </div> <!-- end row -->
      </div> <!-- end container -->
    </section>
    <!-- end page-title -->

    <!-- start wpo-contact-pg-section -->
    <section class="wpo-contact-pg-section section-padding">
      <div class="container">
        <div class="row">
          <div class="col col-lg-10 offset-lg-1">
            <div class="office-info">
              <div class="row">
                <div class="col col-xl-4 col-lg-6 col-md-6 col-12">
                  <div class="office-info-item">
                    <div class="office-info-icon">
                      <div class="icon">
                        <i class="fi flaticon-placeholder"></i>
                      </div>
                    </div>
                    <div class="office-info-text">
                      <h2>Address</h2>
                      <p>Aptech, SFC</p>
                    </div>
                  </div>
                </div>
                <div class="col col-xl-4 col-lg-6 col-md-6 col-12">
                  <div class="office-info-item">
                    <div class="office-info-icon">
                      <div class="icon">
                        <i class="fi flaticon-email"></i>
                      </div>
                    </div>
                    <div class="office-info-text">
                      <h2>Email Us</h2>
                      <p>stationary@gmail.com</p>
                      <p>stationary@gmail.com</p>
                    </div>
                  </div>
                </div>
                <div class="col col-xl-4 col-lg-6 col-md-6 col-12">
                  <div class="office-info-item">
                    <div class="office-info-icon">
                      <div class="icon">
                        <i class="fi flaticon-phone-call"></i>
                      </div>
                    </div>
                    <div class="office-info-text">
                      <h2>Call Now</h2>
                      <p>123 456 789</p>
                      <p>123 456 789</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="wpo-contact-title">
              <h2>Have Any Question?</h2>
              <p>It is a long established fact that a reader will be distracted
                content of a page when looking.</p>
            </div>
            <div class="wpo-contact-form-area">
              <form method="post" enctype="multipart/form-data" class="contact-validation-active">
                <div>
                  <input type="text" class="form-control" name="name" id="name"
                    placeholder="Your Name*">
                </div>
                <div>
                  <input type="email" class="form-control" name="email" id="email"
                    placeholder="Your Email*">
                </div>
                <div>
                  <input type="text" class="form-control" name="adress" id="adress"
                    placeholder="Adress">
                </div>
                <div class="fullwidth">
                  <textarea class="form-control" name="message" id="message"
                    placeholder="Message..."></textarea>
                </div>
                <div class="submit-area">
                  <button type="submit" name="submit" class="theme-btn">Get in Touch</button>
                  <div id="loader">
                    <i class="ti-reload"></i>
                  </div>
                </div>
                <div class="clearfix error-handling-messages">
                  <div id="success">Thank you</div>
                  <div id="error"> Error occurred while sending email. Please try again later. </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div> <!-- end container -->
    </section>
    <!-- end wpo-contact-pg-section -->

    <!--  start wpo-contact-map -->
    <section class="wpo-contact-map-section">
      <h2 class="hidden">Contact map</h2>
      <div class="wpo-contact-map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3620.0170064238687!2d67.07182317559541!3d24.863268745144904!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb33ea3db108f41%3A0x42acc4507358b160!2sAptech%20Learning%2C%20Shahrah%20e%20Faisal%20Center!5e0!3m2!1sen!2s!4v1738769129347!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </section>

    <?php
    include('../include/footer.php');

    ?>

  </div>
  <?php
  include('../include/scripts.php');

  // Use SweetAlert to display the message
  if (!isset($_POST['submit'])) {
    // pass
  }
  else if ($result) {
    echo "
    <script>
      Swal.fire({
        title: 'Success!',
        text: 'Your message has been sent successfully!',
        icon: 'success',
        confirmButtonText: 'Great!'
      });
    </script>
    ";
  } else {
    echo "
    <script>
      Swal.fire({
        title: 'Error!',
        text: 'Something went wrong. Please try again later.',
        icon: 'error',
        confirmButtonText: 'Try Again'
      });
    </script>
    ";
  }
  ?>
</body>

</html>