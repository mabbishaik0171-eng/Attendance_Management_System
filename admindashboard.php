<?php
session_start();
include("connection.php");
$admin_id = $_SESSION['admin_id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard</title>
  <style>
    /* Reset and base */
*{
  box-sizing: border-box;
}

    .admin {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      color: #333;
    }

    /* Sidebar */
    .sidebar {
      width: 220px;
      background: #2c3e50;
      color: white;
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      padding-top: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .sidebar h2 {
      font-size: 22px;
      margin-bottom: 30px;
      text-align: center;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
      width: 100%;
    }

    .sidebar ul li a {
      display: block;
      padding: 12px 20px;
      color: white;
      text-decoration: none;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      transition: background 0.3s ease;
    }

    .sidebar ul li a:hover {
      background: #1abc9c;
    }

    /* Main content */
    .main-content {
      margin-left: 220px;
      padding: 20px;
      min-height: 100vh;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #fff;
      padding: 15px 20px;
      border-radius: 6px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      margin-bottom: 20px;
      position: relative;
    }

    header h1 {
      font-size: 20px;
      color: #333;
      margin: 0;
    }

    /* Profile dropdown - pure CSS */
    .profile-dropdown {
      position: relative;
    }

    .profile-label {
      font-size: 24px;
      cursor: pointer;
      user-select: none;
      padding: 5px 10px;
    }

    .profile-checkbox {
      display: none;
    }

    .dropdown-menu {
      display: none;
      position: absolute;
      right: 0;
      top: 40px;
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      width: 160px;
      z-index: 10;
    }

    .dropdown-menu a {
      display: block;
      padding: 10px 15px;
      color: #333;
      text-decoration: none;
      border-bottom: 1px solid #eee;
    }

    .dropdown-menu a:hover {
      background: #f0f0f0;
    }

    .dropdown-menu a:last-child {
      border-bottom: none;
    }

    /* Show menu when checkbox is checked */
    .profile-checkbox:checked + .profile-label + .dropdown-menu {
      display: block;
    }

    /* Cards container */
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 20px;
    }

    .cards a.card {
      background: #2980b9;
      color: white;
      border-radius: 16px;
      padding: 2rem 1.5rem;
      box-shadow: 0 6px 12px rgba(16, 185, 129, 0.3);
      text-decoration: none;
      cursor: pointer;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      font-weight: 700;
      font-size: 18px;
      transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
      user-select: none;
      min-height: 120px;
      text-align: center;
    }

    .card.red {
      background: #e74c3c;
    }

    .card.green {
      background: #27ae60;
    }

    .card.orange {
      background: #f39c12;
    }

    .card.blue {
      background: #2980b9;
    }

    .cards a.card:hover,
    .cards a.card:focus {
      transform: translateY(-6px);
      box-shadow: 0 12px 24px rgba(16, 185, 129, 0.5);
      outline: none;
      background: #1abc9c;
      color: white;
    }

    .cards a.card .count {
      font-size: 40px;
      margin-top: 10px;
      line-height: 1;
      user-select: none;
    }

    .cards a.card * {
      text-decoration: none;
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
<body class="admin">
  <nav class="sidebar" aria-label="Primary Navigation">
    <h2>Attendance Management</h2>
    <ul>
      <!--li><a href="dashboard.html">Dashboard</a></li>
      <li><a href="students.html">Students</a></li>
      <li><a href="teachers.html">Teachers</a></li-->
      <li><a href="attendance_percentage.php?id=<?php echo $admin_id;?>">Attendance</a></li>
      <!--li><a href="classes.html">Classes</a></li>
      <li><a href="messages.html">Messages</a></li-->
      <form action="logout.php" method="POST">
            <button type="submit" name="admin_logout" class="button">Logout</button>
      </form>
    </ul>
  </nav>
  <main class="main-content" role="main">
    <header>
      <h1>Admin Dashboard</h1>

      <div class="profile-dropdown">
        <input type="checkbox" id="menu-toggle" class="profile-checkbox" />
        <label for="menu-toggle" class="profile-label" title="Menu">&#9776;</label>

        <div class="dropdown-menu">
          <a href="adminprofile.php?id=<?php echo $admin_id;?>">Profile</a>
          <!--a href="">Change Password</a-->
        </div>
      </div>
    </header>

    <section class="cards" aria-label="Dashboard Actions">
      <!--a href="add_class.html" class="card green" aria-label="Add Class">
        <div class="title">Add Class</div>
        <div class="count">+</div>
      </a>
      <a href="addfaculty.php" class="card orange" aria-label="Add Faculty">
        <div class="title">Add Faculty</div>
        <div class="count">+</div>
      </a-->
      <a href="admin_view.php?id=<?php echo $admin_id;?>" class="card blue" aria-label="View Attendance">
        <div class="title">View Attendance</div>
        <div class="count"></div>
      </a>
      <a href="admin_viewmarks.php?id=<?php echo $admin_id;?>" class="card blue" aria-label="View Marks">
        <div class="title">View Marks</div>
        <div class="count"></div>
      </a>
    </section>
  </main>

</body>
</html>