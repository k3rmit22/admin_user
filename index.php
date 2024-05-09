
<?php require_once 'components/config.php'?>
<?php
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
<?php require_once 'email.php'?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="src/mdb.min.css">
    <link rel="stylesheet" href="src/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
   integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Welcome Admin!</title>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
        body{
            background-color:rgb(239, 247, 255);
        }
        </style>

</head>

<body>
  
    <nav
      class="navbar navbar-expand-lg shadow-none sticky-top bg-primary"
      style="height: 85px; "
    >
      <div class="container">
        <a class="navbar-brand" href="#">
          <p class="fw-bold fs-4 mt-2 text-light">SnapPrint</p>
        </a>
     
      </div>
    </nav>



    <div class="container mt-5" >
            <!-- Section: Signup -->
    <section style="margin-top:100px">
      <!-- Jumbotron -->
      <div class="py-5 px-md-5 text-center text-lg-start">
        <div class="container">
          <div class="row gx-lg-5 align-items-center center-row">
            <div class="col-lg-6 col-md-auto col-sm-auto mb-5 mb-lg-0">
              <div class="card  border-0 ">
                <div class="card-body py-5 px-md-5 signup-form">
                    <div class="text-center text-md-star mb-5">
                      <h2 class="fw-bold mb-2 text-uppercase text-primary">Log In</h2>
                    </div>

                <form id="login-form" action="index.php" method="post">
                    <!-- Error message -->
                    <p id="error-message" style="color: <?php echo $color_validation; ?>"><?php echo $error_message; ?></p>
                    <!-- Username field -->
                    <div class="form-group">
                        <input type="text" id="username" class="form-control form-control-user" name="username"
                            aria-describedby="emailHelp" placeholder="Username">
                    </div>
                    <!-- Password field -->
                    <div class="form-group mt-3">
                        <div class="input-group">
                            <input type="password" class="form-control form-control-user" id="password" name="password"
                                placeholder="Password">
                            <div class="input-group-append">
                                <span class="input-group-text toggle-password" onclick="togglePasswordVisibility()">
                                    <i class="far fa-eye" id="eye-icon"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="container mt-5">
                        <div class="row text-center">
                        <!-- Link to open the modal -->
                        <a href="#" class="text-decoration-none" data-mdb-toggle="modal" data-mdb-target="#forgotPasswordModal">Forgot Password?</a>
                        </div>
                        <div class="row mt-3">
                        <button type="submit" class="btn shadow-none bg-primary text-light">Login</button>
                        </div>
                  
                    </div>
                </form>
    
                </div>
              </div>
            </div>

            <div
              class="col-lg-6 col-md-none col-sm-none mb-5 mb-lg-0 signup-image"
            >
              <div class="d-flex justify-content-center  h-100">
                <img
                  src="img/9896133_3435 [Converted].png"
                  class="img-fluid"
                 
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Jumbotron -->
    </section>
    </div>

        <!-- Modal -->
        <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form action="" method="post" onsubmit="return validateForm();" id="email-form">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="email" name="email" aria-describedby="emailHelp"
                                                placeholder="Email Account" value="<?php echo $emailValue; ?>"
                                                <?php echo $emailError ? 'class="input-error"' : 'class="input-success"'; ?>>

                                            <!-- Error message -->
                                            <p id="validation-email" class="error-message"><?php echo $emailError; ?></p>
                                        </div>
                                        <button type="submit" id="send-otp" class="btn btn-primary btn-user btn-block">
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



    <script src="script.js"></script>
    <script src="admin.js"></script>

    <script src="scripting/login.js">
    
    </script>
  <script>
        // Function to handle logout confirmation
        document.getElementById("logoutConfirmBtn").addEventListener("click", function () {
            // Remove the session storage item
            sessionStorage.removeItem("loggedIn");
            // Add an entry to the browser history
            history.pushState(null, document.title, "index.php");
            // Redirect the user to index.php
            window.location.href = "index.php";
        });

        // Prevent accessing admin.php after logout
        if (!sessionStorage.getItem("loggedIn")) {
            // Continuously replace the browser history with index.php
            setInterval(function () {
                history.replaceState(null, document.title, "index.php");
            }, 100);
        }
    </script>
<script>
  
</script>
<script type="text/javascript" src="src/mdb.min.js"></script>
<script type="text/javascript" src="src/bootstrap.min.js"></script>

</body>

</html>