<?php
require('connection.php');
session_start();

// Check if session variables are set
if (isset($_SESSION['user_first_name']) && isset($_SESSION['user_last_name'])) {
    $user_first_name = $_SESSION['user_first_name'];
    $user_last_name = $_SESSION['user_last_name'];
    $date = date('d/m/Y');
} else {
    header('Location: login.php');
    exit();
}

// Fetch product details if editing
if (isset($_GET['id'])) {
    $store_product_id = $_GET['id'];

    // Fetch existing store product details
    $sql = "SELECT * FROM store_product WHERE store_product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $store_product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $store_product = $result->fetch_assoc();
        $store_product_name = $store_product['store_product_name'];
        $store_product_quantity = $store_product['store_product_quantity'];
        $store_product_entry_date = $store_product['store_product_entry_date'];
    } else {
        echo "Product not found!";
        exit();
    }
}

// Handle form submission for updating product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['store_product_name']) && isset($_POST['store_product_quantity']) && isset($_POST['store_product_entry_date'])) {
        $store_product_name = $_POST['store_product_name'];
        $store_product_quantity = $_POST['store_product_quantity'];
        $store_product_entry_date = $_POST['store_product_entry_date'];

        // Update product details
        $sql = "UPDATE store_product SET store_product_name = ?, store_product_quantity = ?, store_product_entry_date = ? WHERE store_product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisi", $store_product_name, $store_product_quantity, $store_product_entry_date, $store_product_id);

        if ($stmt->execute()) {
            echo 'Product Updated!';
            header('Location: list_of_store_product.php');
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
    }
}

// Fetch products for dropdown
$sql = "SELECT * FROM product";
$query = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="img/logo/logo.png" rel="icon">
    <title>Edit Store Product</title>
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
                </nav>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Edit Store Product</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Store Product</li>
                        </ol>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Update Store Product</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="form-group">
                                            <label for="storeProductName">Store Product Name</label>
                                            <select name="store_product_name" class="form-control" id="storeProductName" required>
                                                <option value="">Select Product</option>
                                                <?php
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $product_id = $data['product_id'];
                                                    $product_name = $data['product_name'];
                                                    $selected = ($store_product_name == $product_id) ? 'selected' : '';
                                                    echo "<option value='$product_id' $selected>$product_name</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="storeProductQuantity">Product Quantity</label>
                                            <input type="number" name="store_product_quantity" class="form-control" id="storeProductQuantity" min="1" value="<?php echo $store_product_quantity; ?>" required>
                                        </div>

                                        <div class="form-group" id="datePicker">
                                            <label for="storeProductEntryDate">Store Entry Date</label>
                                            <div class="input-group date">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                </div>
                                                <input type="text" name="store_product_entry_date" class="form-control" value="<?php echo $store_product_entry_date; ?>" id="storeProductEntryDate" required>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Update</button>
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
            $('#datePicker .input-group.date').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: 'linked',
                todayHighlight: true,
                autoclose: true
            });
        });
    </script>
</body>

</html>
