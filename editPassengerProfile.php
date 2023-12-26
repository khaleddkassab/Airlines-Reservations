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

        // Include your database connection file
        require_once('C:\AppServ\www\Airlines\connection.php');

        // Retrieve the user ID from the URL
        $userId = $_SESSION['user_id'];

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get form data
            $accountBalance = $_POST['account_balance'];
            // You can handle file uploads for photo and passport_image here
        
            // Update passenger profile in the database
            $updateQuery = "UPDATE passenger SET account_balance = '$accountBalance' WHERE user_id = $userId"; // Change 'id' to your actual primary key column name
            $updateResult = $con->query($updateQuery);


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

        <!-- Add the button to redirect to the profile -->
        <a href="passengerProfile.php?user_id=<?php echo $userId; ?>" class="back-to-profile-btn">Back to Profile</a>

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
            <input class="back-to-profile-btn" type="submit" value="Save Changes">
        </form>
    </div>
</body>

</html>