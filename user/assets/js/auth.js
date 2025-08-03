function registerUser() {
    var name = document.getElementById("register_name").value;
    var email = document.getElementById("register_email").value;
    var password = document.getElementById("register_password").value;
    var register_confirm_password = document.getElementById("register_confirm_password").value;

    fetch("/user/pages/register.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `name=${name}&email=${email}&password=${password}&confirm_password=${register_confirm_password}`
    })
    .then(response => response.json())
    .then(data => {
        Swal.fire({
            title: data.status === "success" ? "Success" : "Error",
            text: data.message,
            icon: data.status,
            confirmButtonText: "OK"
        }).then(() => {
            if (data.status === "success") window.location.href = "login.php";
        });
    });
}

function loginUser() {
    var email = document.getElementById("login_email").value;
    var password = document.getElementById("login_password").value;

    fetch("login.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `email=${email}&password=${password}`
    })
    .then(response => response.json())
    .then(data => {
        Swal.fire({
            title: data.status === "success" ? "Welcome!" : "Error",
            text: data.message,
            icon: data.status,
            confirmButtonText: "OK"
        }).then(() => {
            if (data.status === "success") window.location.href = "dashboard.php";
        });
    });
}

function logoutUser() {
    fetch("logout.php")
    .then(response => response.json())
    .then(data => {
        Swal.fire({
            title: "Goodbye!",
            text: data.message,
            icon: "success",
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = "login.php";
        });
    });
}
