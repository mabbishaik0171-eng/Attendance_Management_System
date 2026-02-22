<?php
include("connection.php");

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM marks_record WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $total = intval($_POST['total_marks']);
    $obtained = intval($_POST['obtained_marks']);

    $percentage = ($total > 0) ? round(($obtained/$total)*100,2) : 0;

    if ($percentage >= 90) $grade="A+";
    elseif ($percentage >= 80) $grade="A";
    elseif ($percentage >= 70) $grade="B";
    elseif ($percentage >= 60) $grade="C";
    elseif ($percentage >= 50) $grade="D";
    else $grade="F";

    mysqli_query($conn, "UPDATE marks_record SET
        total_marks='$total',
        obtained_marks='$obtained',
        percentage='$percentage',
        grade='$grade'
        WHERE id=$id");

    header("Location: admin_viewmarks.php");
}
?>

<form method="POST">
Total Marks:
<input type="number" name="total_marks" value="<?= $row['total_marks'] ?>"><br><br>
Obtained Marks:
<input type="number" name="obtained_marks" value="<?= $row['obtained_marks'] ?>"><br><br>
<button name="update">Update</button>
</form>
