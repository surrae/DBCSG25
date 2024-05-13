<?php
include 'connect.php';

$message = ""; // Variable to hold the message

// Function to log login attempts
function logLoginAttempt($username, $success) {
    $log_message = date("Y-m-d H:i:s") . " - Login Attempt: Username - " . $username . ", Success - " . ($success ? "Login successful" : "Login unsuccessful") . "\n";
    error_log($log_message, 3, "login_log.txt"); // Write to a log file named "login_log.txt"
}

// Login functionality
if(isset($_POST['login'])){
    // Validate and sanitize user input
    $login_name = filter_var($_POST['login_name'], FILTER_SANITIZE_STRING);
    $login_password = $_POST['login_password']; // No sanitization needed for passwords

    // Prepare and execute a SQL statement to fetch the user's data
    $sql = "SELECT * FROM `crud` WHERE name = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $login_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1){
        // Fetch the user's data from the result set
        $row = mysqli_fetch_assoc($result);

        // Verify the password
        if(password_verify($login_password, $row['Password'])){
            // Password is correct, set session variable and redirect to display page
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['Name'] = $login_name; // Store username in session for logging
            logLoginAttempt($login_name, true); // Log successful login attempt
            header("Location: display.php");
            exit();
        }else{
            logLoginAttempt($login_name, false); // Log failed login attempt
        }
    }else{
        logLoginAttempt($login_name, false); // Log failed login attempt
    }

    // Display generic message for user interface
    $message = "Wrong username or password";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login Form</title>
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
    <div><?php echo $message; ?></div> <!-- Display the message  if not empty -->
    <?php endif; ?>
    
    <!-- User Login Form -->
    <form action="" method="post">
        <h2>User Login Form</h2>
        <label for="login_name">Name:</label>
        <input type="text" id="login_name" name="login_name" required>
        
        <label for="login_password">Password:</label>
        <input type="password" id="login_password" name="login_password" required>
        
        <input type="submit" name="login" value="Login">
        <p>Don't have an account? <a href="user.php">Sign up</a></p>
    </form>
</body>
</html>
