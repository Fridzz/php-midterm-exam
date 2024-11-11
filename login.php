<?php
session_start();
$errors = [];
$success = "";

// Check if the user is already logged in, if so, redirect to dashboard
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: dashboard.php");
    exit;
}

// Predefined email and password for multiple users
$accounts = [
    "pasia@gmail.com" => "pass123",
    "john@example.com" => "johnpass",
    "alice@example.com" => "alicepass",
    "bob@example.com" => "bobpass",
    "charlie@example.com" => "charliepass"
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email and password fields are filled
    if (empty($_POST["email"])) {
        $errors[] = "Email is required";
        
        // Additional error message if only the password is filled
        if (!empty($_POST["password"])) {
            $errors[] = "Invalid Password";
        }
    }
    if (empty($_POST["password"])) {
        $errors[] = "Password is required";
        
        // Additional error message if only the email is filled
        if (!empty($_POST["email"])) {
            $errors[] = "Invalid Email";
        }
    }

    // If no empty field errors, check credentials
    if (empty($errors)) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Check if credentials match any of the predefined accounts
        if (array_key_exists($email, $accounts) && $accounts[$email] === $password) {
            $_SESSION['loggedin'] = true; // Set session for logged-in user
            $_SESSION['email'] = $email;  // Store user email in session
            header("Location: dashboard.php"); // Redirect to dashboard
            exit;
        } 
        else {
            $errors[] = "Invalid email or password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Body */
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f2f2f2;
        }

        /* Form container */
        .form-container {
            width: 300px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Error and success messages */
        .error-message, .success-message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 0.9em;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error-message ul {
            list-style-type: none;
            padding-left: 0;
        }

        /* Form title */
        .form-container h2 {
            margin-bottom: 20px;
            font-size: 1.5em;
            color: #333;
        }

        /* Input fields */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 0.9em;
            color: #333;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Login button */
        .login-btn {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Login</h2>

        <!-- Display error messages if there are any -->
        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <strong>System Errors</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="email">Email address</label>
                <!-- Keep entered email in the input field after failed login -->
                <input type="email" id="email" name="email" placeholder="Enter email" value="<?php echo isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <!-- Keep entered password in the input field after failed login -->
                <input type="password" id="password" name="password" placeholder="Password">
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>

</body>
</html>
