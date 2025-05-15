<?php
include_once '../Database/Dbconnection.php';
$conn = (new Dbconnection())->getConnection();

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ?");
$stmt->execute([$id]);
$job = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("UPDATE jobs SET title=?, description=?, company=?, location=? WHERE id=?");
    $stmt->execute([$_POST['title'], $_POST['description'], $_POST['company'], $_POST['location'], $id]);
    header('Location: jobs.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background:rgba(10, 95, 223, 0.76);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .edit-job-form {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }
        .edit-job-form h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="edit-job-form">
    <h2 class="text-center">Edit Job</h2>
    <form method="POST" action="">
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

        <button type="submit" class="btn btn-primary w-100">Update Job</button>
    </form>
</div>

</body>
</html>

