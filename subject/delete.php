<?php
session_start();

// Get the index of the subject to be deleted from the query parameter
$index = isset($_GET['index']) ? $_GET['index'] : null;

// Check if the index is valid
if ($index === null || !isset($_SESSION['subjects'][$index])) {
    echo "Invalid subject!";
    exit;
}

// Get the subject data (code and name) for confirmation display
$subject = $_SESSION['subjects'][$index];

// Check if the form is submitted for deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Perform the deletion by removing the subject from the session
    unset($_SESSION['subjects'][$index]);
    // Re-index the session array to avoid gaps in the index numbers
    $_SESSION['subjects'] = array_values($_SESSION['subjects']);
    // Redirect back to the main page after deletion
    header('Location: add.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="../subject/add.php">Add Subject</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete Subject</li>
        </ol>
    </nav>

    <h3 class="mb-4">Delete Subject</h3>

    <form method="POST" action="delete.php?index=<?php echo $index; ?>">
        <div class="alert alert-warning">
            <p>Are you sure you want to delete the following subject record?</p>
            <ul>
                <li><strong>Subject Code:</strong> <?php echo htmlspecialchars($subject['code']); ?></li>
                <li><strong>Subject Name:</strong> <?php echo htmlspecialchars($subject['name']); ?></li>
            </ul>
        </div>
        <button type="submit" class="btn btn-danger">Delete Subject Record</button>
        <a href="add.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
