<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
    /* Your existing CSS styles */
    body {
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        background-color: #F0F0F0;
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
        position: relative;
    }

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

    h2 {
        text-align: center;
    }

    form {
        margin-top: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    .navigation {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 20px;
    }

    .navigation a {
        text-decoration: none;
        padding: 15px;
        background-color: black;
        color: #fff;
        border-radius: 90px;
        transition: background-color 0.3s ease;
        margin-left: 10px;
    }
    </style>
    <script>
    // JavaScript to provide instructions for the account balance input
    document.addEventListener('DOMContentLoaded', function() {
        var accountBalanceInput = document.getElementById('accountBalance');

        accountBalanceInput.addEventListener('focus', function() {
            accountBalanceInput.placeholder = 'Enter your account balance';
        });

        accountBalanceInput.addEventListener('blur', function() {
            accountBalanceInput.placeholder = '';
        });
    });
    </script>
</head>

<body>
    <?php
// Start the session
session_start();

// Include your database connection file
require_once('C:\AppServ\www\Airlines\connection.php');

// Retrieve the user ID from the URL
$userId = $_SESSION['user_id'];

// Initialize the variable
$accountBalance = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $accountBalance = $_POST['accountBalance'];

    // Update passenger profile in the database
    $updateQuery = "UPDATE passenger SET account_balance = '$accountBalance' WHERE user_id = $userId";
    if ($con->query($updateQuery) === TRUE) {
        // Redirect to passengerProfile.php after successful update
        header("Location: passengerProfile.php?user_id=$userId");
        exit(); // Make sure to stop script execution after redirection
    } else {
        // Handle the case when the update fails (you may want to add error handling)
        echo "Error updating record: " . $con->error;
    }
}

// Close the database connection
$con->close();
?>

    <div class="container">
        <!-- Add the button to redirect to the profile -->
        <a href="passengerProfile.php?user_id=<?php echo $userId; ?>" class="back-to-profile-btn">Back to Profile</a>

        <h2>Edit Passenger Profile</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?user_id=$userId"; ?>"
            enctype="multipart/form-data">
            <label for="accountBalance">Account Balance:</label>
            <input type="text" id="accountBalance" name="accountBalance" value="<?php echo $accountBalance; ?>">
            <!-- Input field for Photo -->
            <label for="photo">Photo:</label>
            <input type="file" id="photo" name="photo">
            <!-- Input field for Passport Image -->
            <label for="passportImage">Passport Image:</label>
            <input type="file" id="passportImage" name="passportImage">
            <input class="back-to-profile-btn" type="submit" value="Save Changes">
        </form>
    </div>
</body>

</html>