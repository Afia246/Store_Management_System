<?php
require('connection.php');

// Initialize variables
$user_id = $user_first_name = $user_last_name = $user_email = $user_password = "";

// Fetch user details
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $getid = $_GET['id'];
    
    $stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
    $stmt->bind_param("i", $getid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        
        $user_id = $data['user_id'];
        $user_first_name = $data['user_first_name'];
        $user_last_name = $data['user_last_name'];
        $user_email = $data['user_email'];
        $user_password = $data['user_password'];
    } else {
        echo "<p style='color: red;'>User not found!</p>";
        exit;
    }
    $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['user_id'], $_POST['user_first_name'], $_POST['user_last_name'], $_POST['user_email'], $_POST['user_password'])) {
        $new_user_id = $_POST['user_id'];
        $new_user_first_name = $_POST['user_first_name'];
        $new_user_last_name = $_POST['user_last_name'];
        $new_user_email = $_POST['user_email'];
        $new_user_password = $_POST['user_password'];

        if (!is_numeric($new_user_id)) {
            die("<p style='color: red;'>Invalid User ID.</p>");
        }

        // Debugging: Check if form data is received
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";

        // Update user
        $stmt = $conn->prepare("UPDATE user SET user_first_name=?, user_last_name=?, user_email=?, user_password=? WHERE user_id=?");
        $stmt->bind_param("ssssi", $new_user_first_name, $new_user_last_name, $new_user_email, $new_user_password, $new_user_id);

        if ($stmt->execute()) {
            header("Location: list_of_user.php");
            exit;
        } else {
            echo "<p style='color: red;'>Error updating record: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color: red;'>Missing required fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>

<h2>Edit User</h2>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">

    <label>First Name:</label><br>
    <input type="text" name="user_first_name" value="<?php echo htmlspecialchars($user_first_name); ?>" required><br>

    <label>Last Name:</label><br>
    <input type="text" name="user_last_name" value="<?php echo htmlspecialchars($user_last_name); ?>" required><br>

    <label>Email:</label><br>
    <input type="email" name="user_email" value="<?php echo htmlspecialchars($user_email); ?>" required><br>

    <label>Password:</label><br>
    <input type="password" name="user_password" value="<?php echo htmlspecialchars($user_password); ?>" required><br>

    <input type="submit" value="Update">
</form>

<a href="list_of_user.php">Back to Users List</a>

</body>
</html>
