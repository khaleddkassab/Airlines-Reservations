<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Registration</title>
    <style>
        /* Add your styles here */
        /* Similar styles as in the registration page */
    </style>
</head>

<body>

    <div class="registration-form">
        <h2>Register as Employee</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="employee_id">Employee ID:</label>
                <input type="text" id="employee_id" name="employee_id" required>
            </div>
            <div class="form-group">
                <label for="bio">Bio:</label>
                <textarea id="bio" name="bio" required></textarea>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location">
            </div>
            <div class="form-group">
                <label for="account_balance">Account Balance:</label>
                <input type="text" id="account_balance" name="account_balance" required>
            </div>

            <!-- Hidden input to store the user_id -->
            <input type="hidden" id="user_id" name="user_id" value="<?php echo $_GET['id']; ?>">

            <button type="submit" class="submit-btn">Register as Employee</button>
        </form>
    </div>

    <?php
    require_once('C:\AppServ\www\Airlines\connection.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $employeeId = isset($_POST['employee_id']) ? $_POST['employee_id'] : '';
        $bio = isset($_POST['bio']) ? $_POST['bio'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $location = isset($_POST['location']) ? $_POST['location'] : '';
        $accountBalance = isset($_POST['account_balance']) ? $_POST['account_balance'] : '';
        $userId = isset($_POST['user_id']) ? $_POST['user_id'] : '';

        // Insert data into Employee table
        $sql = "INSERT INTO Employee (employee_id, user_id, bio, address, location, account_balance) VALUES ('$employeeId', '$userId', '$bio', '$address', '$location', '$accountBalance')";
        if ($con->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $con->error;
        } else {
            // Employee registered successfully, redirect to login page
            header("Location: login.php");
            exit(); // Ensure that subsequent code is not executed after redirection
        }
    }

    $con->close();
    ?>

</body>

</html>