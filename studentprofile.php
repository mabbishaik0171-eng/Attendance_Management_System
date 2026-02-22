<?php
session_start();
include('connection.php');

// ✅ Check that the user is logged in
if (!isset($_SESSION['student_id'])) {
    echo "<script>
            alert('Access Denied!');
            window.location.href = 'student_dashboard.php';
          </script>";
    exit();
}

// ✅ Get student_id from URL (passed as ?id=...)
if (isset($_GET['id'])) {
    $student_id = intval($_GET['id']); // sanitize input

    $stmt = $conn->prepare("SELECT * FROM student WHERE student_id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("No profile found.");
    }

    $stmt->close();
} else {
    die("No ID provided");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Student Profile</title>
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
  </style>
</head>
<body>

  <div class="profile-container">
    <h2>Profile Details</h2>
    <div class="edit">
      
        <a href="editprofile.php?id=<?php echo $_SESSION['student_id'];?>"><button name="edit">Edit<image src=""></image></button></a>
      
    </div>
    <div class="profile">
        
      <table>
        <tr>
            <td><p>Student ID</p></td>
            <td><?php echo $row['student_id']; ?></td>
        </tr>
        <tr>
            <td><p>Name</p></td>
            <td><?php echo $row['name']; ?></td>
        </tr>
        <tr>
            <td><p>Username</p></td>
            <td><?php echo $row['username']; ?></td>
        </tr>
        <tr>
            <td><p>Roll</p></td>
            <td><?php echo $row['roll']; ?></td>
        </tr>
        <tr>
            <td><p>Branch</p></td>
            <td><?php echo $row['branch']; ?></td>
        </tr>
        <tr>
            <td><p>Section</p></td>
            <td><?php echo $row['section']; ?></td>
        </tr>
        <tr>
            <td><p>Year</p></td>
            <td><?php echo $row['year']; ?></td>
        </tr>
        <tr>
            <td><p>Sem</p></td>
            <td><?php echo $row['sem']; ?></td>
        </tr>
        <tr>
            <td><p>Email</p></td>
            <td><?php echo $row['email']; ?></td>
        </tr>
        <tr>
            <td><p>Phone Number</p></td>
            <td><?php echo $row['phno']; ?></td>
        </tr>
        <tr>
            <td><p>Address</p></td>
            <td><?php echo $row['address']; ?></td>
        </tr>
      </table>
      </p>
    </div>
  </div>

</body>
</html>