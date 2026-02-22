<?php
session_start();
include("connection.php"); // Assumes $conn is your MySQLi connection

if (isset($_POST["studentlogin"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Get user by username
    $stmt = $conn->prepare("SELECT * FROM student WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc(); // Fetch associative array

        if (($password === $row['password'])) {
            $_SESSION['student_id'] = $row['student_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['roll'] = $row['roll']; 
            $_SESSION['name'] = $row['name'];
            $_SESSION['attendance'] = $row['attendance'];
            echo "<script>alert('Logged In Sucessfully');window.location='student_dashboard.php';</script>";
            header("Location: student_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Log In Fail');window.location='studentlogin.php';</script>";                
        }
    } else {
        echo "<script>alert('Log In Fail');window.location='studentlogin.php';</script>"; 
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
    <title>Student Form</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-position: center;
            background-color: blanchedalmond;
            font-family: Arial, sans-serif;
        }
        
        .box {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        
        h1 {
            color: rgb(236, 13, 236);
            font-weight: 900;
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: rgba(61, 5, 182, 0.742);
        }
        
        input {
            width: 80%;
            padding: 10px;
            margin-bottom: 15px;
            border: 2px solid rgba(61, 5, 182, 0.4);
            border-radius: 8px;
        }
        
        button {
            background-color: aqua;
            color: rgba(203, 103, 82);
            font-weight: bolder;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        
        a {
            display: block;
            margin: 10px 0;
            text-decoration: none;
            color: blue;
        }
    </style>
</head>

<body>

    <div class="box">
        <form action="studentlogin.php" method="POST" target="_self">
            <h1>Student</h1>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <a href="studentfp.php">Forgot Password?</a>

            <button type="submit" name="studentlogin" >Submit</button>
        </form>
    </div>

</body>

</html>   