<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Database</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .logout {
            float: right;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>User Database</h2>

    <!-- Logout button -->
    <form action="logout.php" method="post" class="logout">
        <input type="submit" value="Logout" class="btn">
    </form>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM `crud`";
            $result = mysqli_query($con, $sql);
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['Name'] . "</td>";
                    echo "<td>" . $row['EMAIL'] . "</td>";
                    echo "<td>" . $row['Mobile'] . "</td>";
                    echo "<td>";
                    echo "<a href='edit_user.php?id=" . $row['ID'] . "' class='btn'>Edit</a>"; // Edit button redirects to edit_user.php with user ID as parameter
                    echo "<a href='#' class='btn' onclick='confirmDelete(" . $row['ID'] . ", \"" . $row['Name'] . "\")'>Delete</a>"; // Add onclick event for delete button
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No users found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- JavaScript function for confirmation popup -->
    <script>
        function confirmDelete(userId, username) {
            var confirmDelete = confirm("Are you sure you want to delete this user?");
            if (confirmDelete) {
                // Send AJAX request to log the delete action
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Log was successful
                            console.log("Delete action logged successfully");
                        } else {
                            // Log failed
                            console.error("Failed to log delete action");
                        }
                    }
                };
                xhr.open("POST", "log_delete.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("userId=" + userId + "&username=" + username);
                
                // Proceed with deleting the user
                window.location.href = "delete_user.php?id=" + userId;
            }
        }
    </script>
</body>
</html>
