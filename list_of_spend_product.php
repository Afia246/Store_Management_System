<?php
require('connection.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_first_name']) || !isset($_SESSION['user_last_name'])) {
    header('Location: login.php');
    exit();
}

// Fetch categories and populate $data_list (if needed for any other purpose)
$sql1 = "SELECT * FROM category";
$query1 = $conn->query($sql1);

$data_list = array();

while ($data1 = mysqli_fetch_assoc($query1)) {
    $category_id = $data1['category_id'];
    $category_name = $data1['category_name'];
    $data_list[$category_id] = $category_name;
}

// Fetch spend products with actual names
$sql = "SELECT sp.spend_product_id, 
               sp.spend_product_quantity, 
               sp.spend_product_entry_date, 
               p.product_name 
        FROM spend_product sp
        JOIN product p ON sp.spend_product_name = p.product_id"; // Assuming spend_product_name stores product_id

$query = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>List of Spend Products</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
                    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                </nav>

                <!-- Page Content -->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">List of Spend Products</h1>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Spend Product List</h6>
                                </div>
                                <div class="table-responsive p-3">
                                    <table class="table align-items-center table-flush" id="dataTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>Entry Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($data = mysqli_fetch_assoc($query)) {
                                                $spend_product_id = $data['spend_product_id'];
                                                $spend_product_name = htmlspecialchars($data['product_name']); // Correct product name
                                                $spend_product_quantity = htmlspecialchars($data['spend_product_quantity']);
                                                $spend_product_entry_date = htmlspecialchars($data['spend_product_entry_date']);
                                            ?>
                                            <tr>
                                                <td><?php echo $spend_product_name; ?></td>
                                                <td><?php echo $spend_product_quantity; ?></td>
                                                <td><?php echo $spend_product_entry_date; ?></td>
                                                <td>
                                                    <a href="edit_spend_product.php?id=<?php echo $spend_product_id; ?>" class="btn btn-success">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="delete_spend_product.php?id=<?php echo $spend_product_id; ?>" class="btn btn-danger mx-3" onclick="return confirm('Are you sure you want to delete this product?');">
                                                        <i class="fas fa-trash"></i>
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
            </div>
        </div>
    </div>

    <!-- Scripts -->
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
