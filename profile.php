<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
$role = $user['role'] ?? 'guest';

$profilePath = $user['profile_picture'] ?? '';
$imageToShow = (empty($profilePath) || !file_exists($profilePath))
    ? "uploads/default.jpg"
    : $profilePath;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h4>Welcome, <?= htmlspecialchars($user['name']) ?>!</h4>
<h2>Edit Profile</h2>

<div id="alertArea"></div>

<form id="profileForm" enctype="multipart/form-data">
    <div class="form-group">
        <label>Current Profile Picture:</label><br>
        <img id="profileImage" src="<?= htmlspecialchars($imageToShow) ?>" alt="Profile" width="100" height="100" class="rounded-circle">
    </div>
    <div class="form-group">
        <label>Upload New Picture</label>
        <input type="file" name="profile_picture" class="form-control-file" required>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Update Profile</button>
</form>

<script>
document.getElementById("profileForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("update-profile.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        const alertArea = document.getElementById("alertArea");
        alertArea.innerHTML = `<div class="alert alert-${data.success ? 'success' : 'danger'}">${data.message}</div>`;

        if (data.success && data.profile_picture) {
            document.getElementById("profileImage").src = data.profile_picture + "?" + new Date().getTime();
            
        }
    })
    .catch(err => {
        console.error("AJAX Error:", err);
        document.getElementById("alertArea").innerHTML = `<div class="alert alert-danger">Something went wrong.</div>`;
    });
});
</script>

</body>
</html>
