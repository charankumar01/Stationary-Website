function addToCart(productId, customerId = null, amount = 1) {
    // Validate productId and amount
    if (!productId || !amount || amount <= 0) {
        Swal.fire({
            title: 'Error!',
            text: 'Invalid product ID or amount.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    if (!customerId) {
        Swal.fire({
            title: 'Warning!',
            text: 'You need to log in to add items to your cart.',
            icon: 'warning',
            confirmButtonText: 'Login'
        }).then(() => {
            window.location.href = `/user/pages/login.php?ref=${window.location.pathname}`; // Redirect to login page
        });
        return;
    }

    // Prepare data to send to the API
    const data = new FormData();
    data.append('product_id', productId);
    data.append('customer_id', customerId);
    data.append('amount', amount);

    // Make the API call
    fetch('/user/api/add_to_cart.php', {
        method: 'POST',
        body: data
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                title: 'Success!',
                html: `Item(s) Added to Cart <br> Total Items: ${data.cart_count} </br>`,
                icon: 'success',
                confirmButtonText: 'Great!',
                showCancelButton: true,
                cancelButtonText: 'View Cart',
                reverseButtons: true  // Makes "View Cart" appear on the left
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.href = '/user/pages/cart.php'; // Redirect to cart page
                }
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error!',
            text: 'Something went wrong while adding the product to your cart. Please try again later.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
}

function productQuickView(productId) {
    // Check if productId is provided
    if (!productId) {
        Swal.fire({
            title: 'Error!',
            text: 'Product ID is required',
            icon: 'error',
            confirmButtonText: 'Ok'
        });
        return;
    }

    // Show loading cursor while request is running
    document.body.style.cursor = 'wait'; // Set loading cursor

    // Prepare data to send to the API
    const data = new FormData();
    data.append('product_id', productId);

    // Send request to the API to fetch product details
    fetch('/user/api/product_view.php', {
        method: 'POST',
        body: data
    })
    .then(response => response.text()) // API should return HTML as response
    .then(html => {
        // Insert the returned HTML into the modal body
        document.querySelector('#popup-quickview .modal-body').innerHTML = html;

        // Hide the loading cursor
        document.body.style.cursor = 'default';

        // Show the modal
        const modal = new bootstrap.Modal(document.getElementById('popup-quickview'));
        modal.show();
    })
    .catch(error => {
        console.error('Error fetching product details:', error);
        
        // Hide the loading cursor
        document.body.style.cursor = 'default';

        Swal.fire({
            title: 'Error!',
            text: 'Something went wrong while loading the product details. Please try again later.',
            icon: 'error',
            confirmButtonText: 'Ok'
        });
    });
}


function subscribeNewsletter() {
    var email = document.getElementById("newsletter-email").value.trim();

    if (email === "") {
        return;
    }

    fetch('/user/api/subscribe.php', {
        method: 'POST',
        body: new URLSearchParams({
            'email': email
        }),
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
    .then(response => response.json())  // Parse the JSON response from the server
    .then(data => {
        // Show success or error message using SweetAlert
        if (data.status === 'success') {
            Swal.fire({
                title: 'Success!',
                text: data.message,  // Use the message returned from the PHP script
                icon: 'success',
                confirmButtonText: 'Cool'
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: data.message,  // Use the error message returned from the PHP script
                icon: 'error',
                confirmButtonText: 'Try Again'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'Error!',
            text: 'Something went wrong. Please try again later.',
            icon: 'error',
            confirmButtonText: 'Ok'
        });
    });
}

