<?php
session_start();

$errors = array();
$code = "";
$name = "";

// Initialize session array if it doesn't exist
if (!isset($_SESSION['subjects'])) {
    $_SESSION['subjects'] = array();
}

// Function to check for duplicate subject
function isDuplicate($code, $name) {
    foreach ($_SESSION['subjects'] as $subject) {
        if ($subject['code'] == $code || $subject['name'] == $name) {
            return true;
        }
    }
    return false;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = trim($_POST['subjectCode']);
    $name = trim($_POST['subjectName']);

    // Validate form fields
    if (empty($code)) {
        $errors[] = "Subject Code is required";
    }

    if (empty($name)) {
        $errors[] = "Subject Name is required";
    }

    // Check for duplicates if no errors
    if (empty($errors) && isDuplicate($code, $name)) {
        $errors[] = "Duplicate Subject";
        // Clear the form fields if duplicate is found
        $code = "";
        $name = "";
    }

    // If no errors, add the subject and clear the form
    if (empty($errors)) {
        $_SESSION['subjects'][] = array("code" => $code, "name" => $name);
        // Clear the form values
        $code = "";
        $name = "";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // JavaScript function to prevent entering non-numeric values in Subject Code field
        function onlyAllowNumbers(event) {
            const charCode = event.which ? event.which : event.keyCode;
            if (charCode < 48 || charCode > 57) { // If it's not a number (0-9)
                event.preventDefault();
            }
        }
    </script>
</head>
<body>
<div class="container mt-5">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Subject</li>
        </ol>
    </nav>

    <h3 class="mb-4">Add a New Subject</h3>

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

    <form method="POST" action="add.php">
        <div class="mb-3">
            <label for="subjectCode" class="form-label">Subject Code</label>
            <input type="text" class="form-control <?php echo isset($errors['code']) ? 'is-invalid' : ''; ?>" id="subjectCode" name="subjectCode" placeholder="Enter Subject Code" value="<?php echo htmlspecialchars($code); ?>" required oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
            <!-- Using oninput to strip non-numeric characters immediately -->
        </div>
        <div class="mb-3">
            <label for="subjectName" class="form-label">Subject Name</label>
            <input type="text" class="form-control <?php echo isset($errors['name']) ? 'is-invalid' : ''; ?>" id="subjectName" name="subjectName" placeholder="Enter Subject Name" value="<?php echo htmlspecialchars($name); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Subject</button>
    </form>

    <hr class="my-4">
    <h4>Subject List</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Subject Code</th>
                <th>Subject Name</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (isset($_SESSION['subjects']) && count($_SESSION['subjects']) > 0) {
            foreach ($_SESSION['subjects'] as $index => $subject) {
                echo "<tr>
                        <td>{$subject['code']}</td>
                        <td>{$subject['name']}</td>
                        <td>
                            <a href='edit.php?index={$index}' class='btn btn-sm btn-warning'>Edit</a>
                            <a href='delete.php?index={$index}' class='btn btn-sm btn-danger'>Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No subject found.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
