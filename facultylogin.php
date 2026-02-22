<?php
session_start();
include("connection.php"); // Assumes $conn is your MySQLi connection
if (isset($_POST["facultylogin"])) 
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Get user by username
    $stmt = $conn->prepare("SELECT * FROM faculty WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc(); // Fetch associative array


        if (($password === $row['password'])) {
            $_SESSION['name'] = $row['fname'];
            $_SESSION['gender'] = $row['gender'];
            $_SESSION['faculty_id'] = $row['faculty_id'];
            header("Location: faculty_dashboard.php");
            echo "<script>alert('Logged In Sucessfully');window.location='faculty_dashboard.php';</script>";
            exit();
        } else {
            echo "<script>alert('Log In Fail');window.location='facultylogin.php';</script>"; 
        }
    } else {
        echo "<script>alert('Log In Fail');window.location='facultylogin.php';</script>"; 
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Faculty</title>
  <style>
body {
      font-family: Arial, sans-serif;
      background: #b8fff8;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      position: relative; 
      margin: 0; 
      overflow: hidden; 
}
    /*body::before {
      content: "";
      position: absolute;
      top: -150px;
      left: -150px;
      width: 400px;
      height: 400px;
      background: rgb(101, 237, 255);
      border-radius: 50%;
      z-index: 0;
    }
    body::after {
      content: "";
      position: absolute;
      bottom: -150px;
      right: -150px;
      width: 400px;
      height: 400px;
      background: rgb(101, 175, 255);
      border-radius: 50%;
      z-index: 0;
    }
      */
    .login-box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      width: 300px;
      position: relative;
      z-index: 1;
    }
    .login-box h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    .login-box input {
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
    }
    .login-box button {
      width: 100%;
      padding: 10px;
      background: #69ae4c;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }
    .login-box button:hover {
      background: #4cd876ff;
    }
  </style>
  
</head>
<body>

  <div class="login-box">
    <form action="facultylogin.php" method="POST" target="_self">
      <h2>Faculty</h2>
      <input type="text" placeholder="Username" name="username" id="username" required />
      <input type="password" placeholder="Password" name="password" id="password" required />

      <div class="forgot-password">
      <a href="facultyfp.php">Forgot Password?</a>
      </div>

      <button onclick="login()" name="facultylogin">Submit</button>
    </form>
  </div>


</body>
</html>