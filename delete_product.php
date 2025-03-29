<?php
require('connection.php');
session_start();

// Ensure user session variables are set
if (!isset($_SESSION['user_first_name']) || !isset($_SESSION['user_last_name'])) {
    header('Location: login.php');
    exit();
}

// Check if the product id is provided via GET
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']); // Ensure the id is an integer for security

    // Prepare the delete statement
    $sql = "DELETE FROM product WHERE product_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        // On successful deletion, redirect to the product list page
        header("Location: list_of_product.php");
        exit();
    } else {
        echo "Error deleting product: " . $stmt->error;
    }
} else {
    echo "No product ID specified.";
}
?>
