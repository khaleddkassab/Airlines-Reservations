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
        
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .company-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .company-info img {
            max-width: 200px;
            height: auto;
        }

        .flight-list {
            margin-bottom: 20px;
        }

        .flight-list h3 {
            margin-bottom: 10px;
        }

        .flight-table {
            width: 100%;
            border-collapse: collapse;
        }

        .flight-table th, .flight-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .flight-table th {
            background-color: #f4f4f4;
        }

        .flight-details {
            display: none;
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .flight-details h3 {
            margin-top: 0;
        }

        .flight-details ul {
            padding-left: 20px;
        }

        .show-details {
            cursor: pointer;
            color: blue;
        }
    </style>
</head>
<body>
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
            <button type="submit" class="submit-btn">Login</button>
        </form>

        <!-- Button for redirecting to register page -->
        <form method="get" action="register.php">
            <button type="submit" class="submit-btn">Register</button>
        </form>
    </div>

    <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include your database connection file
    require_once('C:\AppServ\www\project1\connection.php');

    // Retrieve user input from the form
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Check if both username and password were provided
    if (!empty($username) && !empty($password)) {
        // Check user credentials in the database
        $sql = "SELECT * FROM userr WHERE username = '$username' AND password = '$password'";
        $result = $con->query($sql);

        // Check if the query was successful
        if ($result && $result->num_rows > 0) {
            // Fetch the user data
            $user = $result->fetch_assoc();
            $userId = $user['id'];
            $userType = $user['userType'];

            // Redirect based on user type
            if ($userType === 'passenger') {
                // Redirect to Passenger Home page
                header("Location: passengerHome.php?user_id=$userId");
                exit(); // Ensure that subsequent code is not executed after redirection
            } elseif ($userType === 'employee') {
                // Redirect to Employee Home page
                header("Location: home.php?user_id=$userId");
                exit(); // Ensure that subsequent code is not executed after redirection
            } else {
                echo "<p>User type not recognized.</p>";
            }
        } else {
            echo "<p>Invalid credentials.</p>";
        }
    } else {
        echo "<p>Please enter both username and password.</p>";
    }

    // Close the database connection
    $con->close();
}
?>

</body>
</html>
