<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sensor_data'])) {
    // Data received from Arduino
    $coinValue = $_POST['sensor_data']; // Sensor data for coin value

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = ""; // Update with your database password
    $dbname = "admin_user";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO tbl_income (COLOR_OF_PAPER, NUMBER_OF_COPIES, TOTAL_AMOUNT) VALUES (?, ?, ?)");
    $stmt->bind_param("sid", $color_of_paper, $number_of_copies, $coinValue);

    // Execute SQL statement
    if ($stmt->execute()) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $totalAmountPaid = 0; // Initialize total amount paid variable
    if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $totalAmountPaid += $row["inserted_amount"]; // Add inserted_amount to total
        // Output other table data as before
    }
}

    // Close connection
    $stmt->close();
    $conn->close();
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

    <title>Admin | Income </title>

    <!-- Custom fonts for this template -->
    <link href="vendor2/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor2/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        /* Reduce shadow intensity for the sidebar and topbar */
        .sidebar {
            box-shadow: 0 0.3rem 0.3rem rgba(0, 0, 0, 0.05) !important;
        }
        
        .topbar {
            box-shadow: 0 0.3rem 0.3rem rgba(0, 0, 0, 0.05) !important;
        }

        /* Reduce shadow intensity for card elements */
        .card {
            box-shadow: 0 0.3rem 0.3rem rgba(0, 0, 0, 0.05) !important;
        }

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
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Logout Button -->
                        <li class="nav-item">
                            <a class="nav-link text-gray-700 medium" href="#" data-toggle="modal" data-target="#logoutModal">
                                <span class="mr-2 d-none d-lg-inline">Logout</span>
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-black-700"></i>
                            </a>
                        </li>
                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Profit / Income</h1>
                    <p class="mb-4"><a> The admin will monitor all the income based on the printed documents everyday.</a></p>
                        <!-- Content Row -->
                        <div class="row">

                            <!-- Table Area -->
                            <div class="col-xl-12 col-lg-7">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Income Data</h6>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="incomeTable" width="100%" cellspacing="0">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>File Name</th>
                                                <th>Date & Time</th>
                                                <th>Color</th>
                                                <th>Number of Copies</th>
                                                <th>Total Amount</th>
                                                <th>Amount Paid</th>
                                                <th>Action</th> <!-- New column for delete action -->
                                            </tr>
                                            </thead>

                                                <tbody>
                                                <?php
                                                    // Database connection parameters
                                                    $servername = "localhost";
                                                    $username = "root";
                                                    $password = ""; // Update with your database password
                                                    $dbname = "admin_user";

                                                    // Create connection
                                                    $conn = new mysqli($servername, $username, $password, $dbname);
                                                    // Check connection
                                                    if ($conn->connect_error) {
                                                        die("Connection failed: " . $conn->connect_error);
                                                    }

                                                    // Fetch data from the database
                                                    $sql = "SELECT * FROM tbl_income";
                                                    $result = $conn->query($sql);

                                                    // Initialize total amount paid variable
                                                    $totalAmountPaid = 0;

                                                    if ($result && $result->num_rows > 0) {
                                                        // Output data of each row
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo "<tr id='row_" . $row["ID"] . "'>"; // Add id attribute with row ID
                                                            echo "<td>" . $row["ID"] . "</td>";
                                                            echo "<td>" . $row["File_Name"] . "</td>";
                                                            echo "<td>" . $row["datetime"] . "</td>";
                                                            echo "<td>" . $row["COLOR_OF_PAPER"] . "</td>";
                                                            echo "<td>" . $row["NUMBER_OF_COPIES"] . "</td>";
                                                            echo "<td>" . $row["TOTAL_AMOUNT"] . "</td>";
                                                            echo "<td>" . $row["inserted_amount"] . "</td>";
                                                            echo "<td><button class='btn btn-sm btn-danger delete-btn' data-toggle='modal' data-target='#deleteModal' data-id='" . $row["ID"] . "'>";
                                                            echo "<i class='fas fa-trash'></i> Delete"; // Add icon before the text
                                                            echo "</button></td>";
                                                            
                                                            // Add the inserted_amount to the total amount paid
                                                            $totalAmountPaid += $row["inserted_amount"];
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='7'>No data available</td></tr>";
                                                    }

                                                    // Close connection
                                                    $conn->close();
                                                    ?>
                                                </tbody>

                                                <tfoot>
                                                    <tr>
                                                        <td colspan="6"><b>Total Amount Paid:</td>
                                                        <td colspan="2"><?php echo $totalAmountPaid; ?></td>
                                                    </tr>
                                                </tfoot>
                                                
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Confirmation Delete Modal-->
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Are you sure you want to delete this record?</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

                                                    

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
                    <a class="btn btn-primary" href="index.php">Yes</a>
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
    <script src="vendor2/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor2/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#incomeTable').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "pagingType": "full_numbers",
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search records",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "", // Empty string to remove the message
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                },
            }
        });

        // If records are found, remove the "No records available" message
        if ($('#incomeTable tbody tr').length > 0) {
            $('#incomeTable').DataTable().draw(); // Redraw the DataTable
        }
    });
</script>

<script>
$(document).ready(function() {
    var deleteId; // Variable to store ID of record to be deleted

    // Show confirmation delete modal when delete button is clicked
    $(document).on('click', '.delete-btn', function() {
        deleteId = $(this).data('id'); // Get ID of the record to be deleted
        $('#confirmDeleteModal').modal('show');
    });

    // Handle delete confirmation
    $('#confirmDeleteBtn').click(function() {
        // Send AJAX request to delete the record from the database
        $.ajax({
            url: 'delete_income.php',
            type: 'POST',
            data: { id: deleteId },
            success: function(response) {
                if (response === 'success') {
                    // Remove the row from the table
                    $('#row_' + deleteId).remove();
                    $('#confirmDeleteModal').modal('hide');
                } else {
                    alert('Failed to delete record.');
                }
            },
            error: function() {
                alert('Error occurred while deleting record.');
            }
        });
    });
});
</script>



</body>

</html>
