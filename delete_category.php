<?php
require('connection.php');
session_start();

// Ensure user session variables are set
if (!isset($_SESSION['user_first_name']) || !isset($_SESSION['user_last_name'])) {
    header('Location: login.php');
    exit();
}

// Check if category ID is provided via GET
if (isset($_GET['id'])) {
    $category_id = intval($_GET['id']); // Sanitize the input

    // Prepare the delete query
    $sql = "DELETE FROM category WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("i", $category_id);

    if ($stmt->execute()) {
        // Successful deletion; redirect to list_of_category.php
        header("Location: list_of_category.php");
        exit();
    } else {
        echo "Error deleting category: " . $stmt->error;
    }
} else {
    echo "No category ID specified.";
}
?>
