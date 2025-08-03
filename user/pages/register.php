<?php
include ('../include/user.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Check if email already exists
        $query = "SELECT id FROM customers WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = "Email already registered";
        } else {
            // Insert user into database
            $query = "INSERT INTO customers (name, email, password) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);
            
            if (mysqli_stmt_execute($stmt)) {
                $success = "Registration successful!";
            } else {
                $error = "Something went wrong, please try again.";
            }
        }
    }
}
?>

<html lang="en">
<head>
    <?php include('../include/styles.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="tp-login-area">
        <div class="container">
            <form class="tp-accountWrapper justify-content-center" method="POST" action="">
                <div class="tp-accountForm form-style">
                    <div class="fromTitle">
                        <h2>Signup</h2>
                        <p>Create your account</p>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>Full Name</label>
                            <input type="text" name="name" placeholder="Your name here.." required>
                        </div>
                        <div class="col-lg-12">
                            <label>Email</label>
                            <input type="email" name="email" placeholder="Your email here.." required>
                        </div>
                        <div class="col-lg-12">
                            <label>Password</label>
                            <input type="password" name="password" placeholder="Your password here.." required>
                        </div>
                        <div class="col-lg-12">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" placeholder="Confirm Password.." required>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="tp-accountBtn">Signup</button>
                        </div>
                    </div>
                    <p class="subText">Already have an account? <a href="/user/pages/login.php">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <?php include('../include/scripts.php'); ?>

    <?php if (isset($error)): ?>
        <script>
            Swal.fire({
                title: "Error!",
                text: "<?php echo $error; ?>",
                icon: "error",
                confirmButtonText: "OK"
            });
        </script>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <script>
            Swal.fire({
                title: "Success!",
                text: "<?php echo $success; ?>",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "/user/pages/login.php";
            });
        </script>
    <?php endif; ?>
</body>
</html>
