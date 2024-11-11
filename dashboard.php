<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 50%;
            text-align: center;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .box-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .box {
            background-color: #f9f9f9;
            padding: 20px;
            width: 45%;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .box h3 {
            margin-top: 0;
            font-size: 18px;
        }
        .box p {
            color: #555;
        }
        .box a {
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            display: inline-block;
        }
        .box a:hover {
            background-color: #0056b3;
        }
        .logout {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff4d4d;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .logout:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to the System: <?php echo $_SESSION['email']; ?></h1>

        <div class="box-container">
            <div class="box">
                <h3>Add a Subject</h3>
                <p>This section allows you to add a new subject in the system. Click the button below to proceed with the adding process.</p>
                <a href="subject/add.php">Add Subject</a> <!-- Link updated to go to subject/add.php -->
            </div>
            <div class="box">
                <h3>Register a Student</h3>
                <p>This section allows you to register a new student in the system. Click the button below to proceed with the registration process.</p>
                <a href="student/register.php">Register</a> <!-- Placeholder link for registration page -->
            </div>
        </div>

        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>
</html>
