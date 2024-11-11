<?php
session_start();

// Get the index from the URL query string
$index = isset($_GET['index']) ? $_GET['index'] : null;

// Check if the index is valid
if ($index === null || !isset($_SESSION['subjects'][$index])) {
    echo "Invalid subject!";
    exit;
}

// Get the subject data
$subject = $_SESSION['subjects'][$index];

// Initialize variables
$name = $subject['name'];
$errors = array();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['subjectName']);

    // Validate form fields
    if (empty($name)) {
        $errors[] = "Subject Name is required";
    }

    // If no errors, update the subject name
    if (empty($errors)) {
        $_SESSION['subjects'][$index]['name'] = $name;
        // Redirect back to the subject list after updating
        header('Location: add.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Edit Subject</h3>

    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="add.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="add.php">Add Subject</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Subject</li>
        </ol>
    </nav>

    <!-- Display errors if any -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <h5>Error System</h5>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="edit.php?index=<?php echo $index; ?>">
        <div class="mb-3">
            <label for="subjectCode" class="form-label">Subject Code</label>
            <!-- Disable the Subject Code input field -->
            <input type="text" class="form-control" id="subjectCode" name="subjectCode" value="<?php echo htmlspecialchars($subject['code']); ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="subjectName" class="form-label">Subject Name</label>
            <input type="text" class="form-control" id="subjectName" name="subjectName" value="<?php echo htmlspecialchars($name); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Subject</button>
        <a href="add.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
