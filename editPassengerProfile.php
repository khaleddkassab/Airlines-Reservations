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
    </style>
</head>

<body>
    <div class="container">
        <?php
        // Include your database connection file
        require_once('C:\AppServ\www\Airlines\connection.php');

        // Retrieve the user ID from the URL
        $userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get form data
            $accountBalance = $_POST['accountBalance'];
            // You can handle file uploads for photo and passport_image here
        
            // Update passenger profile in the database
            $updateQuery = "UPDATE passenger SET account_balance = '$accountBalance', photo = '$photo', passport_img = '$passportImage' WHERE user_id = $userId"; // Change 'id' to your actual primary key column name
            $updateResult = $con->query($updateQuery);

            if ($updateResult) {
                // Redirect to the profile page after updating
                header("Location: passengerProfile.php?user_id=$userId");
                exit(); // Ensure that subsequent code is not executed after redirection
            } else {
                echo "<p>Error updating profile: " . $con->error . "</p>";
            }
        }

        // Fetch the current passenger profile data
        $sql = "SELECT * FROM passenger WHERE user_id = $userId"; // Change 'id' to your actual primary key column name
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $accountBalance = $row['account_balance'];
            // You can populate photo and passport_image fields here, if needed
        } else {
            // Handle case when no profile data is found
            $accountBalance = '';
            // Initialize photo and passport_image fields if needed
        }

        // Close the database connection
        $con->close();
        ?>

        <h2>Edit Passenger Profile</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?user_id=$userId"; ?>"
            enctype="multipart/form-data">
            <label for="accountBalance">Account Balance:</label><br>
            <input type="text" id="accountBalance" name="accountBalance" value="<?php echo $accountBalance; ?>"><br><br>

            <!-- Input field for Photo -->
            <label for="photo">Photo:</label><br>
            <input type="file" id="photo" name="photo"><br><br>

            <!-- Input field for Passport Image -->
            <label for="passportImage">Passport Image:</label><br>
            <input type="file" id="passportImage" name="passportImage"><br><br>

            <input type="submit" value="Save Changes">
        </form>
    </div>
</body>

</html>