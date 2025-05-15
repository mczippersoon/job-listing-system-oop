<?php

include_once '../Database/Dbconnection.php';

$conn = (new DbConnection())->getConnection();

$stmt = $conn->query("SELECT * FROM jobs");
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ?");
    $stmt->execute([$id]);
    $job = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($job); 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['job_id']; 
    $stmt = $conn->prepare("UPDATE jobs SET title=?, description=?, company=?, location=? WHERE id=?");
    $stmt->execute([$_POST['title'], $_POST['description'], $_POST['company'], $_POST['location'], $id]);
    header('Location: jobs.php');
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

    <title>Job Listing System</title>

    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet" type="text/css">
    
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15">
                </div>
                <div class="sidebar-brand-text mx-3"><strong>Job Listing System</strong></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>
            <li class="nav-item active">
                <a class="nav-link collapsed" href="jobs.php">
                    <i class="fas fa-briefcase"></i>
                    <span>Manage Job</span>
                </a>
            </li>
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


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Manage Job</h1>
                </div>
            </div>
            <div class="card-body">
                <!-- Content Row -->
                <div class="jobs-list">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0">Jobs</h2>
                        <a href="add_job.php" class="btn btn-success">Add New Job</a>
                    </div>

                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Company</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($jobs as $job): ?>
                            <tr>
                                <td><?= htmlspecialchars($job['title']); ?></td>    
                                <td><?= htmlspecialchars($job['company']); ?></td>
                                <td><?= htmlspecialchars($job['location']); ?></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary editFormButton" data-id="<?= $job['id']; ?>">Edit</a>
                                    <a href="delete_job.php?id=<?= $job['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this job?')">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- End of Content Row -->
        </div>
    </div>
    <!-- End of Begin Content -->

    <!-- Edit Form -->
    


    <!-- <script>
           $(document).ready(function() {
                // When clicking on the edit button
                $(document).on('click', '.editExample', function() {
                    var id = $(this).data('id');
                    
                    // Send an AJAX request to get the example data
                    $.ajax({
                        url: '/examples/' + id + '/edit',  // Send request to the edit method
                        method: 'GET',
                        success: function(response) {
                            // On success, populate the form fields with the data
                            $('#inputFirstName').val(response.first_name);
                            $('#inputMiddleName').val(response.middle_name);
                            $('#inputLastName').val(response.last_name);
                            $('#inputContactNumber').val(response.contact_number);
                            $('#Course').val(response.course);
                            
                            // Set the form action to update the example
                            $('form').attr('action', '/examples/' + id); // Set the form action dynamically
                            $('form').attr('method', 'POST'); // Set the method to POST
                            
                            // Append the method field for PUT request
                            $('form').append('<input type="hidden" name="_method" value="PUT">');
                            
                            // Show the form
                            $('#editForm').fadeIn(); // Show the form with fade-in effect
                        },
                        error: function(xhr) {
                            console.log("Error: " + xhr.status + " " + xhr.statusText);
                        }
                    });
                });

                // When clicking on the cancel button
                $(document).on('click', '#cancelEdit', function() {
                    $('#editForm').fadeOut(); // Hide the form when cancel is clicked
                });
            });

    </script> -->
     <!-- <div class="card mt-4" id="editForm" style="display:none;">
        <div class="edit-job-form">
            <h2 class="text-center">Edit Job</h2>
            <form method="POST" action="">
                <input type="hidden" name="id" id="edit-id">
                <div class="mb-3">
                    <label class="form-label">Job Title</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($job['title']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($job['description']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Company</label>
                    <input type="text" name="company" class="form-control" value="<?= htmlspecialchars($job['company']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($job['location']); ?>" required>
                </div>

                <button type="submit" class="btn btn-success ">Update Job</button>
                <a href="javascript:void(0)" id="cancelEdit" class="btn btn-secondary">Cancel</a>
            </form>
        </div>                        
     </div> -->
    <!-- End of Edit Form -->
     
</div>

<!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Job Listing System</span>
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
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script> -->
    <script src="../js/jquery.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
    <script src="../js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <!-- <script src="vendor/jquery-easing/jquery.easing.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script> -->

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>

    <!-- Show Edit Form -->
    <!-- <script>
        document.querySelectorAll('.editFormButton').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                const jobId = this.getAttribute('data-id');

                fetch(`jobs.php?id=${jobId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate the form
                        document.querySelector('input[name="title"]').value = data.title;
                        document.querySelector('textarea[name="description"]').value = data.description;
                        document.querySelector('input[name="company"]').value = data.company;
                        document.querySelector('input[name="location"]').value = data.location;

                        // Set job ID to hidden input if needed
                        if (!document.querySelector('input[name="job_id"]')) {
                            const hidden = document.createElement('input');
                            hidden.type = 'hidden';
                            hidden.name = 'job_id';
                            hidden.value = data.id;
                            document.querySelector('form').appendChild(hidden);
                        } else {
                            document.querySelector('input[name="job_id"]').value = data.id;
                        }

                        // Show the form
                        document.getElementById('editForm').style.display = 'block';
                    });
            });
        });

        document.getElementById('cancelEdit').addEventListener('click', function() {
            document.getElementById('editForm').style.display = 'none';
        });
    </script> -->


</body>

</html>