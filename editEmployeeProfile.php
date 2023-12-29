<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Add your styles or link external stylesheets here -->
    <!-- Include your stylesheets, if any -->
    <style>
    /* Add your styles here */
    /* ... (style your elements as needed) ... */
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

    /* Add styles for the button */
    .back-to-profile-btn {
        display: inline-block;
        padding: 8px 16px;
        text-decoration: none;
        background-color: black;
        color: #fff;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .back-to-profile-btn:hover {
        background-color: #2980b9;
    }

    header {

        padding: 15px;
        text-align: center;
        margin-left: 450px;
    }

    /* Styling for the header links */
    header a {
        color: black;
        text-decoration: none;
        margin: 10px;
        margin-left: 10px;
        margin-top: 20px;
    }
    </style>
</head>

<body>
    <div class="container">
        <?php
        // Start the session
        session_start();
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : (isset($_GET['user_id']) ? $_GET['user_id'] : null);

        // Check if the user is logged in
        if (!$userId) {
            // Redirect to the login page or handle the situation when the user is not logged in
            header("Location: login.php"); // Change 'login.php' to your actual login page
            exit();
        }

        // Include your database connection file
        require_once('C:\AppServ\www\Airlines\connection.php');

        // Retrieve the user ID from the session
        $userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get form data
            $accountBalance = mysqli_real_escape_string($con, $_POST['accountBalance']);
            $userName = mysqli_real_escape_string($con, $_POST['userName']);
            $name = mysqli_real_escape_string($con, $_POST['name']);
            $tel = mysqli_real_escape_string($con, $_POST['tel']);
            $password = mysqli_real_escape_string($con, $_POST['password']);
            $companyBio = mysqli_real_escape_string($con, $_POST['companyBio']);
            $companyAddress = mysqli_real_escape_string($con, $_POST['companyAddress']);

            // Validate and sanitize inputs (add more validation as needed)
            if (empty($accountBalance) || empty($userName) || empty($name) || empty($tel) || empty($password) || empty($companyBio) || empty($companyAddress)) {
                echo "<p>Error: All fields are required.</p>";
            } else {
                // Check if the new username is not repeated
                $checkUsernameQuery = "SELECT * FROM userr WHERE id != $userId AND username = '$userName'";
                $checkUsernameResult = $con->query($checkUsernameQuery);

                if ($checkUsernameResult->num_rows == 0) {
                    // Update user table
                    $updateUserQuery = "UPDATE userr SET username = '$userName', name = '$name', tel = '$tel', password = '$password' WHERE id = $userId";
                    $updateUserResult = $con->query($updateUserQuery);

                    if ($updateUserResult) {
                        // Update passenger table
                        $updatePassengerQuery = "UPDATE employee SET account_balance = $accountBalance WHERE user_id = $userId";
                        $updatePassengerResult = $con->query($updatePassengerQuery);

                        if ($updatePassengerResult) {
                            // Update company profile
                            $updateCompanyQuery = "UPDATE employee SET bio = '$companyBio', address = '$companyAddress' WHERE user_id = $userId";
                            $updateCompanyResult = $con->query($updateCompanyQuery);

                            if ($updateCompanyResult) {
                                echo "<p>Profile updated successfully.</p>";
                            } else {
                                echo "<p>Error updating company profile: " . $con->error . "</p>";
                            }
                        } else {
                            echo "<p>Error updating passenger profile: " . $con->error . "</p>";
                        }
                    } else {
                        echo "<p>Error updating user profile: " . $con->error . "</p>";
                        echo "<p>SQL Query: " . $updateUserQuery . "</p>";
                    }
                } else {
                    echo "<p>Error: The username '$userName' is already taken. Choose a different username.</p>";
                }
            }
        }

        // Fetch the current passenger profile data
        $sql = "SELECT * FROM passenger WHERE user_id = $userId";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $accountBalance = $row['account_balance'];
        } else {
            // Handle case when no profile data is found
            $accountBalance = '';
        }

        // Fetch the current user profile data
        $userSql = "SELECT * FROM userr WHERE id = $userId";
        $userResult = $con->query($userSql);

        if ($userResult->num_rows > 0) {
            $userRow = $userResult->fetch_assoc();
            $userName = $userRow['username'];
            $name = $userRow['name'];
            $tel = $userRow['tel'];
            $password = $userRow['password'];
        } else {
            // Handle case when no profile data is found
            $userName = '';
            $name = '';
            $tel = '';
            $password = '';
        }

        // Fetch the current company profile data
        $companySql = "SELECT * FROM employee WHERE user_id = $userId";
        $companyResult = $con->query($companySql);

        if ($companyResult->num_rows > 0) {
            $companyRow = $companyResult->fetch_assoc();
            $companyBio = $companyRow['bio'];
            $companyAddress = $companyRow['address'];
        } else {
            // Handle case when no profile data is found
            $companyBio = '';
            $companyAddress = '';
        }

        // Close the database connection
        $con->close();
        ?>

        <!-- Add the button to redirect to the profile -->
        <a href="employeeProfile.php?user_id=<?php echo $userId; ?>" class="back-to-profile-btn">Back to Profile</a>

        <h2>Edit Profile</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?user_id=$userId"; ?>"
            enctype="multipart/form-data">
            <!-- Input fields for passenger profile details -->
            <label for="accountBalance">Account Balance:</label><br>
            <input type="text" id="accountBalance" name="accountBalance" value="<?php echo $accountBalance; ?>"><br><br>
            <label for="userName">User Name:</label><br>
            <input type="text" id="userName" name="userName" value="<?php echo $userName; ?>"><br><br>
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>"><br><br>
            <label for="tel">Telephone:</label><br>
            <input type="text" id="tel" name="tel" value="<?php echo $tel; ?>"><br><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" value="<?php echo $password; ?>"><br><br>

            <!-- Input fields for company profile details -->
            <label for="companyBio">Company Bio:</label><br>
            <textarea id="companyBio" name="companyBio"><?php echo $companyBio; ?></textarea><br><br>
            <label for="companyAddress">Company Address:</label><br>
            <input type="text" id="companyAddress" name="companyAddress" value="<?php echo $companyAddress; ?>"><br><br>

            <!-- Save Changes button -->
            <input class="back-to-profile-btn" type="submit" value="Save Changes">
        </form>
    </div>
</body>

</html>