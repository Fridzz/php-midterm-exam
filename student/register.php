<?php
session_start();

// Initialize students array in session if it doesn't exist
if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

// Initialize the last used student ID (start from 1001 or from the last used ID)
if (!isset($_SESSION['last_student_id'])) {
    $_SESSION['last_student_id'] = 1000; // Starting ID value
}

$errors = [];

// Handle form submission to add a new student
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Increment the last student ID by 1
    $_SESSION['last_student_id']++;

    // Get form inputs
    $studentID = $_SESSION['last_student_id']; // Use the incremented ID
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);

    // Validate input fields and collect error messages
    if (empty($firstName)) {
        $errors[] = "First name is required.";
    }

    if (empty($lastName)) {
        $errors[] = "Last name is required.";
    }

    // If no errors, add the new student
    if (empty($errors)) {
        $_SESSION['students'][] = [
            'id' => uniqid(), // Unique ID for each student
            'studentID' => $studentID,
            'firstName' => $firstName,
            'lastName' => $lastName
        ];
        // Clear the form inputs after successful submission
        $firstName = $lastName = "";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register a New Student</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Register a New Student</h2>
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Register Student</li>
            </ol>
        </nav>

        <!-- Display errors if there are any -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <strong>System Error</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card mt-3">
            <div class="card-body">
                <form action="register.php" method="POST">
                    <div class="form-group">
                        <label for="studentID">Student ID</label>
                        <!-- Student ID will be auto-generated and visible -->
                        <input type="text" name="studentID" class="form-control" id="studentID" value="<?php echo isset($studentID) ? htmlspecialchars($studentID) : $_SESSION['last_student_id']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" name="firstName" class="form-control" id="firstName" value="<?php echo isset($firstName) ? htmlspecialchars($firstName) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" name="lastName" class="form-control" id="lastName" value="<?php echo isset($lastName) ? htmlspecialchars($lastName) : ''; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Student</button>
                </form>
            </div>
        </div>

        <h3 class="mt-5">Student List</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($_SESSION['students'])) : ?>
                    <?php foreach ($_SESSION['students'] as $student) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['studentID']); ?></td>
                            <td><?php echo htmlspecialchars($student['firstName']); ?></td>
                            <td><?php echo htmlspecialchars($student['lastName']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $student['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete.php?id=<?php echo $student['id']; ?>&studentID=<?php echo $student['studentID']; ?>&firstName=<?php echo urlencode($student['firstName']); ?>&lastName=<?php echo urlencode($student['lastName']); ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4">No student records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
