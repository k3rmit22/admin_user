<?php session_start();

// Initialize error message
$error_message = "";
$color_validation = "red";

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin_user";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}?>