<?php
session_start();

// Ensure students session exists
if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];  // Initialize an empty array if not set
}

// Get the student ID from the URL
if (!isset($_GET['id'])) {
    header("Location: register.php");
    exit;
}

$id = $_GET['id'];
$student = null;

// Find the student to edit
foreach ($_SESSION['students'] as &$item) {
    if ($item['id'] === $id) {
        $student = &$item;
        break;
    }
}

// If student not found, redirect
if (!$student) {
    header("Location: register.php");
    exit;
}

// Handle form submission to update student
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Use isset() to check if POST variables exist and trim them
    $newStudentID = isset($_POST['studentID']) ? trim($_POST['studentID']) : '';
    $firstName = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
    $lastName = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';

    // Debugging: Check if values are being passed correctly
    // You can remove this after debugging
    var_dump($newStudentID, $firstName, $lastName);

    // Validate input
    if (empty($newStudentID) || empty($firstName) || empty($lastName)) {
        // Add validation message (you can adjust error handling here)
        $error = "All fields are required.";
    } else {
        // Update the student data in the session
        $student['studentID'] = $newStudentID;
        $student['firstName'] = $firstName;
        $student['lastName'] = $lastName;

        // Redirect back to the student list page
        header("Location: register.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <!-- Breadcrumb navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="register.php">Register Students</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Student</li>
            </ol>
        </nav>

        <h2>Edit Student</h2>

        <!-- Display errors if any -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="studentID">Student ID</label>
                <!-- Use readonly so that the field can't be edited -->
                <input type="text" name="studentID" class="form-control" id="studentID" value="<?php echo htmlspecialchars($student['studentID']); ?>" required readonly>
            </div>
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" name="firstName" class="form-control" id="firstName" value="<?php echo htmlspecialchars($student['firstName']); ?>" required>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" name="lastName" class="form-control" id="lastName" value="<?php echo htmlspecialchars($student['lastName']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</body>
</html>
