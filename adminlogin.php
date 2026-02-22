<?php
session_start();
include("connection.php"); // Assumes $conn is your MySQLi connection
if (isset($_POST["adminlogin"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Get user by username
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc(); // Fetch associative array
        if (($password === $row['password'])) {
            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['aname'] = $row['aname'];
            header("Location: admindashboard.php");
            exit();
        } else {
            echo "<script>alert('Log In Fail');window.location='adminlogin.php';</script>";     

        }
    } else {
        echo "<script>alert('Log In Fail');window.location='adminlogin.php';</script>"; 
    }
    $stmt->close();
    $conn->close();   
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

* {
  box-sizing: border-box;
}

body {
  margin: 0;
  height: 100vh;
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #249a86ff, #3d2db4ff);
  display: flex;
  justify-content: center;
  align-items: center;
  color: #2c3e50;
  overflow: hidden;
}

.login-container {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      width: 300px;
      position: relative;
      z-index: 1;
    }
    .login-container h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    .login-container input {
      width: 100%;
      padding: 10px;
      margin: 10px 0 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .forgot-password {
      text-align: right;
      font-size: 14px;
      margin-bottom: 15px;
    }
    .forgot-password a {
      color: #007BFF;
      text-decoration: none;
      cursor: pointer;
    }
    .forgot-password a:hover {
      text-decoration: underline;
      color: #1100ffff;
    }
    .login-container button {
      width: 100%;
      padding: 10px;
      background: #69ae4c;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }
    .login-container button:hover {
      background: #4cd876ff;
    }
    </style>
</head>
<body>
    <main class="login-container" role="main" aria-label="Admin login form">
    <h2>Admin Login</h2>
    <form action="adminlogin.php" method="POST">
      <input type="text" id="username" name="username" placeholder="Username" required>
      <input type="password" id="password" name="password" placeholder="Password" required>

      <div class="forgot-password">
        <a href="adminfp.php">Forgot Password?</a>
      </div>

      <button type="submit" name="adminlogin" class="btn">Submit</button>
    </form>
  </main>

</body>
</html>