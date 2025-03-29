<?php
require('connection.php');
session_start();

// Ensure user session variables are set
if (!isset($_SESSION['user_first_name']) || !isset($_SESSION['user_last_name'])) {
    // Redirect to login page if session is not set
    header('Location: login.php');
    exit();
}

$user_first_name = $_SESSION['user_first_name'];
$user_last_name = $_SESSION['user_last_name'];

// Fetch categories from the database
$sql1 = "SELECT * FROM category";
$query1 = $conn->query($sql1);
$data_list = array();

while ($data1 = mysqli_fetch_assoc($query1)) {
    $category_id = $data1['category_id'];
    $category_name = $data1['category_name'];
    $data_list[$category_id] = $category_name;
}

// Fetch products from the database
$sql = "SELECT * FROM product";
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
    <title>RuangAdmin - Dashboard</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                        <h1 class="h3 mb-0 text-gray-800">Products</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Product List</li>
                        </ol>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Product List</h6>
                                </div>
                                <div class="table-responsive p-3">
                                    <table class="table align-items-center table-flush" id="dataTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>Product Code</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>Product Code</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            while ($data = mysqli_fetch_assoc($query)) {
                                                $product_id = $data['product_id'];
                                                $product_name = $data['product_name'];
                                                $product_category = $data['product_category'];
                                                $product_code = $data['product_code'];

                                                // Check if category exists, else show "Unknown Category"
                                                $category_name = isset($data_list[$product_category]) ? $data_list[$product_category] : "Unknown Category";
                                            ?>
                                                <tr>
                                                    <td><?php echo $product_name; ?></td>
                                                    <td><?php echo $category_name; ?></td>
                                                    <td><?php echo $product_code; ?></td>
                                                    <td>
                                                    <a href="edit_product.php?id=<?php echo $product_id; ?>" class="btn btn-success">
                                                     <i class="fas fa-edit"></i> Edit
                                                    </a>

                                                        <a href="delete_product.php?id=<?php echo $product_id; ?>" class="btn btn-danger mx-3">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
</body>

</html>
