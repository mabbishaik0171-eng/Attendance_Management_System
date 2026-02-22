<?php
session_start();
include('connection.php');

$admin_id = $_GET['id'] ;

if($admin_id) {
  $sql = "SELECT * FROM admin WHERE admin_id='$admin_id'";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    $row = $result->fetch_assoc();
  }
  else
  {
    echo "<script>alert('No Profile Found');window.location='admindashboard.php';</script>"; 
    die("No profile");
  }
}
else{
    echo "<script>alert('No ID provided');window.location='admindashboard.php';</script>"; 
  die("No ID provided");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Profile</title>
  <style>
body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      color: #333;
      padding: 2rem;
}

    .profile-container {
      max-width: 500px;
      margin: 0 auto;
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      padding: 2rem;
    }

    h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #2980b9;
    }

    .profile p {
      margin: 0.6rem 0;
      font-size: 1rem;
      color: #2980b9;
    }
    .button{
      background-color: #26bebbff;
      text-align: center;
      color: aliceblue;
      font-weight: bolder;
      margin: 10px ;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <div class="profile-container">
    <h2>Profile Details</h2>
    <div class="edit">
      <!--a href="#"><button name="edit" class="button">Edit</button></a-->
    </div>
    <div class="profile">
        
      <table>
        <tr>
            <td><p>Admin ID</p></td>
            <td><?php echo $row['admin_id']; ?></td>
        </tr>
        <tr>
            <td><p>Name</p></td>
            <td><?php echo $row['aname']; ?></td>
        </tr>
        <tr>
            <td><p>Gender</p></td>
            <td><?php echo $row['gender']; ?></td>
        </tr>
        <tr>
            <td><p>Email</p></td>
            <td><?php echo $row['mail']; ?></td>
        </tr>
        <tr>
            <td><p>Phone Number</p></td>
            <td><?php echo $row['apno']; ?></td>
        </tr>
      </table>
      </p>
    </div>
  </div>

</body>
</html>