<?php
session_start();
include("connection.php");

// Ensure the user is logged in and has an ID
if (!isset($_SESSION['admin_id'])) {
    echo "<script>
            alert('Access Denied!');
            window.location.href = 'admin_dashboard.php';
          </script>";
    exit();
}

// Prepare SQL query properly
$stmt = $conn->prepare("SELECT * FROM attendance_record");
//$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Sheet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #222;
            margin-top: 40px;
        }

        .container {
            max-width: 1000px;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: center;
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #00bfa5;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .no-results {
            text-align: center;
            color: #777;
            font-style: italic;
            padding: 15px;
            display: none;
        }

        button {
            display: inline-block;
            background-color: #00bfa5;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #009e8f;
        }
    </style>
</head>

<body>
    <h1>Attendance Sheet</h1>

    <div class="container">   
    <table border="1" align="center">
        <h3 align="center">Details</h3>
        <thead>
            <tr>
                <th>Subject ID</th>
                <th>Subject Name</th>
                <th>Faculty ID</th>               
                <th>Faculty Name</th>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Roll</th> 
                
                <th>Year</th>
                <th>Branch</th>               
                <th>Section</th>      
                <th>Date</th>        
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['subject_id']}</td>
                            <td>{$row['subject_name']}</td>
                            <td>{$row['faculty_id']}</td>
                            <td>{$row['faculty_name']}</td>
                            <td>{$row['student_id']}</td>
                            <td>{$row['sname']}</td>
                            <td>{$row['roll']}</td>
                            <td>{$row['year']}</td>
                            <td>{$row['branch']}</td>
                            <td>{$row['section']}</td>
                            <td>{$row['date']}</td>
                            <td>{$row['status']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No Data</td></tr>";
            }

            $stmt->close();
            $conn->close();
            ?>
        </tbody>
    </table>
    </div>
</body>

</html>