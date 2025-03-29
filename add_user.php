<?php
require('connection.php');

// Handling Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_first_name'], $_GET['user_last_name'], $_GET['user_email'], $_GET['user_password'])) {
    // Fetching data from the URL parameters (GET method)
    $user_first_name = $_GET['user_first_name'];
    $user_last_name = $_GET['user_last_name'];
    $user_email = $_GET['user_email'];
    $user_password = $_GET['user_password'];

    // Insert data into the user table
    $sql = "INSERT INTO user (user_first_name, user_last_name, user_email, user_password) 
            VALUES ('$user_first_name', '$user_last_name', '$user_email', '$user_password')";

    if ($conn->query($sql) === TRUE) {
        // Success message before redirect
        echo '<p class="success">User successfully created! Redirecting to login page...</p>';
        // Immediately redirect to login page
        header("Location: login.php");
        exit();
    } else {
        echo '<p class="error">Data not Inserted: ' . $conn->error . '</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 14px;
            text-align: center;
        }

        .success {
            color: green;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Enter User Details</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
        <label for="user_first_name">User's First Name:</label>
        <input type="text" id="user_first_name" name="user_first_name" min="1" required>

        <label for="user_last_name">User's Last Name:</label>
        <input type="text" id="user_last_name" name="user_last_name" min="1" required>

        <label for="user_email">User's Email:</label>
        <input type="email" id="user_email" name="user_email" min="1" required>

        <label for="user_password">User's Password:</label>
        <input type="password" id="user_password" name="user_password" required>

        <input type="submit" value="Submit">
    </form>
</div>

</body>
</html>
