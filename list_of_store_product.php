<?php
require('connection.php');
session_start();

// Check if the user is logged in
$user_first_name = $_SESSION['user_first_name'];
$user_last_name = $_SESSION['user_last_name'];

if (!empty($user_first_name) && !empty($user_last_name)) {
    // Fetch store products and related data
    $sql = "SELECT sp.store_product_id, 
                   sp.store_product_quantity, 
                   sp.store_product_entry_date, 
                   p.product_name 
            FROM store_product sp
            JOIN product p ON sp.store_product_name = p.product_id"; // Assuming store_product_name stores product_id
    $query = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Store Products</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include 'sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
                    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                </nav>
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Store Products</h1>
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
                                                <th>ID</th>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>Entry Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sl = 0;
                                            while ($data = mysqli_fetch_assoc($query)) {
                                                $store_product_id = $data['store_product_id'];
                                                $store_product_name = $data['product_name'];
                                                $store_product_quantity = $data['store_product_quantity'];
                                                $store_product_entry_date = $data['store_product_entry_date'];
                                                $sl++;
                                            ?>
                                            <tr>
                                                <td><?php echo $sl; ?></td>
                                                <td><?php echo $store_product_name; ?></td>
                                                <td><?php echo $store_product_quantity; ?></td>
                                                <td><?php echo $store_product_entry_date; ?></td>
                                                <td>
                                                    <a href="edit_store_product.php?id=<?php echo $store_product_id; ?>" class="btn btn-success">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="delete_store_product.php?id=<?php echo $store_product_id; ?>" class="btn btn-danger mx-3">
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

<?php
} else {
    header('Location: login.php');
}
?>
