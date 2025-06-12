<?php
session_start();
include_once 'Database/Dbconnection.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => '', 'profile_picture' => ''];

if (!isset($_SESSION['user'])) {
    $response['message'] = "User not logged in.";
    echo json_encode($response);
    exit();
}

$db = new Dbconnection();
$conn = $db->getConnection();
$userId = $_SESSION['user']['id'];
$role = $_SESSION['user']['role'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $filename = basename($_FILES["profile_picture"]["name"]);
    $targetFile = $targetDir . time() . "_" . $filename;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($imageFileType, $allowed)) {
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
            $relativePath = "uploads/" . basename($targetFile);
            $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
            $stmt->execute([$relativePath, $userId]);

            $_SESSION['user']['profile_picture'] = $relativePath;

            $response['success'] = true;
            $response['message'] = "Profile updated!";
            $response['profile_picture'] = $relativePath;
            
        } else {
            $response['message'] = "Failed to move uploaded file.";
        }
    } else {
        $response['message'] = "Invalid file type.";
    }
} else {
    $response['message'] = "No file uploaded.";
}

echo json_encode($response);
