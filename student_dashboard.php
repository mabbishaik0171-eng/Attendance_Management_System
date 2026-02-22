<?php 
session_start();
include('connection.php');

if (!isset($_SESSION['student_id'])) {
    header("Location: studentlogin.html");
    exit();
}

$student_id = $_SESSION['student_id'];

$sql = " SELECT 
    COUNT(*) AS total_classes,
    SUM(CASE WHEN status='Present' THEN 1 ELSE 0 END) AS present_days
FROM attendance_record
WHERE student_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$total_classes = $data['total_classes'];
$present_days  = $data['present_days'];

$attendance_percentage = ($total_classes > 0) 
    ? round(($present_days / $total_classes) * 100, 2)
    : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        
        .sidebar {
            width: 200px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: mediumvioletred;
            color: white;
            padding: 0px;
            display: flex;
            flex-direction: column;
            box-shadow: rgba(0, 0, 0, 0.2) 2px 0 5px;
        }
        
        .sidebar h1 {
            font-size: 20px;
            margin-bottom: 40px;
            text-align: center;
        }
        
        .sidebar a {
            text-decoration: none;
            color: white;
            padding: 12px;
            margin: 5px 0;
            display: block;
            border-radius: 6px;
            transition: 0.3s;
        }
        
        .sidebar a:hover {
            background: #34495e;
        }
        
        .header {
            position: fixed;
            top: 0;
            left: 200px;
            right: 0;
            height: 80px;
            background: #66cdaa;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }
        
        .dashboard-container {
            display: flex;
            flex: 1;
        }
        
        .header h1 {
            margin: 0;
            font-size: 22px;
            color: white;
        }
        
        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: white;
            font-weight: bold;
        }
        
        .profile img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 2px solid white;
        }
        
        .content {
            margin-left: 200px;
            padding: 20px;
            padding-top: 100px;
        }
        
        .content h2 {
            color: #333;
        }
        .dashboard {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 20px;
            }
            
        .card {
                background: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                transition: 0.3s;
            }
            
        .card:hover {
                transform: translateY(-5px);
            }
            
        .card h3 {
                margin: 0 0 10px;
                color: mediumvioletred;
            }
            
            
        .card p {
                margin: 5px 0;
                color: #5f0ebb;
            }
        .button{
            background-color: #1abc9c;
            text-align: center;
            color: aliceblue;
            font-weight: bolder;
            margin: 10px ;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        .button:hover {
            background: #2bffc3ff;
        }
    </style>
</head>

<body>


    <div class="sidebar">
        <h1>Dashboard</h1>
        <a href="student_dashboard.php">Home</a>
        <a href="sattendance.php?id=<?php echo $_SESSION['student_id'];?>">Attendance</a>
        <!--a href="marks.html">Marks</a-->
        <a href="feedue.php?id=<?php echo $_SESSION['student_id'];?>">Fee Due</a>
        <form action="logout.php" method="POST">
            <button type="submit" name="student_logout" class="button">Logout</button>
        </form>
        
    </div>


    <div class="header">
        <h1>Student Dashboard</h1>
        <a href="studentprofile.php?id=<?php echo $_SESSION['student_id'];?>" class="profile">
            <img src="student.jpg" alt="Profile"> 
        </a>
    </div>


    <div class="content">
        <div class="dashboard">
            <div class="card"><h3>
                <h2>Roll:</h2>
                <h3><?php echo $_SESSION['roll'];?></h3>

            </div>
            <div class="card">
                <h2>Name:</h2>
                <h3><?php echo $_SESSION['name'];?></h3>
                
            </div>
            <!--div class="card">
                <h2>Attendance:</h2>
                <h3><?php //echo $attendance_percentage . "%"; ?></h3>
            </div-->
            <div class="card">
                <h2>Attendance:</h2>
                <h3 style="color: <?php echo ($attendance_percentage < 75) ? 'red' : 'green'; ?>">
                    <?php echo $attendance_percentage . "%"; ?>
                </h3>
        </div>
        </div>
    </div>

</body>

</html>