<?php
include 'connect.php';

// Check if the ID parameter is set
if(isset($_GET['id'])) {
    // Sanitize the ID parameter
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Prepare the SQL statement to delete the user with the specified ID
    $sql = "DELETE FROM `crud` WHERE `ID` = ?";
    
    // Create a prepared statement
    $stmt = mysqli_prepare($con, $sql);
    
    // Bind the ID parameter to the prepared statement
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    // Execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        // Redirect back to the display page after successful deletion
        header("Location: display.php");
        exit();
    } else {
        // Log the error instead of displaying it
        error_log("Error: " . mysqli_stmt_error($stmt));
        echo "An error occurred while deleting the user. Please try again later.";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request. User ID is not provided.";
}
?>
