<?php
require('connection.php');
session_start();
$user_first_name = $_SESSION['user_first_name'];
$user_last_name = $_SESSION['user_last_name'];

if (!empty($user_first_name) && !empty($user_last_name)) {
    $sql3 = "SELECT * from product";
    $query3 = $conn->query($sql3);
    $data_list = array();
    
    while ($data3 = mysqli_fetch_assoc($query3)) {
        $product_id = $data3['product_id'];
        $product_name = $data3['product_name'];
        $data_list[$product_id] = $product_name;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        /* Blue Theme Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #0056b3;
        }
        select, input[type="submit"] {
            padding: 10px;
            margin: 10px;
            border: 1px solid #0056b3;
            border-radius: 5px;
        }
        select {
            width: 60%;
            background: #e6f2ff;
        }
        input[type="submit"] {
            background-color: #0056b3;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #003d80;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #0056b3;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #0056b3;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #e6f2ff;
        }
        tr:hover {
            background-color: #cce0ff;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Generate Report</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
        <label>Select Product Name:</label>
        <select name="product_name">
            <?php
            $sql = "SELECT * FROM product";
            $query = $conn->query($sql);

            while ($data = mysqli_fetch_assoc($query)) {
                $product_id = $data['product_id'];
                $product_name = $data['product_name'];
            ?>
                <option value="<?php echo $product_id; ?>"><?php echo $product_name; ?></option>
            <?php 
            } 
            ?>
        </select>
        <input type="submit" value="Generate Report">
    </form>

    <h1>Store Product</h1>
    <?php 
    if (isset($_GET['product_name'])) {
        $product_name = $_GET['product_name'];
        
        $sql1 = "SELECT * FROM store_product WHERE store_product_name='$product_name'";
        $query1 = $conn->query($sql1);

        echo "<table><tr><th>Store Date</th><th>Product Quantity</th></tr>";

        while ($data1 = mysqli_fetch_array($query1)) {
            $store_product_quantity = $data1['store_product_quantity'];
            $store_product_entry_date = $data1['store_product_entry_date'];

            echo "<tr><td>$store_product_entry_date</td><td>$store_product_quantity</td></tr>";
        }

        echo "</table>";
    }
    ?>

    <h1>Spend Product</h1>
    <?php 
    if (isset($_GET['product_name'])) {
        $product_name = $_GET['product_name'];
        
        $sql4 = "SELECT * FROM spend_product WHERE spend_product_name='$product_name'";
        $query4 = $conn->query($sql4);

        echo "<table><tr><th>Spend Date</th><th>Product Quantity</th></tr>";

        while ($data4 = mysqli_fetch_array($query4)) {
            $spend_product_quantity = $data4['spend_product_quantity'];
            $spend_product_entry_date = $data4['spend_product_entry_date'];

            echo "<tr><td>$spend_product_entry_date</td><td>$spend_product_quantity</td></tr>";
        }

        echo "</table>";
    }
    ?>
</div>

</body>
</html>

<?php 
} else {
    header('Location: login.php');
    exit();
}
?>
