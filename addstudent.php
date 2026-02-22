<?php 
include('connection.php');
if(isset($_POST['submit'])){
    $roll=$_POST['roll'];
    $name=$_POST['name'];
    $branch=$_POST['branch'];
    $section = $_POST['section'];
    $year=$_POST['year'];
    $sem=$_POST['sem'];
    $email=$_POST['email'];
    $phno=$_POST['phno'];
    $username=$_POST['username'];
    $password=$_POST['password'];
    


    $sql="INSERT INTO student (roll,name,branch,section,year,sem,email,phno,username,password) VALUES (?,?,?,?,?,?,?,?,?,?)";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("ssssiisiss",$roll,$name,$branch,$section,$year,$sem,$email,$phno,$username,$password);
    
    if($stmt->execute()){ 
        echo "<script>alert('Data saved Sucessfully');window.location='addstudent.php';</script>";
        header("Location: addstudent.php");
        exit();    
    }
    else{
       echo "<script>alert('Error: Data not Stored');window.location='addstudent.php';</script>"; 
    }
    $stmt->close();
    $conn->close();    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <style>
body {
            font-family: Arial, sans-serif;
            background: #f4f7f8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
}
        
        .form-container {
            background: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
            width: 400px;
        }
        
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #444;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            border-color: #007bff;
            outline: none;
        }
        
        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        
        .btn-submit:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Add Student</h2>
        <form action="addstudent.php" method="post">
            <div class="form-group">
                <label for="rollno">Roll No</label>
                <input type="text" id="rollno" name="roll" required>
            </div>

            <div class="form-group">
                <label for="name">Student Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="branch">Branch</label>
                <select id="branch" name="branch" required>
          <option value=""> Select Branch </option>
          <option>CAI</option>
          <option>CSE</option>
          <option>ECE</option>
          <option>EEE</option>
          <option>ME</option>
          <option>CE</option>
        </select>
            </div>

            <div class="form-group">
                <label for="year">Year</label>
                <select id="year" name="year" required>
          <option value="">Select Year </option>
          <option>1st Year</option>
          <option>2nd Year</option>
          <option>3rd Year</option>
          <option>4th Year</option>
        </select>
            </div>

            <div class="form-group">
                <label for="semester">Semester</label>
                <select id="semester" name="sem" required>
          <option value="">Select Semester </option>
          <option>1st Sem</option>
          <option>2nd Sem</option>
        </select>
            </div>
            <div class="form-group">
                <label for="username">Section</label>
                <input type="text" id="section" name="section" required>
            </div>

            <div class="form-group">
                <label for="email">Student Email</label>
                <input type="email" id="email" name="email">
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phno" required pattern="[0-9]{10}">
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn-submit" name="submit">Add Student</button>
        </form>
    </div>
</body>

</html>