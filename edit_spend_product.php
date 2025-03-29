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

// Fetch spend product details if editing
if (isset($_GET['id'])) {
    $spend_product_id = $_GET['id'];

    // Fetch existing spend product details
    $sql = "SELECT * FROM spend_product WHERE spend_product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $spend_product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $spend_product = $result->fetch_assoc();
        $spend_product_name = $spend_product['spend_product_name'];
        $spend_product_quantity = $spend_product['spend_product_quantity'];
        $spend_product_entry_date = $spend_product['spend_product_entry_date'];
    } else {
        echo "Product not found!";
        exit();
    }
}

// Handle form submission for updating spend product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['spend_product_name']) && isset($_POST['spend_product_quantity']) && isset($_POST['spend_product_date'])) {
        $spend_product_name = $_POST['spend_product_name'];
        $spend_product_quantity = (int)$_POST['spend_product_quantity']; // Ensure integer
        $spend_product_entry_date = $_POST['spend_product_date'];

        // Update spend product details
        $sql = "UPDATE spend_product SET spend_product_name = ?, spend_product_quantity = ?, spend_product_entry_date = ? WHERE spend_product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisi", $spend_product_name, $spend_product_quantity, $spend_product_entry_date, $spend_product_id);

        if ($stmt->execute()) {
            echo '<script>alert("Product Updated Successfully!");</script>';
            header('Location: list_of_spend_product.php');
            exit();
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="img/logo/logo.png" rel="icon">
    <title>Edit Spend Product</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="mt-4">Edit Spend Product</h1>
        <form method="POST">
            <div class="form-group">
                <label for="spendProductName">Spend Product Name</label>
                <select name="spend_product_name" class="form-control" required>
                    <option value="">Select Product</option>
                    <?php
                    while ($data = mysqli_fetch_array($query)) {
                        $product_id = $data['product_id'];
                        $product_name = $data['product_name'];
                        $selected = ($spend_product_name == $product_id) ? 'selected' : '';
                        echo "<option value='$product_id' $selected>$product_name</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="spendProductQuantity">Product Quantity</label>
                <input type="number" name="spend_product_quantity" class="form-control" min="1" value="<?php echo htmlspecialchars($spend_product_quantity); ?>" required>
            </div>
            <div class="form-group">
                <label for="spendProductDate">Spend Date</label>
                <input type="text" name="spend_product_date" class="form-control" value="<?php echo htmlspecialchars($spend_product_entry_date); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>

</html>
