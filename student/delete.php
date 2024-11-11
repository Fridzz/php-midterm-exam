<?php
session_start();

// Retrieve student details from the URL
$student_id = isset($_GET['id']) ? $_GET['id'] : '';
$studentID = isset($_GET['studentID']) ? $_GET['studentID'] : '';
$firstName = isset($_GET['firstName']) ? $_GET['firstName'] : '';
$lastName = isset($_GET['lastName']) ? $_GET['lastName'] : '';

// Find the student index in the session array
$student_index = null;
foreach ($_SESSION['students'] as $index => $student) {
    if ($student['id'] == $student_id) {
        $student_index = $index;
        break;
    }
}

// Handle delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    if ($student_index !== null) {
        // Remove the student from the session array
        unset($_SESSION['students'][$student_index]);
        $_SESSION['students'] = array_values($_SESSION['students']);
        $_SESSION['message'] = "Student with ID $studentID has been deleted.";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete a Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Delete a Student</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete Student</li>
        </ol>
    </nav>
    
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['message']; ?>
            <?php unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <div class="card p-4">
        <h4>Are you sure you want to delete the following student?</h4>
        <ul>
            <li><strong>Student ID:</strong> <?= htmlspecialchars($studentID) ?></li>
            <li><strong>First Name:</strong> <?= htmlspecialchars($firstName) ?></li>
            <li><strong>Last Name:</strong> <?= htmlspecialchars($lastName) ?></li>
        </ul>
        
        <form method="POST">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='register.php'">Cancel</button>
            <button type="submit" name="confirm_delete" class="btn btn-danger">Delete Student Record</button>
        </form>
    </div>
</div>

</body>
</html>
