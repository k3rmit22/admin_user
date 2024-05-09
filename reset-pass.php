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




<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="reset-pass.css">

    <title>Admin | Forgot Password</title>

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

        .input-error {
            border-color: red !important;
        }

        .input-success {
            border-color: green !important;
        }

        /* Center the container */
        .container-fluid {
            width: 100%; /* Adjust width as needed */
            max-width: 1200px; /* Set maximum width */
            margin: 0 auto; /* Center horizontally */
            padding-top: 10px; /* Adjust top padding */
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
                                <p class="mb-4">Just enter the email address below
                                    and we'll send you a link to reset your password!</p>
                            </div>
                            <form action="" method="post" onsubmit="return validateForm();">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user"
                                        id="email" name="email" aria-describedby="emailHelp"
                                        placeholder="Email Account" value="<?php echo $emailValue; ?>"
                                        <?php echo $emailError ? 'class="input-error"' : 'class="input-success"'; ?>>

                                    <!-- Error message -->
                                    <p id="validation-email" class="error-message"><?php echo $emailError; ?></p>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Send
                                </button>
                                <!-- Back Icon -->
                                <a href="index.php" class="btn btn-secondary btn-user btn-block mt-2">
                                    <i class="fas fa-arrow-left"></i> Back to Login <!-- Font Awesome Back Arrow Icon -->
                                </a>
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
    var emailInput = document.getElementById("email");
    emailInput.addEventListener("input", validateEmailInput);

    function validateEmailInput() {
        var emailValue = emailInput.value.trim();

        // Reset previous validation
        emailInput.classList.remove("input-error");
        emailInput.classList.remove("input-success");
        document.getElementById("validation-email").textContent = "";

        if (emailValue === "") {
            document.getElementById("validation-email").textContent = "Email is required";
            emailInput.classList.add("input-error");
        } else if (!isValidEmail(emailValue)) {
            document.getElementById("validation-email").textContent = "Invalid email format";
            emailInput.classList.add("input-error");
        } else {
            emailInput.classList.add("input-success");
        }
    }

    // Function to validate email format
    function isValidEmail(email) {
        // Using regular expression to validate email format
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }
</script>

</body>
</html>