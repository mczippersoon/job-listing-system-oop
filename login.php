<?php
include_once "Controller/Userhandler.php";
session_start();

$handler = new Userhandler();

$errorMessage = '';  // Initialize the error message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email and password are not empty
    if (empty($email) || empty($password)) {
        $errorMessage = "All fields are required!";
    } else {
        // Search for user by email
        $result = $handler->searchByEmail($email); // fixed

        $user = $result; // result is already an array (or false)
        
        if (!empty($user)) {
            // ✅ If user exists, verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user; 
                
               //echo "Login successful!";
        
               switch ($user['role']) {
                case 'admin':
                    header("Location: Admin/dashboard.php");
                    break;
                case 'employer':
                    header("Location: Employee/dashboard.php");
                    break;
                case 'seeker':
                    header("Location: JobSeeker/dashboard.php");
                    break;
                default:
                    header("Location: login.php");
            }
                exit();
            } else {
                $errorMessage = "Incorrect password!";
            }
        } else {
            $errorMessage = "User not found!";
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

    .login-form {
      background: #ffffff;
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 420px;
    }

    .login-form h2 {
      font-weight: 600;
      color: #333;
      margin-bottom: 25px;
      text-align: center;
    }

    .form-label {
      font-weight: 500;
    }

    .form-control {
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

    .error-message {
      color: red;
      font-size: 0.9rem;
      margin-top: -10px;
      margin-bottom: 10px;
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

  <div class="login-form">
    <h2>Job Listing System</h2>
    <form method="POST" action="">
      <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
      </div>

      <?php if (!empty($errorMessage)): ?>
        <div class="error-message"><?php echo $errorMessage; ?></div>
      <?php endif; ?>

      <button type="submit" class="btn btn-primary w-100">Login</button>

      <p class="text-center text-muted mt-3">
        Don’t have an account? <a href="register.php">Register Here</a>
      </p>
    </form>
  </div>

</body>
</html>

