<?php
require('connection.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_first_name']) || !isset($_SESSION['user_last_name'])) {
    header('Location: login.php');
    exit();
}

// Check if spend_product_id is provided in GET request
if (isset($_GET['id'])) {
    $spend_product_id = (int)$_GET['id']; // Ensure it's an integer

    // Prepare DELETE query
    $sql = "DELETE FROM spend_product WHERE spend_product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $spend_product_id);

    if ($stmt->execute()) {
        echo '<script>alert("Product Deleted Successfully!");</script>';
        header('Location: list_of_spend_product.php');
        exit();
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
} else {
    echo "<script>alert('Invalid Request: No ID Provided!');</script>";
    header('Location: list_of_spend_product.php');
    exit();
}
?>
