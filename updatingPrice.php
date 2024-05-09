<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin_user";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if(isset($_POST['increaseBlackPrice'])) {
    // Get the submitted black price
    $blackPrice = $_POST['increaseBlackPrice'];
    
    // SQL statement to update black price in tbl_pricing
    $sql = "UPDATE tbl_pricing 
            SET AdjustedPrice = $blackPrice,
                LastUpdated = NOW()
            WHERE Color = 'Black'";
    
    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        // Redirect back to charts.php with success parameter
        header("Location: updatingPrice.php?success=1");
        exit();
    } else {
        echo "Error updating black price: " . $conn->error;
    }
}

// Check if form is submitted
if(isset($_POST['increaseColoredPrice'])) {
    // Get the submitted colored price
    $coloredPrice = $_POST['increaseColoredPrice'];
    
    // SQL statement to update colored price in tbl_pricing
    $sql = "UPDATE tbl_pricing 
            SET AdjustedPrice = $coloredPrice,
                LastUpdated = NOW()
            WHERE Color = 'Colored'";
    
    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        // Redirect back to charts.php with success parameter
        header("Location: updatingPrice.php?success=1");
        exit();
    } else {
        echo "Error updating colored price: " . $conn->error;
    }
}

// Close connection
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

    <title>Admin | Pricing</title>

    <!-- Custom fonts for this template-->
    <link href="vendor2/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        /* Reduce shadow intensity for all elements with .shadow class */
        .shadow {
            box-shadow: 0 0.3rem 0.2rem rgba(0, 0, 0, 0.05) !important;
        }

        body {
            font-family: 'Open Sans', sans-serif;
        }

        /* Style for the logo image */
        #logo {
            width: 30px;
            /* Adjust the width as needed */
            height: auto;
            margin-right: 10px;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin.html">
                <img id="logo" src="logo1.png" alt="SnapPrint Logo">
                <div class="sidebar-brand-text mx-1">SNAPPRINT</div>
            </a>


            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="admin.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="updatingPrice.php">
                    <i class="fas fa-fw fa-arrow-alt-circle-up"></i>
                    <span>Pricing</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="income.php">
                    <i class="fas fa-money-bill-alt"></i>
                    <span>Income</span></a>
            </li>

            <!-- Nav Item - REPORTS -->
            <li class="nav-item">
                <a class="nav-link" href="reports.php">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Reports</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Logout Button -->
                        <li class="nav-item">
                            <a class="nav-link text-gray-700 medium" href="#" data-toggle="modal"
                                data-target="#logoutModal">
                                <span class="mr-2 d-none d-lg-inline">Logout</span>
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-black-700"></i>
                            </a>
                        </li>
                    </ul>

                </nav>
                <!-- End of Topbar -->

                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Pricing</h1>
                    <p class="mb-4"><a>The admin is responsible for adjusting the pricing for both black and colored printing services.</a></p>

                    <!-- Pricing Adjustment Table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Update Price</h6>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Color</th>
                                        <th scope="col">Adjusting Pricing</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Black</td>
                                        <td>
                                            <form id="pricingFormBlack" method="post" action="updatingPrice.php">
                                                <div class="form-group">
                                                    <label for="increaseBlackPrice">Changing Black Price:</label>
                                                    <input type="text" class="form-control" id="increaseBlackPrice" name="increaseBlackPrice"
                                                        placeholder="Enter amount" maxlength="3" pattern="\d*" 
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                    <span class="error-message" style="color: red; display: none;">Please enter an amount.</span>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Colored</td>
                                        <td>
                                            <form id="pricingFormColor" method="post" action="updatingPrice.php">
                                                <div class="form-group">
                                                    <label for="increaseColoredPrice">Changing Colored Price:</label>
                                                    <input type="text" class="form-control" id="increaseColoredPrice" name="increaseColoredPrice"
                                                        placeholder="Enter amount" maxlength="3" pattern="\d*"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                    <span class="error-message" style="color: red; display: none;">Please enter an amount.</span>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Modal for Success Message -->
                    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="successModalLabel" style="color: blue">Update Successful</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    The initial prices have been successfully updated.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Error Message -->
                    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="errorModalLabel" style="color: red">Error</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Please enter an amount before updating the price.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- End of Container Fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; SnapPrint: Public Printing Machine 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



            <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Are you sure you want to logout?</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                        <a class="btn btn-primary" id="logoutConfirmBtn" href="index.php">Yes</a>
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

    <!-- jQuery Validation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <script>
   $(document).ready(function() {
    // Function to handle update button click
    $("form").submit(function(event) {
        // Prevent the default form submission behavior
        event.preventDefault();
        // Check if the price input field is empty
        var priceInput = $(this).find(".form-control");
        var priceValue = priceInput.val();
        // Validate if the input is a number
        if (/^\d+$/.test(priceValue)) {
            // Submit the form
            $(this).unbind('submit').submit();
        } else {
            // Show error modal
            $('#errorModal').modal('show');
        }
    });

    // Prevent default behavior of logout confirmation button
    $("#logoutConfirmBtn").click(function(event) {
        event.preventDefault();
        // Redirect to logout script or perform logout actions
        window.location.href = "index.php";
    });

    // Check if the success parameter is set in the URL
    <?php if(isset($_GET['success']) && $_GET['success'] == 1) { ?>
        // Show the success modal
        $('#successModal').modal('show');

        // Clear the URL parameters to prevent modal from showing on page refresh
        window.history.replaceState({}, document.title, window.location.pathname);
    <?php } ?>
});


</script>

</body>

</html>
