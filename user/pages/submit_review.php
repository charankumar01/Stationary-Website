<?php
include_once '../include/user.php';

if (!$user_logged_in) {
    header("Location: /user/pages/login.php?ref=/user/pages/order.php");
    die();
}

// Ensure required data is received
if (isset($_POST['product_id'], $_POST['review'], $_POST['stars'])) {
    $customer_id = $user['id'];
    $product_id = $_POST['product_id'];
    $review = mysqli_real_escape_string($conn, $_POST['review']);
    $stars = intval($_POST['stars']);  // Rating from 1 to 5

    // Check if a review already exists for this customer and product
    $checkReviewQuery = "SELECT id FROM product_reviews WHERE prod_id = ? AND customer_id = ?";
    $checkReviewStmt = mysqli_prepare($conn, $checkReviewQuery);
    mysqli_stmt_bind_param($checkReviewStmt, "ii", $product_id, $customer_id);
    mysqli_stmt_execute($checkReviewStmt);
    $checkReviewResult = mysqli_stmt_get_result($checkReviewStmt);

    if (mysqli_num_rows($checkReviewResult) > 0) {
        // If the user has already reviewed, don't allow new review
        echo "You have already reviewed this product.";
    } else {
        // Insert new review
        $insertReviewQuery = "INSERT INTO product_reviews (prod_id, review, rating, customer_id, status) 
                              VALUES (?, ?, ?, ?, 'approved')";
        $insertReviewStmt = mysqli_prepare($conn, $insertReviewQuery);
        mysqli_stmt_bind_param($insertReviewStmt, "isii", $product_id, $review, $stars, $customer_id);
        
        if (mysqli_stmt_execute($insertReviewStmt)) {
            header("Location: /user/pages/product.php?product_id=$product_id");
            echo "Your review has been submitted.";
        } else {
            echo "There was an error submitting your review. Please try again.";
        }
    }
} else {
    echo "Required data is missing.";
}
?>
