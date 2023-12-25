<?php
// Start the session
session_start();

// Include your database connection file
require_once('C:\AppServ\www\Airlines\connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input from the form
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Check if both username and password were provided
    if (!empty($username) && !empty($password)) {
        // Use prepared statements to prevent SQL injection
        $stmt = $con->prepare("SELECT * FROM userr WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the query was successful
        if ($result && $result->num_rows > 0) {
            // Fetch the user data
            $user = $result->fetch_assoc();
            $userId = $user['id'];
            $userType = $user['userType'];

            // Save user data in the session
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_type'] = $userType;

            // Redirect based on user type
            if ($userType === 'passenger') {
                // Redirect to Passenger Home page
                header("Location: passengerHome.php");
                exit(); // Ensure that subsequent code is not executed after redirection
            } elseif ($userType === 'employee') {
                // Redirect to Employee Home page
                header("Location: home.php");
                exit(); // Ensure that subsequent code is not executed after redirection
            } else {
                echo "<p>User type not recognized.</p>";
            }
        } else {
            echo "<p>Invalid credentials.</p>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<p>Please enter both username and password.</p>";
    }
}

// Close the database connection
$con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        /* Add your styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .login-form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .submit-btn {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="login-form">
        <h2>Login</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="submit-btn">Login</button>
        </form>

        <!-- Button for redirecting to register page -->
        <form method="get" action="register.php">
            <button type="submit" class="submit-btn">Register</button>
        </form>
    </div>
</body>

</html>