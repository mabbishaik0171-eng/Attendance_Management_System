<?php
include('connection.php');
if(isset($_POST['submit'])){
  $username=$_POST['username'];
  $fname=$_POST['fname'];
  $gender=$_POST['gender'];
  $fmail=$_POST['fmail'];
  $fpno=$_POST['fpno'];
  $password=$_POST['password'];
    $sql="INSERT INTO faculty (faculty_id,username,fname,gender,fmail,fpno,password) VALUES (?,?,?,?,?,?,?)";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("issssis",$faculty_id,$username,$fname,$gender,$fmail,$fpno,$password);
    
    if($stmt->execute()){ 
        echo "<script>
            alert('Data Added SuccessFully!');
            window.location.href = 'admindashboard.php';
          </script>";
        header("Location: admindashboard.php");
        exit();    
    }
    else{
      echo "<script>
            alert('Error Occured!');
            window.location.href = 'admindashboard.php';
          </script>";
        echo " Error: ".$stmt->error;
    }
    $stmt->close();
    $conn->close();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Add Faculty</title>
  <style>
  body {
  font-family: Arial, sans-serif;
  margin: 0;
  background-color: #f5f5f5;
  padding: 20px;
}
    .form-container {
      max-width: 600px;
      margin: 40px auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    h2 {
      margin-bottom: 20px;
      text-align: center;
      color: #333;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
      color: #333;
    }
    input,
    select,
    textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 16px;
    }
    button {
      margin-top: 25px;
      padding: 12px 20px;
      font-size: 16px;
      background-color: #e67e22;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      width: 100%;
    }
    button:hover {
      background-color: #cf711d;
    }
  
  </style>
</head>
<body>
  <div class="form-container">
    <form method="POST" action="addfaculty.php">
    <h2>Add Faculty </h2>
      <label for="username">UserName</label>
      <input type="text" id="name" name="username" required />
      <label for="name">Name</label>
      <input type="text" id="name" name="fname" required />
      <label for="gender">Gender</label>
      <input type="text" id="gender" name="gender" required />
      <label for="email">Email</label>
      <input type="email" id="email" name="fmail" required />
      <label for="contact">Contact Number</label>
      <input type="tel" id="contact" name="fpno" pattern="[0-9]{10}" required placeholder="10-digit number" />
      <label for="password">Password</label>
      <input type="password"  name="password" placeholder="" required></textarea>
      <button type="submit" name="submit">Submit</button>
    </form>
  </div>
</body>
</html>