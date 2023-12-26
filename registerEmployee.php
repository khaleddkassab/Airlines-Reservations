<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Registration</title>
    <link rel="stylesheet" href="styles.css">

    <style>
    /* Add your styles here */

    .registration-form {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-group {
        margin-bottom: 15px;
        position: relative;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }

    .form-group .message {
        position: absolute;
        top: 100%;
        left: 0;
        color: red;
    }

    .submit-btn {
        background-color: black;
        color: white;
        padding: 10px;
        border: none;
        width: 140px;
        border-radius: 5px;
        cursor: pointer;
        width: 100px;
        margin-top: 10px;
        margin-left: 299px;
    }
    </style>
</head>

<body>

    <div class="registration-form">
        <h2>Register as Employee</h2>
        <form method="post" action="" id="employeeForm">
            <div class="form-group">
                <label for="employee_id">Employee ID:</label>
                <input type="text" id="employee_id" name="employee_id" required>
                <div class="message" id="employeeIdMessage"></div>
            </div>
            <div class="form-group">
                <label for="bio">Bio:</label>
                <textarea id="bio" name="bio" required></textarea>
                <div class="message" id="bioMessage"></div>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
                <div class="message" id="addressMessage"></div>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location">
            </div>
            <div class="form-group">
                <label for="account_balance">Account Balance:</label>
                <input type="text" id="account_balance" name="account_balance" required>
                <div class="message" id="accountBalanceMessage"></div>
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

    <script>
    var employeeForm = document.getElementById('employeeForm');
    var employeeIdInput = document.getElementById('employee_id');
    var employeeIdMessage = document.getElementById('employeeIdMessage');
    var bioInput = document.getElementById('bio');
    var bioMessage = document.getElementById('bioMessage');
    var addressInput = document.getElementById('address');
    var addressMessage = document.getElementById('addressMessage');
    var accountBalanceInput = document.getElementById('account_balance');
    var accountBalanceMessage = document.getElementById('accountBalanceMessage');

    employeeIdInput.addEventListener('input', function() {
        var employeeId = parseFloat(employeeIdInput.value);

        if (isNaN(employeeId) || employeeId < 0) {
            employeeIdMessage.textContent = 'Employee ID should be a positive number.';
            employeeIdMessage.style.color = 'red';
        } else {
            employeeIdMessage.textContent = ''; // Clear the message
        }
    });

    bioInput.addEventListener('input', function() {
        var bioValue = bioInput.value.trim();

        if (bioValue.length <= 10) {
            bioMessage.textContent = 'Bio should be more than 10 characters.';
            bioMessage.style.color = 'red';
        } else {
            bioMessage.textContent = ''; // Clear the message
        }
    });

    addressInput.addEventListener('input', function() {
        var addressValue = addressInput.value.trim();

        if (addressValue.length <= 10) {
            addressMessage.textContent = 'Address should be more than 10 characters.';
            addressMessage.style.color = 'red';
        } else {
            addressMessage.textContent = ''; // Clear the message
        }
    });

    accountBalanceInput.addEventListener('input', function() {
        // You can customize the validation logic based on your requirements
        var accountBalance = parseFloat(accountBalanceInput.value);

        if (isNaN(accountBalance) || accountBalance < 0) {
            accountBalanceMessage.textContent = 'Account balance should be a positive number.';
            accountBalanceMessage.style.color = 'red';
        } else {
            accountBalanceMessage.textContent = ''; // Clear the message
        }
    });

    employeeForm.addEventListener('submit', function(event) {
        var isValid = true;

        // Validate Employee ID
        var employeeId = parseFloat(employeeIdInput.value);
        if (isNaN(employeeId) || employeeId < 0) {
            employeeIdMessage.textContent = 'Employee ID should be a positive number.';
            employeeIdMessage.style.color = 'red';
            isValid = false;
        } else {
            employeeIdMessage.textContent = '';
        }

        // Validate Bio
        var bioValue = bioInput.value.trim();
        if (bioValue.length <= 10) {
            bioMessage.textContent = 'Bio should be more than 10 characters.';
            bioMessage.style.color = 'red';
            isValid = false;
        } else {
            bioMessage.textContent = '';
        }

        // Validate Address
        var addressValue = addressInput.value.trim();
        if (addressValue.length <= 10) {
            addressMessage.textContent = 'Address should be more than 10 characters.';
            addressMessage.style.color = 'red';
            isValid = false;
        } else {
            addressMessage.textContent = '';
        }

        // Validate Account Balance
        var accountBalance = parseFloat(accountBalanceInput.value);
        if (isNaN(accountBalance) || accountBalance < 0) {
            accountBalanceMessage.textContent = 'Account balance should be a positive number.';
            accountBalanceMessage.style.color = 'red';
            isValid = false;
        } else {
            accountBalanceMessage.textContent = '';
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
    </script>


</body>

</html>