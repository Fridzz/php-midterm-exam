<?php
session_start();

// Get student information from URL parameters if they exist
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : '';
$first_name = isset($_GET['first_name']) ? $_GET['first_name'] : '';
$last_name = isset($_GET['last_name']) ? $_GET['last_name'] : '';

// Check if the student is found in the session and if they exist in the student list
$student_index = null;
foreach ($_SESSION['students'] as $index => $student) {
    if ($student['student_id'] == $student_id) {
        $student_index = $index;
        break;
    }
}

// Handle delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    if ($student_index !== null) {
        // Remove the student from the session array
        unset($_SESSION['students'][$student_index]);
        
        // Re-index the session array to avoid gaps in the index
        $_SESSION['students'] = array_values($_SESSION['students']);
    }

    // Redirect to the register page after deletion
    header("Location: register.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete a Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Delete a Student</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register_student.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete Student</li>
        </ol>
    </nav>
    
    <div class="card p-4">
        <ul>
            <li><strong>Student ID:</strong> <?= htmlspecialchars($student_id) ?></li>
            <li><strong>First Name:</strong> <?= htmlspecialchars($first_name) ?></li>
            <li><strong>Last Name:</strong> <?= htmlspecialchars($last_name) ?></li>
        </ul>
        
        <form method="POST">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='register.php'">Cancel</button>
            <button type="submit" name="confirm_delete" class="btn btn-danger">Delete Student Record</button>
        </form>
    </div>
</div>

</body>
</html>
