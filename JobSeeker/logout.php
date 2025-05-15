<?php
// Start session (if not already started)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Destroy the session to log out the user
session_destroy();

// Redirect to login page (or home page, etc.)
header("Location: ../login.php");  // Change this to your login page or home page
exit();
?>
