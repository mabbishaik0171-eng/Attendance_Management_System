<?php 
include('connection.php');
session_start();
if (isset($_POST['student_logout'])){
    session_unset();
    session_destroy();
    header("Location: studentlogin.php");
    echo"<h2>You have been logged out</h2>";
    echo "<p>Click below to return to login page</p>";
    echo "<button onclick='window.location.href='studentlogin.php''>Go to Login</button>";

    exit();
}
if (isset($_POST['faculty_logout'])){
    session_unset();
    session_destroy();
    header("Location: facultylogin.php");
    echo"<h2>You have been logged out</h2>";
    echo "<p>Click below to return to login page</p>";
    echo "<button onclick='window.location.href='facultylogin.php''>Go to Login</button>";
    exit();
}
if (isset($_POST['admin_logout'])){
    session_unset();
    session_destroy();
    header("Location: adminlogin.php");
    echo"<h2>You have been logged out</h2>";
    echo "<p>Click below to return to login page</p>";
    echo "<button onclick='window.location.href='adminlogin.php''>Go to Login</button>";
    exit();
}
?>