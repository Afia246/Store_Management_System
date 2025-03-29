<?php
require('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
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
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        a {
            text-decoration: none;
            color: white;
            background-color: #28a745;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
            transition: background 0.3s;
        }

        a:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>List of Users</h2>

    <?php
    // Fetch all users from the database
    $sql = "SELECT * FROM user";
    $query = $conn->query($sql);
    
    if ($query->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>";
    
        while ($data = $query->fetch_assoc()) {
            $user_id = $data['user_id'];
            $user_first_name = $data['user_first_name'];
            $user_last_name = $data['user_last_name'];
            $user_email = $data['user_email'];
    
            echo "<tr>
                    <td>$user_first_name</td>
                    <td>$user_last_name</td>
                    <td>$user_email</td>
                    <td><a href='edit_user.php?id=$user_id'>Edit</a></td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No users found.</p>";
    }
    ?>
</div>

</body>
</html>
