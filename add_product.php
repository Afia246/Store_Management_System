<?php
require('connection.php');
session_start();

// Check if session variables are set
if(isset($_SESSION['user_first_name']) && isset($_SESSION['user_last_name'])) {
    $user_first_name = $_SESSION['user_first_name'];
    $user_last_name = $_SESSION['user_last_name'];
    $date = date('d/m/Y');
} else {
    // Redirect to login page if session variables are not set
    header('Location: login.php');
    exit();
}

// Handle form submission for adding product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['product_name']) && isset($_POST['product_category']) && isset($_POST['product_code']) && isset($_POST['product_entrydate'])) {
        $product_name = $_POST['product_name'];
        $product_category = $_POST['product_category'];
        $product_code = $_POST['product_code'];
        $product_entrydate = $_POST['product_entrydate'];

        // SQL query to insert product data
        $sql = "INSERT INTO product (product_name, product_category, product_code, product_entrydate) 
                VALUES ('$product_name', '$product_category', '$product_code', '$product_entrydate')";

        if ($conn->query($sql) === TRUE) {
            echo 'Product Data Inserted!';
            header('Location: list_of_product.php');
        } else {
            echo 'Product Data not Inserted!';
        }
    }
}

// Fetch categories for dropdown
$sql = "SELECT * FROM category";
$query = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/logo.png" rel="icon">
    <title>Add Product</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    <link href="vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
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
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Add Product</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Product</li>
                        </ol>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Insert Product</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="form-group">
                                            <label for="exampleInputProductName">Product Name</label>
                                            <input type="text" name="product_name" class="form-control" id="exampleInputProductName" placeholder="Enter Product Name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="productCategory">Product Category</label>
                                            <select name="product_category" class="form-control" id="productCategory" required>
                                                <option value="">Select Category</option>
                                                <?php
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $category_id = $data['category_id'];
                                                    $category_name = $data['category_name'];
                                                    echo "<option value='$category_id'>$category_name</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputProductCode">Product Code</label>
                                            <input type="text" name="product_code" class="form-control" id="exampleInputProductCode" placeholder="Enter Product Code" required>
                                        </div>

                                        <div class="form-group" id="simple-date1">
                                            <label for="simpleDataInput">Product Entry Date</label>
                                            <div class="input-group date">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                </div>
                                                <input type="text" name="product_entrydate" class="form-control" value="<?php echo $date ?>" id="simpleDataInput" required>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Submit</button>
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
    <script src="vendor/select2/dist/js/select2.min.js"></script>
    <script src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function () {
            // Date Picker Initialization
            $('#simple-date1 .input-group.date').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: 'linked',
                todayHighlight: true,
                autoclose: true
            });
        });
    </script>
</body>

</html>
