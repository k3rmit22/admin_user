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
else{
    $sql ="SELECT * FROM tbl_income ";
    $result = mysqli_query($conn,$sql);
    // Check if the query executed successfully
    if ($result) {
        // Fetch data from the result
        while($row = mysqli_fetch_array($result)) {
            $datetime[] = $row['datetime'];
            $inserted_amount[] = $row['inserted_amount']; // Typo corrected: 'inserted_amount'
        }
    } else {
        echo "Error: " . mysqli_error($conn); // Print error message if query fails
    }
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

    <title>Admin | Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor2/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        /* Reduce shadow intensity for all elements with .shadow class */
    .shadow {
        box-shadow: 0 0.3rem 0.3rem rgba(0, 0, 0, 0.05) !important;
    }

     /* Set Open Sans as the font family */
        body {
            font-family: 'Open Sans', sans-serif;
        }

        /* Style for the logo image */
        #logo {
            width: 30px; /* Adjust the width as needed */
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
                            <a class="nav-link text-gray-700 medium" href="#" data-toggle="modal" data-target="#logoutModal">
                                <span class="mr-2 d-none d-lg-inline">Logout</span>
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-700"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                 <!-- Content Row -->
                <div class="row">

                    <!-- Area Chart -->
                    <div class="col-xl-12 col-lg-7">
                        <div class="card shadow mb-4" style="height: 500px;"> <!-- Adjusted height -->
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Income Chart</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-area" style="height: 400px;"> <!-- Adjusted height -->
                                    <canvas id="incomeChart" style="max-height:100%; max-width:100%;"></canvas> <!-- Adjusted size -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                </div>
                <!-- /.container-fluid -->

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
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
                <button class="btn btn-primary" id="logoutConfirmBtn">Yes</button>
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

    <!-- Page level plugins -->
    <script src="vendor2/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
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

    // Function to prevent back button after logout
    window.addEventListener("popstate", function () {
        // Redirect the user to index.php
        window.location.href = "index.php";
    });
</script>





    <script>
        // Hardcoded data for income from Monday to Friday
        var incomeData = <?php echo json_encode($inserted_amount)?>; // Adjust values as needed

        // Chart.js implementation
        var ctx = document.getElementById('incomeChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($datetime);?>,
        datasets: [{
            label: 'Income ($)',
            data: incomeData,
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',  // Red
                'rgba(54, 162, 235, 0.5)',   // Blue
                'rgba(255, 206, 86, 0.5)',   // Yellow
                'rgba(75, 192, 192, 0.5)',   // Green
                'rgba(153, 102, 255, 0.5)'  // Purple
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        legend: {
            onClick: null,
            labels: {
                boxWidth: 0,
                fontColor: 'blue'
            }
        }
    }
});



    </script>

    

</body>

</html>
