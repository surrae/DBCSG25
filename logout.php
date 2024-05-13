<?php
// Start the session
session_start();




// Log logout action
$log_message = date("Y-m-d H:i:s") . " - Logout: User - " . $_SESSION['Name'] . "\n";
error_log($log_message, 3, "login_log.txt"); // Write to a log file named "login_log.txt"

// Unset all session variables
$_SESSION = [];
// Destroy the session
session_destroy();

// Redirect to the login page after logout
header("Location: login.php");
exit(); // Stop execution of the script
?>
