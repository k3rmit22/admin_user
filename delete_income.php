<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = ""; // Update with your database password
    $dbname = "admin_user";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to delete record
    $stmt = $conn->prepare("DELETE FROM tbl_income WHERE ID = ?");
    $stmt->bind_param("i", $_POST['id']);

    // Execute SQL statement
    if ($stmt->execute()) {
        echo "success"; // Return success message
    } else {
        echo "error"; // Return error message
    }

    // Close connections
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request"; // Return error message for invalid request
}
?>
