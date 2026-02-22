<?php
session_start();
include("connection.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.php");
    exit();
}

$section_filter = $_GET['section'] ?? '';
$subject_filter = $_GET['subject'] ?? '';

// Build Query
$sql = "SELECT * FROM marks_record WHERE 1=1";

if ($section_filter != '') {
    $section_filter_sql = mysqli_real_escape_string($conn, $section_filter);
    $sql .= " AND section = '$section_filter_sql'";
}

if ($subject_filter != '') {
    $subject_filter_sql = mysqli_real_escape_string($conn, $subject_filter);
    $sql .= " AND subject_name = '$subject_filter_sql'";
}

$sql .= " ORDER BY subject_name, section, student_name";

$result = mysqli_query($conn, $sql);

// For filter dropdowns
$sections = mysqli_query($conn, "SELECT DISTINCT section FROM marks_record ORDER BY section ASC");
$subjects = mysqli_query($conn, "SELECT DISTINCT subject_name FROM marks_record ORDER BY subject_name ASC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin - View Marks</title>
<style>
body { 
    font-family: Arial; 
    padding: 20px; 
    background:#f4f4f4; 
}
.container { 
    max-width: 1100px; 
    margin:auto; 
    background:white; 
    padding:20px; 
    border-radius:8px; 
}
table { 
    width:100%; 
    border-collapse:collapse; 
    margin-top:20px; 
}
th,td { 
    border:1px solid #aaa; 
    padding:8px; 
    text-align:center; 
}
th { 
    background:#007bff; 
    color:white; 
}
.low-marks {
    background-color:#ffcccc;   /* highlight low marks */
}
select, button { 
    padding:8px; 
    margin-right:8px; 
}
.export-btn {
    background:green;
    color:white;
    border:none;
}
</style>
</head>
<body>

<div class="container">
<h2>View Student Marks</h2>

<form method="GET">
    <label>Section:</label>
    <select name="section">
        <option value="">All</option>
        <?php while ($sec = mysqli_fetch_assoc($sections)) { ?>
            <option value="<?= $sec['section'] ?>" 
                <?= ($section_filter == $sec['section'] ? 'selected' : '') ?>>
                <?= $sec['section'] ?>
            </option>
        <?php } ?>
    </select>

    <label>Subject:</label>
    <select name="subject">
        <option value="">All</option>
        <?php while ($sub = mysqli_fetch_assoc($subjects)) { ?>
            <option value="<?= $sub['subject_name'] ?>" 
                <?= ($subject_filter == $sub['subject_name'] ? 'selected' : '') ?>>
                <?= $sub['subject_name'] ?>
            </option>
        <?php } ?>
    </select>

    <button type="submit">Filter</button>

    <a href="export_marks.php?section=<?= $section_filter ?>&subject=<?= $subject_filter ?>">
        <button type="button" class="export-btn">Export to Excel</button>
    </a>
</form>

<table>
<tr>
    <th>Student ID</th>
    <th>Name</th>
    <th>Subject</th>
    <th>Exam</th>
    <th>Total</th>
    <th>Obtained</th>
    <th>Percentage</th>
    <th>Grade</th>
    <th>Section</th>
    <th>Branch</th>
    <th>Year</th>
    <th>Date</th>
</tr>

<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $percentage = ($row['total_marks'] > 0) 
            ? round(($row['obtained_marks'] / $row['total_marks']) * 100, 2)
            : 0;

        $row_class = ($percentage < 50) ? "low-marks" : "";

        echo "<tr class='$row_class'>
                <td>{$row['student_id']}</td>
                <td>{$row['student_name']}</td>
                <td>{$row['subject_name']}</td>
                <td>{$row['exam_name']}</td>
                <td>{$row['total_marks']}</td>
                <td>{$row['obtained_marks']}</td>
                <td>{$percentage}%</td>
                <td>{$row['grade']}</td>
                <td>{$row['section']}</td>
                <td>{$row['branch']}</td>
                <td>{$row['year']}</td>
                <td>{$row['date']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='12'>No records found!</td></tr>";
}
?>

</table>
</div>
</body>
</html>
