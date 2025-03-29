<?php
require('connection.php');
session_start();

// Ensure user session variables are set
if (!isset($_SESSION['user_first_name']) || !isset($_SESSION['user_last_name'])) {
    header('Location: login.php');
    exit();
}

// Check if 'store_product_id' is passed in the URL
if (isset($_GET['id'])) {
    $store_product_id = $_GET['id'];  // Get the store product ID from URL
    
    // Confirm the deletion if the product exists
    $sql = "SELECT * FROM store_product WHERE store_product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $store_product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Product exists, proceed with deletion
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Prepare delete statement
            $delete_sql = "DELETE FROM store_product WHERE store_product_id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $store_product_id);
            
            if ($delete_stmt->execute()) {
                // Redirect to product list page after successful deletion
                header('Location: list_of_store_product.php');
                exit();
            } else {
                echo "<script>alert('Error: " . $delete_stmt->error . "');</script>";
            }
        }
    } else {
        echo "Product not found!";
        exit();
    }
} else {
    echo "No store product ID specified.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="img/logo/logo.png" rel="icon">
    <title>Delete Store Product</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        <!-- Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
                    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                </nav>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Delete Store Product</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Delete Store Product</li>
                        </ol>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Delete Store Product</h6>
                                </div>
                                <div class="card-body">
                                    <p>Are you sure you want to delete this store product?</p>
                                    <form method="POST">
                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                        <a href="list_of_store_product.php" class="btn btn-secondary">Cancel</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container Fluid-->
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
</body>

</html>
