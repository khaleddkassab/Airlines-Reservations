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

        /* Add your styles here */
        body {

            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            background-color: #F0F0F0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1100px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            position: relative;
            background-image: url('images/bg.jpg');
            /* Replace 'path_to_your_image.jpg' with the actual path to your image */
            background-size: cover;
            /* Adjust the background size as needed */
            background-repeat: no-repeat;
            background-position: center;

        }

        .company-info {
            text-align: left;
            margin-bottom: 20px;
        }

        .company-info h2 {
            text-align: center;
            /* Center the text horizontally */
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

        .flight-table th,
        .flight-table td {
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

        .show-details {
            cursor: pointer;
            color: blue;
        }

        .navigation-card {
            width: fit-content;
            height: fit-content;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
            background-color: rgb(255, 255, 255);
            padding: 15px 20px;
            border-radius: 50px;
        }

        .tab {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            overflow: hidden;
            background-color: rgb(252, 252, 252);
            padding: 15px;
            border-radius: 50%;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
        }

        .tab:hover {
            background-color: rgb(223, 223, 223);
        }

        .logout {
            position: absolute;
            top: 10px;
            /* Adjust the top value as needed */
            right: 20px;
            /* Align to the right side */
        }

        .navigation {
            display: flex;
            margin-left: 950px;
            margin-bottom: 20px;
        }

        .navigation a {
            text-decoration: none;
            padding: 15px;
            background-color: black;
            color: #fff;
            border-radius: 90px;
            transition: background-color 0.3s ease;
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

            // Validate and sanitize inputs (add more validation as needed)
            if (empty($accountBalance) || empty($userName) || empty($name) || empty($tel) || empty($password)) {
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
                        $updatePassengerQuery = "UPDATE passenger SET account_balance = '$accountBalance' WHERE user_id = $userId";
                        $updatePassengerResult = $con->query($updatePassengerQuery);

                        if ($updatePassengerResult) {
                            echo "<p>Profile updated successfully.</p>";
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

        // Close the database connection
        $con->close();
        ?>

        <!-- Add the button to redirect to the profile -->
        <a href="passengerProfile.php?user_id=<?php echo $userId; ?>" class="back-to-profile-btn">Back to Profile</a>

        <h2>Edit Passenger Profile</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?user_id=$userId"; ?>"
            enctype="multipart/form-data">
            <!-- Input fields for other profile details -->
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

            <!-- Save Changes button -->
            <input class="back-to-profile-btn" type="submit" value="Save Changes">
        </form>
    </div>
</body>

</html>