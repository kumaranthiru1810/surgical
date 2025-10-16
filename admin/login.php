<?php 
session_start();

include('../db.php');

$query = $pdo->prepare("SELECT * FROM admin_credentials");
$query->execute();

$stmt = $query->fetch(PDO::FETCH_ASSOC); 

$email = $stmt['email'];
$password = $stmt['password'];

if (isset($_SESSION['email'])) {
    header("Location: admin.php");
    exit;
}


// Handle login form submit
if (isset($_POST['submit'])) {
    $mail = $_POST['email'];
    $pass = $_POST['password'];

    if ($mail === $email && $pass === $password) {
        $_SESSION['email'] = $mail;
        echo "<script>
                alert('Login Successfully!');
                window.location.href='admin.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Incorrect Email or Password!');
                window.location.href='login.php';
              </script>";
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, #74ebd5, #9face6);
    }

    .login-wrapper {
      display: flex;
      width: 900px;
      height: 550px;
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
      overflow: hidden;
    }

    .login-left {
      flex: 1;
      background: #f0f0f0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-left img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .login-right {
      flex: 1;
      padding: 50px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: linear-gradient(145deg, #ffffff, #f7f7f7);
    }

    .login-right h2 {
      font-size: 28px;
      margin-bottom: 30px;
      color: #333;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #555;
      font-weight: 600;
    }

    .form-group input {
      width: 100%;
      padding: 12px 15px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 15px;
    }

    .login-btn {
      margin-top: 20px;
      padding: 14px;
      background: #6c63ff;
      border: none;
      color: white;
      font-size: 16px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .login-btn:hover {
      background: #574fd6;
    }

    @media (max-width: 768px) {
      .login-wrapper {
        flex-direction: column;
        height: auto;
        width: 90%;
      }

      .login-left,
      .login-right {
        width: 100%;
        height: 300px;
      }

      .login-right {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>

  <div class="login-wrapper">
    <!-- Left Side Image -->
    <div class="login-left">
      <!-- Empty img tag for your custom image -->
      <img src="../assets/logo.jpeg" alt="Admin Illustration" id="admin-image" style="height: 130px; width: 330px; border-radius: 10px;" />
    </div>

    <!-- Right Side Form -->
    <div class="login-right">
      <h2>Welcome back, Admin!</h2>
      <form method="POST">
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" placeholder="Enter Email" name="email" required />
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" placeholder="Enter password" name="password" required />
        </div>

        <button type="submit" class="login-btn" name="submit">Login</button>
      </form>
    </div>
  </div>

</body>
</html>
