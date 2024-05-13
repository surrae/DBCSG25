<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

include 'connect.php';

// Fetch user data based on the ID provided in the URL parameter
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $sql = "SELECT * FROM `crud` WHERE ID=?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $userData = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
} else {
    echo "User ID not provided.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        form {
            width: 50%;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Edit User</h2>

    <form action="update_user.php" method="post">
        <input type="hidden" name="id" value="<?php echo $userData['ID']; ?>">
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $userData['Name']; ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $userData['EMAIL']; ?>" required>
        
        <label for="mobile">Mobile:</label>
        <input type="tel" id="mobile" name="mobile" value="<?php echo $userData['Mobile']; ?>" required>
        
        <input type="submit" value="Update">
    </form>
</body>
</html>
