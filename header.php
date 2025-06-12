<?php
session_start();

$userName = $_SESSION['user']['name'] ?? 'Admin';
$profilePicture = $_SESSION['user']['profile_picture'] ?? 'uploads/default.png';

// Prevent duplicate 'uploads/uploads'
if (strpos($profilePicture, 'uploads/') === 0) {
    $profilePath = $profilePicture;
} else {
    $profilePath = 'uploads/' . $profilePicture;
}

// Optional: If you're inside an /Admin folder, you may need to go up one level
if (strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false) {
    $profilePath = '../' . $profilePath;
}
?>
