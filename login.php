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
            // Redirect with query parameter for invalid credentials
            header("Location: login.php?invalidCredentials=true");
            exit();
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
    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Styles -->
    <style>
        .header {
            background-color: #f2f2f2;
            color: black;
            padding: 30px;
        }

        .header h1 {
            margin: 0;
            display: inline;
        }

        body {
            background-image: url('images/backgroundregister.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            /* Optional: This keeps the background fixed while scrolling */
        }

        .login-form {
            max-width: 400px;
            margin: 150px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f2f2f2;

        }

        .right-aligned-logo {
            float: right;
            margin-right: 50px;
            /* Optional: Add some spacing to the right of the image */
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
            background-color: black;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100px;
            margin-top: 10px;
            margin-left: 299px;
        }

        .about-section {
            background-color: #f2f2f2;
            padding: 20px;
            margin-top: 30px;
            text-align: center;
        }

        /* Add style for the error message */
        #invalidCredentialsMsg {
            color: red;
            display: none;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Welcome to Flyght</h1>

        <img src="images/logo.png" alt="Logo description" width="200" height="50" class="right-aligned-logo">

    </div>

    <div class="login-form">
        <h2>Login</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <span>
                <button type="submit" class="submit-btn">Login</button>
                <button type="button" class="submit-btn" id="signupBtn">Sign Up</button>
            </span>
        </form>
        <!-- Display message for invalid credentials -->
        <p id="invalidCredentialsMsg">Invalid credentials. Please try again.</p>
    </div>
    <div class="about-section">
        <h1><b>About</b></h1>
        <p>Soar Beyond Boundaries: Your Journey, Our Expertise!</p>
    </div>
    <!-- Your existing JavaScript code -->
    <script>
        // Get the button element by its ID
        var signupBtn = document.getElementById('signupBtn');

        // Add a click event listener to the button
        signupBtn.addEventListener('click', function () {
            // Redirect to register.php
            window.location.href = 'register.php';
        });

        // Check if there's a query parameter indicating invalid credentials
        var urlParams = new URLSearchParams(window.location.search);
        var invalidCredentials = urlParams.get('invalidCredentials');

        // Display the message if invalid credentials
        if (invalidCredentials) {
            var invalidCredentialsMsg = document.getElementById('invalidCredentialsMsg');
            invalidCredentialsMsg.style.display = 'block';
        }
    </script>
</body>

</html>