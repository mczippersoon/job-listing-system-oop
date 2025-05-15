<?php
session_start();
?>

<header style="padding: 10px; background-color: #f0f0f0;">
  <?php if (isset($_SESSION['profile_image'])): ?>
    <img src="<?= $_SESSION['profile_image'] ?>" alt="Profile" style="width: 40px; height: 40px; border-radius: 50%;">
  <?php else: ?>
    <img src="upload/default.png" alt="Default Profile" style="width: 40px; height: 40px; border-radius: 50%;">
  <?php endif; ?>
</header>
