<?php
require('connection.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white; /* Changed from linear-gradient to white */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #0056b3;
        }

        input[type="email"], input[type="password"], input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }

        .error {
            color: red;
            font-size: 14px;
        }

        .register-link {
            margin-top: 15px;
            display: block;
            color: #007bff;
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<?php
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    $sql1 = "SELECT * FROM user WHERE user_email='$user_email' AND user_password='$user_password'";
    $query = $conn->query($sql1);

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);
        $_SESSION['user_first_name'] = $data['user_first_name'];
        $_SESSION['user_last_name'] = $data['user_last_name'];

        header('Location: index.php');
        exit();
    } else {
        $error_message = "Invalid email or password.";
    }
}
?>

<div class="login-container">
    <h2>Login</h2>
    <?php if ($error_message) { echo "<p class='error'>$error_message</p>"; } ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <input type="email" name="user_email" placeholder="Enter your email" required>
        <input type="password" name="user_password" placeholder="Enter your password" required>
        <input type="submit" value="Login">
    </form>

    <a class="register-link" href="add_user.php">Create an account</a> <!-- Link to registration page -->
</div>

</body>
</html>
