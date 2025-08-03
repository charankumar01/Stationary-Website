<?php
include('../include/user.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Email and Password are required";
    } else {
        $query = "SELECT id, name, email, password FROM customers WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];

            $success = "Login successful!";
        } else {
            $error = "Invalid email or password";
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
                        <h2>Login</h2>
                        <p>Sign into your account</p>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>Email</label>
                            <input type="email" name="email" placeholder="Your email here.." required>
                        </div>
                        <div class="col-lg-12">
                            <label>Password</label>
                            <input type="password" name="password" placeholder="Your password here.." required>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="tp-accountBtn">Login</button>
                        </div>
                    </div>
                    <p class="subText">Don't have an account? <a href="/user/pages/register.php">Create one</a></p>
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
            let ref = new URLSearchParams(window.location.search).get('ref');
            if (ref) {
                window.location.href = ref;
            } else {
                window.location.href = "/user/pages/index.php";
            }
        </script>
    <?php endif; ?>
</body>
</html>
