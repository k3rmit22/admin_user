<?php
$emailError = "";
$emailValue = ""; // Initialize variables to store input values

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    $emailValue = $_POST["email"]; // Store the email input value
    if (empty($emailValue)) {
        $emailError = "Email is required";
    } elseif (!filter_var($emailValue, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format";
    } else {
        // If email is valid, redirect to send_password.php to process the password reset
        header("Location: send-pass.php?email=" . urlencode($emailValue));
        exit();
    }
} 
?>