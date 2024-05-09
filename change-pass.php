<?php
// Check if the "token" parameter is present in the URL
if (!isset($_GET["token"])) {
    echo '<script>alert("Token not found");</script>';
    exit;
}

$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin_user";

$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    echo '<script>alert("Connection failed: ' . $mysqli->connect_error . '");</script>';
    exit;
}

$sql = "SELECT * FROM admin
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    echo '<script>alert("Token not found");</script>';
    exit;
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    echo '<script>alert("Token has expired");</script>';
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin | Reset Password</title>

    <!-- Custom fonts for this template-->
    <link href="vendor2/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        .error-message {
            color: red;
            margin-top: 5px; /* Add some margin to separate from the input */
        }

        /* Style for the logo */
        .logo {
            position: absolute;
            top: 20px; /* Adjust top position */
            left: 20px; /* Adjust left position */
            max-width: 100px; /* Set the max-width */
            width: 100%; /* Set width to 100% */
            height: auto; /* Maintain aspect ratio */
        }

        /* Center the container */
        .container-fluid {
            width: 100%; /* Adjust width as needed */
            max-width: 1200px; /* Set maximum width */
            margin: 0 auto; /* Center horizontally */
            padding-top: 130px; /* Adjust top padding */
            align-items: center;
        }


        body{
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url(images/440249158_1168914024141716_1974840806705842503_n.png);
            background-repeat: no-repeat;
            background-size: cover; /* Makes the background image cover the entire container */
            background-position: center;
        }

        
        .card {
            background-color: transparent; /* Make the card background transparent */
            backdrop-filter: blur(5px); /* Apply blur effect */
            border: none; /* Remove border */
        }
    </style>

</head>

<body>

    <div class="container-fluid"> <!-- Use container-fluid for full-width container -->
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-lg-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-2">Forgot Password</h1>
                                <p class="mb-4">Creating your new password.</p>

                                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                            </div>
                            
                            <form method="post" action="process-reset-pass.php" id="resetForm">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-user" id="password" 
                                               name="password" aria-describedby="emailHelp" placeholder="New Password">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="toggle-password">
                                                <i class="fas fa-eye" onclick="togglePasswordVisibility('password')"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Error message -->
                                    <p id="passwordError" class="error-message"></p>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-user" id="password_confirmation" 
                                               name="password_confirmation" aria-describedby="emailHelp" placeholder="Confirm Password">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="toggle-password-confirmation">
                                                <i class="fas fa-eye" onclick="togglePasswordVisibility('password_confirmation')"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Error message -->
                                    <span id="passwordConfirmationError" class="error-message"></span>
                                </div>

                                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>"> 
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Send
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor2/jquery/jquery.min.js"></script>
    <script src="vendor2/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor2/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- JavaScript validation -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const resetForm = document.getElementById("resetForm");
        const passwordInput = document.getElementById("password");
        const passwordConfirmationInput = document.getElementById("password_confirmation");
        const passwordError = document.getElementById("passwordError");
        const passwordConfirmationError = document.getElementById("passwordConfirmationError");

        // Function to validate password length
function validatePasswordLength() {
    let errorMessages = [];

    if (passwordInput.value.length < 8) {
        errorMessages.push("Password must be at least 8 characters");
    }

    validatePasswordCapitalLetter(errorMessages);
    validatePasswordNumber(errorMessages);

    // Set border color based on validation result
    if (errorMessages.length > 0) {
        setPasswordInputBorderColor('red');
    } else {
        setPasswordInputBorderColor('green');
    }

    // Display error messages vertically
    passwordError.innerHTML = errorMessages.map(message => `<div>${message}</div>`).join('');
}

// Function to validate password starts with a capital letter
function validatePasswordCapitalLetter(errorMessages) {
    if (!/^[A-Z]/.test(passwordInput.value)) {
        errorMessages.push("Password must start with a capital letter.");
    }
}

// Function to validate password contains at least one number
function validatePasswordNumber(errorMessages) {
    if (!/\d/.test(passwordInput.value)) {
        errorMessages.push("Password must contain at least one number.");
    }
}


        // Function to validate password confirmation
        function validatePasswordConfirmation() {
            if (passwordInput.value !== passwordConfirmationInput.value) {
                passwordConfirmationError.textContent = "Passwords do not match";
                setPasswordConfirmationInputBorderColor('red');
            } else {
                passwordConfirmationError.textContent = "";
                setPasswordConfirmationInputBorderColor('green');
            }
        }

        // Function to set password input border color
        function setPasswordInputBorderColor(color) {
            passwordInput.style.borderColor = color;
        }

        // Function to set password confirmation input border color
        function setPasswordConfirmationInputBorderColor(color) {
            passwordConfirmationInput.style.borderColor = color;
        }

        // Add event listeners for real-time validation
        passwordInput.addEventListener("input", function () {
            validatePasswordLength();
            validatePasswordConfirmation();
        });

        passwordConfirmationInput.addEventListener("input", validatePasswordConfirmation);

        // Add submit event listener for final validation
        resetForm.addEventListener("submit", function (event) {
            validatePasswordLength();
            validatePasswordConfirmation();

            // Prevent form submission if there are validation errors
            if (passwordError.textContent || passwordConfirmationError.textContent) {
                event.preventDefault();
            }
        });
    });

         // JavaScript function to toggle password visibility
         function togglePasswordVisibility(fieldId) {
        var passwordInput = document.getElementById(fieldId);
        var toggleIcon = document.querySelector("#toggle-" + fieldId + " i");

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
