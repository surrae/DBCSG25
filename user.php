 <!-- User input is sanitized using filter_var() to prevent XSS attacks.
Passwords are hashed using password_hash() before storing them in the database.
Prepared statements are used to prevent SQL injection attacks.
Error messages are logged instead of being displayed to the user for security reasons. -->


<?php
include 'connect.php';

$message = ""; // Variable to hold the message

if(isset($_POST['submit'])){
    // Validate and sanitize user input
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $mobile = filter_var($_POST['mobile'], FILTER_SANITIZE_STRING);
    $password = $_POST['password']; // No sanitization needed for passwords

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO `crud` (name, email, mobile, password) VALUES (?, ?, ?, ?)";
    
    // Create a prepared statement
    $stmt = mysqli_prepare($con, $sql);
    
    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $mobile, $hashed_password);
    
    // Execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        $message = "Data inserted successfully"; // Set the message if successful
        // Redirect to the login page after successful registration
        header("Location: login.php");
        exit();
    }else{
        // Log the error instead of displaying it
        error_log("Error: " . mysqli_stmt_error($stmt));
        $message = "An error occurred. Please try again later.";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
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
        input[type="tel"],
        input[type="password"] {
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
    <?php if(!empty($message)): ?>
    <div><?php echo $message; ?></div> <!-- Display the message if not empty -->
    <?php endif; ?>
    
    <form action="" method="post">
        <h2>User Registration Form</h2>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="mobile">Mobile:</label>
        <input type="tel" id="mobile" name="mobile" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
