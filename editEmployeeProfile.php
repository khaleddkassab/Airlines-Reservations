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
            $companyBio = $_POST['companyBio'];
            $companyAddress = $_POST['companyAddress'];

            // Update company profile in the database
            $updateQuery = "UPDATE employee SET bio = '$companyBio', address = '$companyAddress' WHERE user_id = $userId"; // Change 'id' to your actual primary key column name
            $updateResult = $con->query($updateQuery);

            if ($updateResult) {
                // Redirect to the profile page after updating
                header("Location: employeeProfile.php?user_id=$userId");
                exit(); // Ensure that subsequent code is not executed after redirection
            } else {
                echo "<p>Error updating profile: " . $con->error . "</p>";
            }
        }

        // Fetch the current company profile data
        $sql = "SELECT * FROM employee WHERE user_id = $userId"; // Change 'id' to your actual primary key column name
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $companyBio = $row['bio'];
            $companyAddress = $row['address'];
        } else {
            // Handle case when no profile data is found
            $companyBio = '';
            $companyAddress = '';
        }

        // Close the database connection
        $con->close();
        ?>

        <h2>Edit Company Profile</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?user_id=$userId"; ?>">
            <label for="companyBio">Bio:</label><br>
            <textarea id="companyBio" name="companyBio"><?php echo $companyBio; ?></textarea><br><br>

            <label for="companyAddress">Address:</label><br>
            <input type="text" id="companyAddress" name="companyAddress" value="<?php echo $companyAddress; ?>"><br><br>

            <input type="submit" value="Save Changes">
        </form>
    </div>
</body>

</html>