<?php
// Database configuration
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

require_once 'email_functions.php';

// Function to insert notification
function insertNotification( $issue, $datetime, $defaultStatus, $action) {
    global $conn;
    
    // Set the timezone to Asia/Manila
    date_default_timezone_set('Asia/Manila');
    
    // Get the current datetime in 12-hour format with AM/PM indicator
    $datetime = date('Y-m-d h:i:s A');
    
    $defaultStatus = "Pending"; // Set the default status
    $sql = "INSERT INTO tbl_reports (issue, datetime, status, action) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Bind parameters including the default status
    $stmt->bind_param("ssss", $issue, $datetime, $defaultStatus, $action);
    
    if ($stmt->execute()) {
        return true; // Notification inserted successfully
    } else {
        return false; // Failed to insert notification
    }
}

// Function to fetch all notifications
function getAllNotifications() {
    global $conn;
    $sql = "SELECT * FROM tbl_reports ORDER BY datetime DESC";
    $result = $conn->query($sql);
    $notifications = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $notifications[] = $row;
        }
    }
    return $notifications;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the delete request is sent
    if (isset($_POST['delete_id'])) {
        $delete_id = $conn->real_escape_string($_POST['delete_id']);
        // Delete notification from the database
        $sql = "DELETE FROM tbl_reports WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            echo "Notification deleted successfully";
        } else {
            echo "Error deleting notification: " . $conn->error;
        }
        exit; // Terminate script after handling POST request
    }
    // Escape user inputs for security
    $status = $conn->real_escape_string($_POST['status']);
    $notification_id = $conn->real_escape_string($_POST['notification_id']);

    // Update status in the database
    $sql = "UPDATE tbl_reports SET status=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $notification_id);
    if ($stmt->execute()) {
        echo "Status updated successfully";
    } else {
        echo "Error updating status: " . $conn->error;
    }
    exit; // Terminate script after handling POST request
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

    <title>Admin | Reports </title>

    <!-- Custom fonts for this template -->
    <link href="vendor2/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

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
                    <h1 class="h3 mb-2 text-gray-800">Reports </h1>
                    <p class="mb-4"><a>The admin receive a notifications if there's a problem or issues on the printing.</a></p>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Report details
                                    </h6>

                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Issue</th>
                                                    <th>Date and Time</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                // Fetch all notifications from the database
                                                $notifications = getAllNotifications($conn);
                                                foreach ($notifications as $notification) {
                                                    echo "<tr id='notification_" . $notification['id'] . "'>";
                                                    echo "<td>" . $notification['id'] . "</td>";
                                                    echo "<td>" . $notification['issue'] . "</td>";
                                                    echo "<td>" . $notification['datetime'] . "</td>";
                                                    echo "<td class='status'>" . $notification['status'] . "</td>";
                                                    echo "<td>";
                                                    echo "<div class='btn-group'>";
                                                    echo "<button type='button' class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Action</button>";
                                                    echo "<div class='dropdown-menu'>";
                                                    echo "<a class='dropdown-item text-primary update-btn' href='#' data-id='" . $notification['id'] . "' data-issue='" . $notification['issue'] . "' data-datetime='" . $notification['datetime'] . "' data-status='" . $notification['status'] . "' data-toggle='modal' data-target='#updateModal'><i class='fas fa-edit'></i> Update</a>"; // Update icon with primary color
                                                    echo "<a class='dropdown-item text-danger delete-btn' href='#' data-id='" . $notification['id'] . "'><i class='fas fa-trash'></i> Delete</a>"; // Delete icon with danger color
                                                    echo "</div>";
                                                    echo "</div>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }

                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

                <!-- Update Modal -->
                <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateModalLabel">Update Reports</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="updateForm">
                                    <div class="form-group">
                                        <label for="issue">Issue:</label>
                                        <input type="text" class="form-control" id="issue" name="issue" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="datetime">Date and Time:</label>
                                        <input type="text" class="form-control" id="datetime" name="datetime" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status:</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="Read">Read</option>
                                            <option value="Fixed">Fixed</option>
                                            <option value="Pending">Pending</option>
                                        </select>
                                    </div>
                                    <input type="hidden" id="notification_id" name="notification_id">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


               <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Confirmation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this permanently?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                        </div>
                    </div>
                </div>
            </div>


           <!-- Success Modal -->
            <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <i class="fas fa-check-circle text-success fa-5x mb-4"></i>
                            <p class="mb-0">Reports successfully updated.</p>
                        </div>
                    </div>
                </div>
            </div>


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
            $('.update-btn').click(function() {
                var id = $(this).data('id');
                var issue = $(this).data('issue');
                var datetime = $(this).data('datetime');
                var status = $(this).data('status');

                // Set the values of modal input fields
                $('#notification_id').val(id);
                $('#issue').val(issue);
                $('#datetime').val(datetime);
                $('#status').val(status);
            });

            // Handle form submission
            $('#updateForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: 'reports.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Handle success response
                        console.log(response);
                        $('#updateModal').modal('hide');
                        // Update the status in the table
                        var status = $('#status').val();
                        var id = $('#notification_id').val();
                        $('#notification_' + id + ' .status').text(status);
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
            });

            // Reset form fields when modal is hidden
            $('#updateModal').on('hidden.bs.modal', function() {
                $('#issue').val('');
                $('#datetime').val('');
                $('#status').val('');
            });
        });
    </script>


    <script>
    $(document).ready(function() {
        // Delete button click event
        $('.delete-btn').click(function() {
            var id = $(this).data('id');
            $('#confirmDelete').data('id', id); // Set data-id attribute for delete confirmation button
            $('#deleteModal').modal('show'); // Show delete confirmation modal
        });

        // Confirm delete button click event
        $('#confirmDelete').click(function() {
            var id = $(this).data('id');
            // AJAX request to delete notification
            $.ajax({
                url: 'reports.php', // Endpoint that handles deletion
                type: 'POST',
                data: { delete_id: id }, // Send the notification ID to delete
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    $('#deleteModal').modal('hide');
                    $('#notification_' + id).remove(); // Remove notification row from table
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                }
            });
        });
    });

    </script>

<script>
$(document).ready(function() {
    // Handle form submission
    $('#updateForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: 'reports.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                // Handle success response
                console.log(response);
                $('#updateModal').modal('hide');
                $('#successModal').modal('show'); // Show success modal

                // Automatically close the success modal after 3 seconds
                setTimeout(function() {
                    $('#successModal').modal('hide');
                }, 1000);

                // Update the status in the table if needed
                var status = $('#status').val();
                var id = $('#notification_id').val();
                $('#notification_' + id + ' .status').text(status);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            }
        });
    });

    // Reset form fields when modal is hidden
    $('#updateModal').on('hidden.bs.modal', function() {
        $('#updateForm')[0].reset(); // Reset form fields
    });
});
</script>


</body>

</html>
