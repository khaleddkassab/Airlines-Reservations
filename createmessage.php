<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Message</title>
    <style>
        /* Add your styles here */
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

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 8px 16px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .return-button {
            margin-top: 20px;
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
        $userType = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : null;

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get values from the form
            $destinationUserId = $_POST['destination_user_id'];
            $messageContent = $_POST['message_content'];

            // Retrieve user_id and user_type from the session
            $currentId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
            $userType = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : null;

            if (!$currentId || !$userType || $userType == null) {
                echo "<p>Error: User ID or User Type not found in the session</p>";
            } else {
                // Insert into the message table
                $insertSql = "INSERT INTO message (time, message, from_id, to_id) 
                              VALUES (NOW(), '$messageContent', $currentId, $destinationUserId)";

                if ($con->query($insertSql) === TRUE) {
                    echo "<p>Message created successfully</p>";
                } else {
                    echo "<p>Error creating message: " . $con->error . "</p>";
                }
            }

            // Close the database connection
            $con->close();
        }
        ?>
        <div class="return-button">
            <?php
            $returnPage = ($userType === 'passenger') ? 'passengerHome.php' : 'home.php';
            ?>
            <a href="<?php echo $returnPage; ?>"><button type="button">Return to Home</button></a>
        </div>

        <h1>Create Message</h1>
        <form method="post" action="">
            <label for="destination_user_id">Destination User ID:</label>
            <input type="text" id="destination_user_id" name="destination_user_id" required>

            <label for="message_content">Message Content:</label>
            <textarea id="message_content" name="message_content" rows="4" required></textarea>

            <input type="submit" value="Send Message">
        </form>
    </div>
</body>

</html>