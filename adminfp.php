<?php
include('connection.php');
if(isset($_POST['admin'])){
    $username=$_POST['username'];
    $newpassword=$_POST['newpassword'];
    $confirmpassword=$_POST['confirmpassword'];

    if($newpassword == $confirmpassword){
        $sql = "UPDATE admin SET password=? WHERE username=?" ;
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $newpassword, $username  );
        if($stmt->execute()){ 
            header("Location: adminlogin.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Forgot Password</title>
</head>
<body>
    <div class="box">
    <form action="adminfp.php" method="POST">
    <h2>Forgot Password</h2>
    <input type="text" placeholder="UserName" id="username" name="username" required>
    <input type="password" placeholder="New Password" id="newpassword" name="newpassword" required>
    <input type="password" placeholder="Confirm Password" id="confirmpassword" name="confirmpassword" required>
    <button name="admin">Submit</button>
    </form>
</body>
</html>