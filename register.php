<?php
session_start();
require_once 'Database/Dbconnection.php';
require_once 'users.php';

$db = new Dbconnection();
$conn = $db->getConnection();
$user = new User($conn);

$successMessage = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $role     = $_POST['role'];
    

    // Set default profile picture path (make sure this file exists)
    $defaultProfile = "uploads/default.jpg";

    // Register user with default profile picture
    $result = $user->register($name, $email, $password, $role, $defaultProfile);

    if (isset($result)) {
        if ($result === true) {
            $successMessage = "Registration successful! Redirecting to login page...";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'login.php';
                    }, 1000); // 1-second delay
                  </script>";
        } else {
            $errorMessage = $result;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Job Listing System</title>
  <link rel="icon" type="image/png" href="uploads/logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #00c6ff, #0072ff);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .register-form {
      background: #ffffff;
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 500px;
    }

    .register-form h2 {
      font-weight: 600;
      color: #333;
      margin-bottom: 25px;
      text-align: center;
    }

    .form-label {
      font-weight: 500;
    }

    .form-control,
    .form-select {
      border-radius: 10px;
    }

    .btn-primary {
      border-radius: 10px;
      font-weight: 500;
      background-color: #0072ff;
      border: none;
    }

    .btn-primary:hover {
      background-color: #0056cc;
    }

    .text-muted a {
      color: #0072ff;
      text-decoration: none;
    }

    .text-muted a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="register-form">
  <h2>Create an Account</h2>

  <?php if (!empty($successMessage)): ?>
    <div class="alert alert-success"><?= $successMessage ?></div>
  <?php endif; ?>

  <?php if (!empty($errorMessage)): ?>
    <div class="alert alert-danger"><?= $errorMessage ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="mb-3">
      <label class="form-label">Full Name</label>
      <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email Address</label>
      <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" placeholder="Create a password" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Register As</label>
      <select name="role" class="form-select" required>
        <option value="seeker">Job Seeker</option>
        <option value="employer">Employer</option>
      </select>
    </div>

    <button type="submit" name="register" class="btn btn-primary w-100">Register</button> 

    <p class="text-center text-muted mt-3">
      Already have an account? <a href="login.php">Login here</a>
    </p>
  </form>
</div>

</body>
</html>
