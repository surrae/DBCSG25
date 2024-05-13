<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Exit if user is not logged in
    exit();
}

// Check if userId and username are set
if (isset($_POST['userId']) && isset($_POST['username'])) {
    // Get the userId and username from the POST data
    $userId = $_POST['userId'];
    $username = $_POST['username'];

    // Get the username of the user who performed the operation
    $performer = isset($_SESSION['Name']) ? $_SESSION['Name'] : 'Unknown';

    // Log the delete action along with the performer's username
    $log_message = date("Y-m-d H:i:s") . " - Delete Action: User ID - " . $userId . ", Username - " . $username . ", Performed By - " . $performer . "\n";
    error_log($log_message, 3, "delete_log.txt"); // Write to a log file named "delete_log.txt"
}
?>
