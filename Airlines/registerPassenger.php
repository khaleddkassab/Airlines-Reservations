<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Registration</title>
    <style>
        /* Add your styles here */
        /* Similar styles as in the registration page */
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
require_once('C:\AppServ\www\project1\connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $passengerId = isset($_POST['passenger_id']) ? $_POST['passenger_id'] : '';
    // Handle image uploads for photo and passport_img
    $photo = ''; // Store the path or data for photo
    $passportImg = ''; // Store the path or data for passport image
    $accountBalance = isset($_POST['account_balance']) ? $_POST['account_balance'] : '';
    $userId = isset($_POST['user_id']) ? $_POST['user_id'] : '';

    // Code to handle file uploads for photo and passport_img (not shown here)

    // Insert data into Passenger table
    $sql = "INSERT INTO passenger (passenger_id, user_id, photo, passport_img, account_balance) VALUES ('$passengerId', '$userId', '$photo', '$passportImg', '$accountBalance')";
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

</body>
</html>
