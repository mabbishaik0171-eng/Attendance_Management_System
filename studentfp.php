<?php
include('connection.php');
if(isset($_POST['student'])){
    $username=$_POST['username'];
    $newpassword=$_POST['newpassword'];
    $confirmpassword=$_POST['confirmpassword'];

    if($newpassword == $confirmpassword){
        $sql = "UPDATE student SET password=? WHERE username=?" ;
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $newpassword, $username  );
        if($stmt->execute()){ 
            header("Location: studentlogin.php");
            exit();
        }
        else{
        echo " Error: ".$stmt->error;
        
        }
    }
    else {
        echo "❌Invalid Credientials";
    }
    $stmt->close();
    $conn->close();
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot password</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      width: 300px;
    }

    .box h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .box input {
      width: 100%;
      padding: 10px;
      margin: 10px 0px 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .box button {
      width: 100%;
      padding: 10px;
      background: rgb(160,69,158);
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }
    .box button:hover {
      background: rgba(182, 9, 179, 1);
    }
    
  </style>
</head>
<body>

  <div class="box">
    <form action="studentfp.php" method="POST">
    <h2>Forgot Password</h2>
    <input type="text" placeholder="UserName" id="username" name="username" required>
    <input type="password" placeholder="New Password" id="newpassword" name="newpassword" required>
    <input type="password" placeholder="Confirm Password" id="confirmpassword" name="confirmpassword" required>
    <button name="student">Submit</button>
    </form>
  </div>
</body>
</html>