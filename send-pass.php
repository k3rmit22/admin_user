<?php

// Validate if email is provided in the GET request
if (!isset($_GET["email"]) || empty($_GET["email"])) {
    die("Error: Email is required.");
}

$email = $_GET["email"];

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

// Set the timezone to Philippines (Asia/Manila)
date_default_timezone_set('Asia/Manila');

// Get the current time in the Philippines
$current_time = new DateTime();

// Add 10 minutes to the current time
$expiry = $current_time->add(new DateInterval('PT10M'))->format('Y-m-d H:i:s');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin_user";

$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "UPDATE admin
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

$stmt = $mysqli->prepare($sql);

// Validate if the prepare statement is successful
if (!$stmt) {
    die("Error preparing statement: " . $mysqli->error);
}

// Bind parameters separately with their correct types
$stmt->bind_param("sss", $token_hash, $expiry, $email);

// Validate if the bind_param is successful
if (!$stmt->execute()) {
    die("Error updating database: " . $mysqli->error);
}

if ($mysqli->affected_rows) {
    // Include the PHPMailer library
    require 'vendor/autoload.php';

    // Create a new PHPMailer instance
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    // SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp-relay.brevo.com'; // Specify your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'aikadv01@gmail.com'; // SMTP username
    $mail->Password = 'AafdJVW5sI3Uyvm8'; // SMTP password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Email settings
    $mail->setFrom('aika@example.com', 'SnapPrint'); // Sender's email address and name
    $mail->addAddress($email); // Recipient's email address
    $mail->Subject = 'Password Reset'; // Email subject
    $mail->isHTML(true); // Set email format to HTML
    $mail->Body = 'Click <a href="http://localhost/admin_user/change-pass.php?token=' . $token . '">here</a> to reset your password.'; // Email body

    try {
        // Validate if the email is sent successfully
        if ($mail->send()) {
            echo '<script>
                    $(document).ready(function(){
                        $("#successModal").modal("show");
                    });
                  </script>';
        } else {
            throw new Exception("Message could not be sent. Mailer error: {$mail->ErrorInfo}");
        }
    } catch (Exception $e) {
        echo '<script>
                $(document).ready(function(){
                    $("#errorModal").find(".modal-body").text("' . $e->getMessage() . '");
                    $("#errorModal").modal("show");
                });
              </script>';
    }
} else {
    echo '<script>
            $(document).ready(function(){
                $("#errorModal").modal("show");
            });
          </script>';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Your head content here -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>Send Email For Password</title>
</head>

<body>
    <!-- Your body content here -->

    <!-- Modal for Success Message -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel" style="color: blue;">Success</h5>
                </div>
                <div class="modal-body">
                    Message sent, please check your inbox.
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary" href="https://mail.google.com">Go to Gmail</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Error Message -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel" style="color: red;">Error</h5>
                </div>
                <div class="modal-body">
                    No email found.
                </div>
                <div class="modal-footer">
                    <a class="btn btn-danger" href="reset-pass.php">Close</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Ensure jQuery is ready
        $(document).ready(function() {
            // Show the modal based on PHP logic
            <?php
            if ($mysqli->affected_rows) {
                echo '$("#successModal").modal("show");';
            } else {
                echo '$("#errorModal").modal("show");';
            }
            ?>
        });
    </script>
</body>

</html>
