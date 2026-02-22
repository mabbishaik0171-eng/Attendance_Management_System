<?php
session_start();
include("connection.php");
$gender = $_SESSION['gender'];
$faculty_id = $_SESSION['faculty_id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <style>
body {
    margin: 0;
    font-family: "Segoe UI", Arial, sans-serif;
    background-color: #f4f6f9;
    color: #333;
}
        
        .sidebar {
            width: 220px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #2c3e50;
            color: white;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            box-shadow: rgba(0, 0, 0, 0.2) 2px 0 6px;
        }
        
        .sidebar h1 {
            font-size: 22px;
            margin-bottom: 40px;
            text-align: center;
            font-weight: bold;
            color: #ecf0f1;
        }
        
        .sidebar a {
            text-decoration: none;
            color: #ecf0f1;
            padding: 12px 20px;
            margin: 6px 0;
            display: block;
            border-radius: 6px;
            transition: 0.3s;
        }
        
        .sidebar a:hover {
            background: #1abc9c;
            color: #fff;
        }
        
        .header {
            position: fixed;
            top: 0;
            left: 220px;
            right: 0;
            height: 70px;
            background: #1abc9c;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }
        
        .header h1 {
            margin: 0;
            font-size: 22px;
            color: white;
            font-weight: bold;
        }
        
        .content {
            margin-left: 220px;
            padding: 100px 40px 40px;
        }
        
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
            margin-top: 40px;
        }
        
        .card {
            background: white;
            padding: 30px 20px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.2);
        }
        
        .card h2 {
            margin: 0 0 15px;
            font-size: 18px;
            color: #2c3e50;
        }
        
        .card a {
            text-decoration: none;
            background: #1abc9c;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
            display: inline-block;
        }
        
        .card a:hover {
            background: #16a085;
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
        <a href="facultyprofile.php?id=<?php echo $faculty_id;?>">Profile</a>
        <!--a href="Marks.html">Marks</a>
        <a href="Attendance.html">Attendance</a-->
        <form action="logout.php" method="POST">
            <button type="submit" name="faculty_logout" class="button">Logout</button>
        </form>
    </div>


    <div class="header">
        <h1>Faculty Dashboard</h1>
    </div>

    <div class="content">
        <h2>Welcome <h3><?php echo $_SESSION['name']; $title = (strcasecmp($_SESSION['gender'],'Male') == 0 )? " Sir, " : " Mam, "; echo $title?>  </h3></h2> 
        
        <div class="cards">
        <!--div class="card">
            <h2>Add Student</h2>
            <a href="addstudent.php">+</a>
        </div-->

        <div class="card">
            <h2>Upload Marks</h2>
            <!--a href="upload_marks.php">+</a-->
            <?php
            $subjects = mysqli_query($conn, 
                "SELECT * FROM subjects WHERE faculty_id = $faculty_id");

            if (mysqli_num_rows($subjects) > 0) {
                while ($sub = mysqli_fetch_assoc($subjects)) {
                    echo '<a href="upload_marks.php?subject_id=' . 
                         $sub['subject_id'] . '">'
                         . $sub['subject'] . '</a><br>';
                }
            } else {
                echo "<p>No subjects assigned.</p>";
            }
            ?>
        </div>

        <div class="card">
            <h2>Mark Attendance</h2>
            <div>
                <?php
                // Fetch subjects assigned to this faculty
                $query = mysqli_query($conn, "SELECT * FROM subjects WHERE faculty_id = $faculty_id");
                if (mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo '<p><a href="markattendance.php?subject_id=' . $row['subject_id'] . '">
                              +</a></p>';
                    }
                } else {
                    echo "<p>No subjects assigned.</p>";
                }
                ?>
            </div>
        </div>
    </div>

        </div>
    </div>
</body>
</html>