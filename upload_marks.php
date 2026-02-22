<?php
include("connection.php");
session_start();

/* -------------------- SESSION CHECK -------------------- */

$faculty_id = $_SESSION['faculty_id'] ?? null;
if (!$faculty_id) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['subject_id'])) {
    header("Location: faculty_dashboard.php");
    exit();
}

$subject_id = intval($_GET['subject_id']);

/* -------------------- FETCH SUBJECT -------------------- */

$subject_query = mysqli_query($conn, 
    "SELECT * FROM subjects WHERE subject_id = $subject_id");

if (mysqli_num_rows($subject_query) == 0) {
    header("Location: faculty_dashboard.php");
    exit();
}

$subject = mysqli_fetch_assoc($subject_query);

/* -------------------- FETCH FACULTY -------------------- */

$faculty_query = mysqli_query($conn, 
    "SELECT fname FROM faculty WHERE faculty_id = $faculty_id");

$faculty_data = mysqli_fetch_assoc($faculty_query);
$faculty_name = mysqli_real_escape_string($conn, $faculty_data['fname']);

/* -------------------- FETCH STUDENTS -------------------- */

$students = mysqli_query($conn, 
    "SELECT * FROM student 
     WHERE year = {$subject['year']} 
     AND sem = {$subject['sem']}");

/* -------------------- SAVE MARKS -------------------- */

if (isset($_POST['save'])) {

    $exam_name   = mysqli_real_escape_string($conn, $_POST['exam_name']);
    $total_marks = intval($_POST['total_marks']);
    $date        = mysqli_real_escape_string($conn, $_POST['date']);

    foreach ($_POST['marks'] as $student_id => $obtained_marks) {

        $student_id     = intval($student_id);
        $obtained_marks = intval($obtained_marks);

        if ($obtained_marks > $total_marks) {
            continue; // Skip invalid entry
        }

        $student_query = mysqli_query($conn, 
            "SELECT * FROM student WHERE student_id = $student_id");

        if (mysqli_num_rows($student_query) == 0) continue;

        $student = mysqli_fetch_assoc($student_query);

        $student_name = mysqli_real_escape_string($conn, $student['name']);
        $year    = $student['year'];
        $branch  = $student['branch'];
        $section = $student['section'];
        $subject_name = mysqli_real_escape_string($conn, $subject['subject']);

        /* ---------- CALCULATE PERCENTAGE ---------- */

        $percentage = ($total_marks > 0) 
            ? round(($obtained_marks / $total_marks) * 100, 2)
            : 0;

        /* ---------- GRADE CALCULATION ---------- */

        if ($percentage >= 90)      $grade = "A+";
        elseif ($percentage >= 80)  $grade = "A";
        elseif ($percentage >= 70)  $grade = "B";
        elseif ($percentage >= 60)  $grade = "C";
        elseif ($percentage >= 50)  $grade = "D";
        else                        $grade = "F";

        /* ---------- CHECK DUPLICATE ---------- */

        $check = mysqli_query($conn,
            "SELECT * FROM marks_record
             WHERE student_id = $student_id
             AND subject_id = $subject_id
             AND exam_name = '$exam_name'");

        if (mysqli_num_rows($check) == 0) {

            mysqli_query($conn,
                "INSERT INTO marks_record
                (student_id, student_name, subject_id, subject_name,
                 faculty_id, faculty_name,
                 exam_name, total_marks, obtained_marks,
                 percentage, grade,
                 year, branch, section, date)
                 VALUES
                ('$student_id', '$student_name', '$subject_id', '$subject_name',
                 '$faculty_id', '$faculty_name',
                 '$exam_name', '$total_marks', '$obtained_marks',
                 '$percentage', '$grade',
                 '$year', '$branch', '$section', '$date')");
        }
    }

    echo "<script>
            alert('Marks Uploaded Successfully!');
            window.location.href='faculty_dashboard.php';
          </script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Upload Marks</title>
        <style>
            body {
                font-family: Arial;
                background: #16a085;              
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
                border-collapse: collapse;
                width: 80%;
            }
            th, td {
                padding: 8px;
                text-align: center;
            }
            th {
                background: #16a085;
                color: white;
            }
            input {
                padding: 5px;
                border-radius: 5px;
                border: 1px solid #ccc;
            }
            button {
                margin: 8px 15px;
                padding: 8px 15px;
                background: #16a085;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            button:hover {
                background: #13856e;
            }
        </style>
    </head>
    <body>
        <div  class="container">
            <h2>Upload Marks - <?= $subject['subject'] ?></h2>
        <form method="POST">
        <h5>Exam Name:</h5>
            <input type="text" name="exam_name" required>

        <h5>Total Marks:</h5>
            <input type="number" name="total_marks" required>

        <h5>Date:</h5>
            <input type="date" name="date" value="<?= date('Y-m-d') ?>" required>
        <a href="export_marks.php?subject_id=<?= $subject_id ?>">
            <button type="button">Export to Excel</button>
        </a>
        </div>
        <div  class="container">
            <table border="1">
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Obtained Marks</th>
                </tr>

                <?php while ($s = mysqli_fetch_assoc($students)) { ?>
                <tr>
                    <td><?= $s['student_id'] ?></td>
                    <td><?= $s['name'] ?></td>
                    <td>
                        <input type="number" name="marks[<?= $s['student_id'] ?>]" min="0" required>
                    </td>
                </tr>
                <?php } ?>

            </table>

            <br>
        <button type="submit" name="save">Save Marks</button>
        </div>
        </form>
        

</body>
</html>
