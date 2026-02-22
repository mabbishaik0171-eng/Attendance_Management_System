<?php
include("connection.php");

$section_filter = $_GET['section'] ?? '';
$subject_filter = $_GET['subject'] ?? '';

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

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=marks_report.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Column headers
echo "Student ID\tName\tSubject\tExam\tTotal\tObtained\tPercentage\tGrade\tSection\tBranch\tYear\tDate\n";

while ($row = mysqli_fetch_assoc($result)) {

    $percentage = ($row['total_marks'] > 0) 
        ? round(($row['obtained_marks'] / $row['total_marks']) * 100, 2)
        : 0;

    // IMPORTANT: Everything in ONE LINE
    echo $row['student_id'] . "\t" .
         $row['student_name'] . "\t" .
         $row['subject_name'] . "\t" .
         $row['exam_name'] . "\t" .
         $row['total_marks'] . "\t" .
         $row['obtained_marks'] . "\t" .
         $percentage . "%\t" .
         $row['grade'] . "\t" .
         $row['section'] . "\t" .
         $row['branch'] . "\t" .
         $row['year'] . "\t" .
         $row['date'] . "\n";
}

exit();
?>
