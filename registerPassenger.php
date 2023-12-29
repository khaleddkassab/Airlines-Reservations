<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Registration</title>
    <link rel="stylesheet" href="styles.css">

    <style>
    /* Add your styles here */

    .registration-form {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f2f2f2;
    }

    body {
        background-image: url('background.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
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
        width: 200px;
        margin-top: 10px;
        margin-left: 400px;
    }

    body {
        background-image: url('background.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
    </style>
</head>

<body>

    <div class="registration-form">
        <h2>Register as Passenger</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="passenger_id">Passenger ID:</label>
                <input type="text" id="passenger_id" name="passenger_id" required>
            </div>
            <div class="form-group">
                <label for="photo">Photo:</label>
                <input type="file" id="photo" name="photo" required accept="image/*">
            </div>
            <div class="form-group">
                <label for="passport_img">Passport Image:</label>
                <input type="file" id="passport_img" name="passport_img" required accept="image/*">
            </div>
            <div class="form-group">
                <label for="account_balance">Account Balance:</label>
                <input type="text" id="account_balance" name="account_balance" required>
            </div>

            <!-- Hidden input to store the user_id -->
            <input type="hidden" id="user_id" name="user_id" value="<?php echo $_GET['id']; ?>">

            <button type="submit" class="submit-btn">Register as Passenger</button>
        </form>
    </div>

    <?php
    require_once('C:\AppServ\www\Airlines\connection.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $currentid = isset($_POST['passenger_id']) ? $_POST['passenger_id'] : '';
        // Handle image uploads for photo and passport_img
        $photo = ''; // Store the path or data for photo
        $passportImg = ''; // Store the path or data for passport image
        $accountBalance = isset($_POST['account_balance']) ? $_POST['account_balance'] : '';
        $userId = isset($_POST['user_id']) ? $_POST['user_id'] : '';

        // Code to handle file uploads for photo and passport_img (not shown here)
    
        // Insert data into Passenger table
        $sql = "INSERT INTO passenger (passenger_id, user_id, photo, passport_img, account_balance) VALUES ('$currentid', '$userId', '$photo', '$passportImg', '$accountBalance')";
        if ($con->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $con->error;
        } else {
            // Passenger registered successfully, redirect to login page
            header("Location: login.php");
            exit(); // Ensure that subsequent code is not executed after redirection
        }
    }

    $con->close();
    ?>
    <script>
    var passengerForm = document.getElementById('passengerForm');
    var accountBalanceInput = document.getElementById('account_balance');
    var accountBalanceMessage = document.getElementById('accountBalanceMessage');

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

    passengerForm.addEventListener('submit', function(event) {
        // You can add additional validation logic here before submitting the form
        var accountBalance = parseFloat(accountBalanceInput.value);

        if (isNaN(accountBalance) || accountBalance < 0) {
            accountBalanceMessage.textContent = 'Account balance should be a positive number.';
            accountBalanceMessage.style.color = 'red';
            event.preventDefault(); // Prevent form submission
        }
    });
    </script>

</body>

</html>