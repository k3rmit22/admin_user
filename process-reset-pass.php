<?php

// Check if the "token" parameter is present in the POST data
if (!isset($_POST["token"])) {
    showErrorModal("Token not found.");
    exit;
}

$token = $_POST["token"];
$token_hash = hash("sha256", $token);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin_user";

$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    showErrorModal("Connection failed: " . $mysqli->connect_error);
    exit;
}

$sql = "SELECT * FROM admin WHERE reset_token_hash = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    showErrorModal("Token not found.");
    exit;
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    showErrorModal("Token has expired.");
    exit;
}

$password = $_POST["password"];
$password_confirmation = $_POST["password_confirmation"];

// Password validation
if (strlen($password) < 8) {
    die("Password must be at least 8 characters");
}

if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $password)) {
    die("Password must contain at least one letter and one number");
}

if ($password !== $password_confirmation) {
    die("Passwords do not match");
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);


$sql = "UPDATE admin
        SET password_hash = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("si", $password_hash, $user["id"]);
$stmt->execute();

// Close the database connection
$stmt->close();
$mysqli->close();

showSuccessModal("Password updated successfully. You can now login.");

function showErrorModal($message) {
    echo '<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="errorModalLabel" style="color: red;">Error</h5>
                    </div>
                    <div class="modal-body">
                        '.$message.'
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-danger" href="reset-pass.php">Close</a>
                    </div>
                </div>
            </div>
        </div>';
}

function showSuccessModal($message) {
    echo '<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel" style="color: blue;">Success</h5>
                    </div>
                    <div class="modal-body">
                        '.$message.'
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-primary" href="index.php">Close</a>
                     </div>
                </div>
            </div>
        </div>';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password updated</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<!-- Your HTML content here -->

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- Script for modal initialization -->
<script>
    $(document).ready(function(){
        // Show error modal if it exists
        if ($('#errorModal').length) {
            $("#errorModal").modal("show");
        }

        // Show success modal if it exists
        if ($('#successModal').length) {
            $("#successModal").modal("show");
        }
    });
</script>

</body>
</html>
