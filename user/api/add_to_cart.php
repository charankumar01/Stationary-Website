<?php

header('Content-Type: application/json');

include('../include/user.php');

// Get data from the request (POST)
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$amount = isset($_POST['amount']) ? intval($_POST['amount']) : 0;
$customer_id = isset($user['id']) ? $user['id'] : 0;

$response = [];

// Check if the customer is logged in
if ($customer_id == 0) {
    $response['status'] = 'fail';
    $response['message'] = 'You are not logged in, please login to continue.';
    echo json_encode($response);
    exit;
}

// Check if product_id and amount are valid
if ($product_id == 0 || $amount <= 0) {
    $response['status'] = 'fail';
    $response['message'] = 'Invalid product ID or amount.';
    echo json_encode($response);
    exit;
}

// Check if the product exists in the inventory (optional step)
$product_check_query = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($product_check_query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product_result = $stmt->get_result();

if ($product_result->num_rows == 0) {
    $response['status'] = 'fail';
    $response['message'] = 'Product not found.';
    echo json_encode($response);
    exit;
}

// Check if the product already exists in the customer's cart
$cart_check_query = "SELECT * FROM cart WHERE customer_id = ? AND product_id = ?";
$stmt = $conn->prepare($cart_check_query);
$stmt->bind_param("ii", $customer_id, $product_id);
$stmt->execute();
$cart_result = $stmt->get_result();

if ($cart_result->num_rows > 0) {
    // If the product is already in the cart, update the amount
    $cart_item = $cart_result->fetch_assoc();
    $new_amount = $cart_item['amount'] + $amount;

    $update_cart_query = "UPDATE cart SET amount = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
    $stmt = $conn->prepare($update_cart_query);
    $stmt->bind_param("ii", $new_amount, $cart_item['id']);
    $stmt->execute();

    // Get the updated cart count
    $cart_count_query = "SELECT SUM(amount) AS total_items FROM cart WHERE customer_id = ?";
    $stmt = $conn->prepare($cart_count_query);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $cart_count_result = $stmt->get_result();
    $cart_count = $cart_count_result->fetch_assoc()['total_items'];

    $response['status'] = 'success';
    $response['message'] = 'Product quantity updated in the cart.';
    $response['cart_count'] = $cart_count;
    echo json_encode($response);
    exit;

} else {
    // If the product is not in the cart, add it to the cart
    $insert_cart_query = "INSERT INTO cart (customer_id, product_id, amount) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_cart_query);
    $stmt->bind_param("iii", $customer_id, $product_id, $amount);
    $stmt->execute();

    // Get the updated cart count
    $cart_count_query = "SELECT SUM(amount) AS total_items FROM cart WHERE customer_id = ?";
    $stmt = $conn->prepare($cart_count_query);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $cart_count_result = $stmt->get_result();
    $cart_count = $cart_count_result->fetch_assoc()['total_items'];

    $response['status'] = 'success';
    $response['message'] = 'Product added to the cart.';
    $response['cart_count'] = $cart_count;
    echo json_encode($response);
    exit;
}

?>
