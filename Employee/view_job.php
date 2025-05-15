<?php
// Include your database connection
include_once '../Database/Dbconnection.php';
$conn = (new Dbconnection())->getConnection();

// Fetch all jobs from the database
$stmt = $conn->prepare("SELECT * FROM jobs");
$stmt->execute();
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Job Listings</h2>
    <a href="add_job.php" class="btn btn-success mb-3">Add New Job</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Company</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jobs as $job): ?>
                <tr>
                    <td><?= htmlspecialchars($job['title']); ?></td>
                    <td><?= htmlspecialchars($job['company']); ?></td>
                    <td><?= htmlspecialchars($job['location']); ?></td>
                    <td>
                        <!-- View Job Modal Trigger -->
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewJobModal<?= $job['id']; ?>">
                            View
                        </button>
                        <a href="edit_job.php?id=<?= $job['id']; ?>" class="btn btn-primary">Edit</a>
                        <a href="delete_job.php?id=<?= $job['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- View Job Modal (Dynamic for each job) -->
<?php foreach ($jobs as $job): ?>
    <div class="modal fade" id="viewJobModal<?= $job['id']; ?>" tabindex="-1" aria-labelledby="viewJobModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewJobModalLabel">Job Details: <?= htmlspecialchars($job['title']); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Title:</strong> <?= htmlspecialchars($job['title']); ?></p>
                    <p><strong>Description:</strong> <?= htmlspecialchars($job['description']); ?></p>
                    <p><strong>Company:</strong> <?= htmlspecialchars($job['company']); ?></p>
                    <p><strong>Location:</strong> <?= htmlspecialchars($job['location']); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net
