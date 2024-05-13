<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['mobile'])) {
        $userId = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];

        // Fetch the current user data from the database
        $sql_select = "SELECT * FROM `crud` WHERE ID=?";
        $stmt_select = mysqli_prepare($con, $sql_select);
        mysqli_stmt_bind_param($stmt_select, "i", $userId);
        mysqli_stmt_execute($stmt_select);
        $result_select = mysqli_stmt_get_result($stmt_select);
        $userData = mysqli_fetch_assoc($result_select);
        mysqli_stmt_close($stmt_select);

        // Compare the old values with the new values
        $changes = [];
        if ($userData['Name'] !== $name) {
            $changes[] = "Name: " . $userData['Name'] . " -> " . $name;
        }
        if ($userData['EMAIL'] !== $email) {
            $changes[] = "Email: " . $userData['EMAIL'] . " -> " . $email;
        }
        if ($userData['Mobile'] !== $mobile) {
            $changes[] = "Mobile: " . $userData['Mobile'] . " -> " . $mobile;
        }

        // Update user data in the database
        $sql_update = "UPDATE `crud` SET Name=?, EMAIL=?, Mobile=? WHERE ID=?";
        $stmt_update = mysqli_prepare($con, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "sssi", $name, $email, $mobile, $userId);
        mysqli_stmt_execute($stmt_update);

        if (mysqli_stmt_affected_rows($stmt_update) > 0) {
            // Log the changes made by the user
            $log_message = date("Y-m-d H:i:s") . " - User ID: " . $userId . ", Changes: " . implode(", ", $changes) . "\n";
            error_log($log_message, 3, "user_changes.log");

            // User data updated successfully
            header("Location: display.php");
            exit();
        } else {
            echo "Failed to update user data.";
        }

        mysqli_stmt_close($stmt_update);
    } else {
        echo "Missing parameters.";
    }
} else {
    echo "Invalid request.";
}
?>
