<?php
session_start();
include("connection.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.php");
    exit();
}

/*
   We calculate:
   total_classes = COUNT(*)
   present_days  = SUM(status='Present')
*/

$sql = "
SELECT 
    student_id,
    sname,
    roll,
    section,
    COUNT(*) AS total_classes,
    SUM(CASE WHEN status='Present' THEN 1 ELSE 0 END) AS present_days
FROM attendance_record
GROUP BY student_id, sname, roll, section
ORDER BY section, sname
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Attendance Percentage</title>
<style>
body {
    font-family: Arial;
    background:#f4f6f9;
    padding:20px;
}

.container {
    max-width: 900px;
    margin:auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 3px 8px rgba(0,0,0,0.1);
}

table {
    width:100%;
    border-collapse:collapse;
}

th, td {
    padding:10px;
    border:1px solid #ccc;
    text-align:center;
}

th {
    background:#00bfa5;
    color:white;
}

.low-attendance {
    background-color:#ffcccc;   /* below 75% */
}

h2 {
    text-align:center;
}
</style>
</head>
<body>

<div class="container">
<h2>Student Attendance Percentage</h2>

<table>
<tr>
    <th>Student ID</th>
    <th>Name</th>
    <th>Roll</th>
    <th>Section</th>
    <th>Total Classes</th>
    <th>Present Days</th>
    <th>Attendance %</th>
</tr>

<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $percentage = ($row['total_classes'] > 0)
            ? round(($row['present_days'] / $row['total_classes']) * 100, 2)
            : 0;

        // Highlight if attendance < 75%
        $row_class = ($percentage < 75) ? "low-attendance" : "";

        echo "<tr class='$row_class'>
                <td>{$row['student_id']}</td>
                <td>{$row['sname']}</td>
                <td>{$row['roll']}</td>
                <td>{$row['section']}</td>
                <td>{$row['total_classes']}</td>
                <td>{$row['present_days']}</td>
                <td>{$percentage}%</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='7'>No attendance records found</td></tr>";
}
?>

</table>
</div>

</body>
</html>
