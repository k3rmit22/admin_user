<?php
session_start();

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
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to fetch user data by username
    $sql = "SELECT * FROM admin WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user["password_hash"])) {
            // Password is correct, set session and redirect to admin dashboard
            $_SESSION["user_id"] = $user["id"];
            header("Location: admin.php");
            exit();
        } else {
            // Password is incorrect, set error message and color validation
            $error_message = "Invalid username or password";
            $color_validation = "red";
        }
    } else {
        // User not found, set error message and color validation
        $error_message = "Invalid username or password";
        $color_validation = "red";
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="login.css">

    <title>Welcome Admin!</title>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>


</head>

<body>

    <div class="container">
        <div class="signup-section">
            <header>Welcome Admin!</header>

          

            <div class="separator">
                <div class="line"></div>
                
            </div>

            <form>
                <img src="images/logo_snapsnap-removebg-preview.png" alt="logo">
                <p> SnapPrint</p>
            </form>

        </div>

        <div class="login-section">
            <header>Login</header>

          

            <div class="separator">
                <div class="line"></div>
            </div>

            <form id="login-form" action="index.php" method="post">

                <p id="error-message" style="color: <?php echo $color_validation; ?>"><?php echo $error_message; ?></p>

                <div class="form-group">
                    <input type="text" id="username" class="form-control form-control-user" name="username"
                        aria-describedby="emailHelp" placeholder="Username">
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                        <div class="input-group-append"> <!-- Removed ID here -->
                            <span class="input-group-text toggle-password"> <!-- Removed ID here -->
                                <i class="fas fa-eye" onclick="togglePasswordVisibility()"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <a href="reset-pass.php">Forget Password?</a>
                <button type="submit" class="btn">Login</button>
            </form>

        </div>

    </div>


    <script src="script.js"></script>
    <script src="admin.js"></script>

    <script>
        // JavaScript to set input border color based on PHP validation result
        window.onload = function() {
            var error_message = "<?php echo $error_message; ?>";
            var color_validation = "<?php echo $color_validation; ?>";

            if (error_message !== "") {
                var usernameInput = document.getElementById("username");
                var passwordInput = document.getElementById("password");
                var errorMessageElement = document.getElementById("error-message");
                
                errorMessageElement.style.color = color_validation;
                usernameInput.style.borderColor = color_validation;
                passwordInput.style.borderColor = color_validation;
            }
        };
    </script>

<script>
    // JavaScript function to toggle password visibility
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var toggleIcon = document.querySelector(".toggle-password i"); // Updated selector

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }
</script>

</body>

</html>