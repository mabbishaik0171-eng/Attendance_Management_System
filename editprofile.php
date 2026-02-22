<?php
include('connection.php') ;
// ✅ Check that the user is logged in
if (!isset($_SESSION['student_id'])) {
    echo "<script>
            alert('Access Denied!');
            window.location.href = 'student_dashboard.php';
          </script>";
    exit();
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "SELECT * FROM student where student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
    }
    else{
        echo "<script>
            alert('Student not Found!');
            window.location.href = 'student_dashboard.php';
          </script>";
        exit;
    }
    $stmt->close();
    $conn->close();
}
else{
    echo "<script>
            alert('No ID provideed!');
            window.location.href = 'student_dashboard.php';
          </script>";
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>