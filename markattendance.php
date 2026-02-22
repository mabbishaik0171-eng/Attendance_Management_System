<?php
include("connection.php");
session_start();

// Check if faculty is logged in
$faculty_id = $_SESSION['faculty_id'] ?? null;
if (!($faculty_id)) {
    header("Location: login.php");
    exit();
}

//  Check if subject_id exists in the URL
if (!isset($_GET['subject_id'])) {
    header("Location: faculty_dashboard.php");
    exit();
}

$subject_id = intval($_GET['subject_id']); // prevent SQL injection

//  Fetch subject details
$subject_query = mysqli_query($conn, "SELECT * FROM subjects WHERE subject_id = $subject_id");
if (mysqli_num_rows($subject_query) == 0) {
    header("Location: faculty_dashboard.php");
    exit();
}
$subject = mysqli_fetch_assoc($subject_query);

//  Fetch faculty name
$faculty_query = mysqli_query($conn, "SELECT fname FROM faculty WHERE faculty_id = $faculty_id");
$faculty_data = mysqli_fetch_assoc($faculty_query);
$faculty_name = mysqli_real_escape_string($conn, $faculty_data['fname']);

// Get students of that subject's year and semester
$students = mysqli_query($conn, "SELECT * FROM student WHERE year = {$subject['year']} AND sem = {$subject['sem']}");

// Handle attendance submission
if (isset($_POST['save'])) {
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    foreach ($_POST['status'] as $student_id => $status) {
        $student_id = intval($student_id);
        $status = mysqli_real_escape_string($conn, $status);

        // Fetch student details
        $student_data = mysqli_query($conn, "SELECT * FROM student WHERE student_id = $student_id");
        if ($student_data && mysqli_num_rows($student_data) > 0) {
            $student = mysqli_fetch_assoc($student_data);
            $sname = mysqli_real_escape_string($conn, $student['name']);
            $roll = mysqli_real_escape_string($conn, $student['roll']);
            $year = mysqli_real_escape_string($conn, $student['year']);
            $branch = mysqli_real_escape_string($conn, $student['branch']);
            $section = mysqli_real_escape_string($conn, $student['section']);
        } else {
            continue; // skip if student not found
        }

        //  Get subject name
        $subject_name = mysqli_real_escape_string($conn, $subject['subject']);

        //  Check for duplicate record
        $check = mysqli_query($conn, "SELECT * FROM attendance_record 
                                      WHERE student_id = $student_id 
                                      AND subject_id = $subject_id 
                                      AND date = '$date'");
        if (mysqli_num_rows($check) == 0) {
            mysqli_query($conn, "INSERT INTO attendance_record 
                (student_id, subject_id, subject_name, faculty_id, faculty_name, date, status, sname, roll, year, branch, section)
                VALUES 
                ('$student_id', '$subject_id', '$subject_name', '$faculty_id', '$faculty_name', '$date', '$status', '$sname', '$roll', '$year', '$branch', '$section')");
            echo "<script>
            alert('Attendance saved successfully!');
            window.location.href = 'faculty_dashboard.php';
          </script>";
        }
        else{
            echo "<script>
            alert('Attendance exists!');
            window.location.href = 'faculty_dashboard.php';
          </script>";
        }
    }

    // Redirect after saving
   // echo "<script>
     //       alert('Attendance saved successfully!');
       //     window.location.href = 'faculty_dashboard.php';
         // </script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mark Attendance</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #85d6ffff;
            padding: 40px;
        }
        h2 {
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }
        .container h2{
            text-align: center;
            color: #4e1a7fff;
        }
        .container h3{
            text-align: center;
            color: #b220c2ff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 12px;
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

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            background: #fff;
            border-radius: 3;
        }
        table, th, td {
            border: 1px solid #aaa;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        button {
            background-color: #1abc9c;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            margin: 10px;
        }
        button:hover {
            background-color: #107a57ff;
        }
        input[type="date"] {
            padding: 6px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            background-color: #d3e9ffff;
        }
    </style>
</head>
<body>
    <div class="container">
    <h2>Mark Attendance — <?= htmlspecialchars($subject['subject']) ?></h2>
    <h3>Faculty: <?= htmlspecialchars($faculty_name) ?></h3>

    <form method="POST">
        <label for="date">Date : </label>
        <input type="date" name="date" required value="<?= date('Y-m-d') ?>">
    </div>
        <div class="container">
        <table>
            <tr>
                <th>Name</th>
                <th>Roll</th>
                <th>Status</th>
            </tr>
            <?php while ($s = mysqli_fetch_assoc($students)) { ?>
            <tr>
                <td><?= htmlspecialchars($s['name']) ?></td>
                <td><?= htmlspecialchars($s['roll']) ?></td>
                <td>
                    <select name="status[<?= $s['student_id'] ?>]">
                        <option value="present">Present</option>
                        <option value="absent">Absent</option>
                    </select>
                </td>
            </tr>
            <?php } ?>
        </table>
        <button type="submit" name="save">Save Attendance</button>
        </div>
        <br>
        
    </form>
</body>
</html>
