<?php
require('connection.php');
session_start();

// Ensure user session variables are set
if (!isset($_SESSION['user_first_name']) || !isset($_SESSION['user_last_name'])) {
    header('Location: login.php');
    exit();
}

$product_id = $product_name = $product_category = $product_code = $product_entrydate = '';

if (isset($_GET['id'])) {
    $getid = intval($_GET['id']); // Ensure $getid is an integer for security

    // Fetch the product data
    $sql = "SELECT * FROM product WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $getid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $product_id = $data['product_id'];
        $product_name = htmlspecialchars($data['product_name']); // Escape output
        $product_category = htmlspecialchars($data['product_category']);
        $product_code = htmlspecialchars($data['product_code']);
        $product_entrydate = htmlspecialchars($data['product_entrydate']);
    } else {
        echo "Product not found.";
        exit;
    }
}

// Handle Update Request using POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_name']) && isset($_POST['product_category']) && isset($_POST['product_code']) && isset($_POST['product_entrydate'])) {
        $new_product_id = intval($_POST['product_id']);
        $new_product_name = htmlspecialchars($_POST['product_name']);
        $new_product_category = htmlspecialchars($_POST['product_category']);
        $new_product_code = htmlspecialchars($_POST['product_code']);
        $new_product_entrydate = htmlspecialchars($_POST['product_entrydate']);

        // Update query
        $sql1 = "UPDATE product SET product_name = ?, product_category = ?, product_code = ?, product_entrydate = ? WHERE product_id = ?";
        $stmt = $conn->prepare($sql1);
        $stmt->bind_param("ssssi", $new_product_name, $new_product_category, $new_product_code, $new_product_entrydate, $new_product_id);

        if ($stmt->execute()) {
            echo "Update successful!";
            header('Location: list_of_product.php');
            exit;
        } else {
            echo "Update failed: " . $stmt->error;
        }
    } else {
        echo "All fields are required.";
    }
}

// Fetch category options for dropdown
$sql = "SELECT * FROM category";
$categoryQuery = $conn->query($sql);
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
    <title>Edit Product</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap DatePicker -->
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
                        <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                        </ol>
                    </div>

                    <div class="row mb-3">
                        <!-- Edit Product Form -->
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Edit Product</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="form-group">
                                            <label for="exampleInputProductName">Product Name</label>
                                            <input type="text" name="product_name" value="<?php echo htmlspecialchars($product_name ?? ''); ?>" class="form-control" id="exampleInputProductName" placeholder="Enter Product Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputProductCategory">Product Category</label>
                                            <select name="product_category" class="form-control" id="exampleInputProductCategory">
                                                <?php
                                                while ($category = mysqli_fetch_assoc($categoryQuery)) {
                                                    $cat_id = $category['category_id'];
                                                    $cat_name = $category['category_name'];
                                                    $selected = ($cat_id == ($product_category ?? '')) ? "selected" : "";
                                                    echo "<option value='$cat_id' $selected>$cat_name</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputProductCode">Product Code</label>
                                            <input type="text" name="product_code" value="<?php echo htmlspecialchars($product_code ?? ''); ?>" class="form-control" id="exampleInputProductCode" placeholder="Enter Product Code">
                                        </div>
                                        <div class="form-group" id="simple-date1">
                                            <label for="productEntryDate">Product Entry Date</label>
                                            <div class="input-group date">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                </div>
                                                <input type="text" name="product_entrydate" value="<?php echo htmlspecialchars($product_entrydate ?? ''); ?>" class="form-control" id="productEntryDate">
                                            </div>
                                        </div>
                                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id ?? ''); ?>">
                                        <button type="submit" class="btn btn-primary">Update Product</button>
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
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="vendor/select2/dist/js/select2.min.js"></script>
    <script src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
            // Initialize Date Picker for product entry date
            $('#productEntryDate').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: 'linked',
                todayHighlight: true,
                autoclose: true
            });
        });
    </script>
</body>
</html>
