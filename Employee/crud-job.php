<?php
include '../Database/Dbconnection.php'; // database connection

// Create Job
if (isset($_POST['action']) && $_POST['action'] == 'create') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    // ... other fields

    $sql = "INSERT INTO jobs (title, description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $description);
    $stmt->execute();
    header("Location: dashboard.php?msg=Job created");
    exit;
}

// Update Job
if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "UPDATE jobs SET title=?, description=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $description, $id);
    $stmt->execute();
    header("Location: dashboard.php?msg=Job updated");
    exit;
}

// Delete Job
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];

    $sql = "DELETE FROM jobs WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: dashboard.php?msg=Job deleted");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Create Form -->
<form action="job-crud.php" method="POST">
  <input type="text" name="title">
  <input type="text" name="description">
  <input type="hidden" name="action" value="create">
  <button type="submit">Create Job</button>
</form>

<!-- Update Form -->
<form action="job-crud.php" method="POST">
  <input type="hidden" name="id" value="1">
  <input type="text" name="title">
  <input type="text" name="description">
  <input type="hidden" name="action" value="update">
  <button type="submit">Update Job</button>
</form>

<!-- Delete Button -->
<a href="job-crud.php?action=delete&id=1" onclick="return confirm('Are you sure?')">Delete Job</a>

</body>
</html>

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