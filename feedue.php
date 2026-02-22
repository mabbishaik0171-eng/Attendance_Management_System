<?php
session_start();
include('connection.php');

// Ensure student is logged in
if(!isset($_SESSION['student_id'])){
    header("Location: studentlogin.php");
    exit();
}

$roll = $_SESSION['roll'];
$name = $_SESSION['name'];

// Fetch fee details from database (if available)

$query = "SELECT fee_due FROM student WHERE name = '$name'";
$result = mysqli_query($conn, $query);
if($result && mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $due = $row['fee_due'];
} else {
    $due = "No pending dues";
}

// Temporary data for now:
//$due = "₹3,000";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fee Due</title>
<style>
body {
  font-family: Arial, sans-serif;
  background: #f4f6f9;
  margin: 0;
  padding: 0;
}
.container {
  max-width: 700px;
  margin: 50px auto;
  background: #fff;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
h2 {
  text-align: center;
  color: #333;
}
p {
  text-align: center;
  font-size: 18px;
  color: #555;
}
.back-btn {
  display: block;
  width: 120px;
  margin: 20px auto;
  background-color: #007bff;
  color: white;
  text-align: center;
  padding: 10px;
  border-radius: 6px;
  text-decoration: none;
}
.back-btn:hover {
  background-color: #0056b3;
}

</style>
</head>
<body>
<div class="container">
  <h2>Fee Due Details</h2>
  <table style="text-align:center">
  <tr><td><p><strong>Roll No:</strong></p></td><td><p><?php echo htmlspecialchars($roll); ?></p></td></tr>
  <tr><td><p><strong>Name:</strong></p></td><td><p> <?php echo htmlspecialchars($name); ?></p></td></tr>
  <tr><td><p><strong>Pending Fee:</strong></p></td><td><p>&#8377; <?php echo htmlspecialchars($due); ?>.00</p></td></tr>
  <tr ><td colspan="2"><a href="student_dashboard.php" class="back-btn">Back</a></td></tr>
  </table>
</div>
</body>
</html>
