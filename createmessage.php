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

        input[type="submit"] {
            padding: 8px 16px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
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
            <a href="<?php echo $returnPage; ?>"><input type="submit" value="Return to Home"></button></a>
        </div>

        <h1>Create Message</h1>
        <form method="post" action="" onsubmit="return validateForm()">
            <label for="destination_user_id">Destination User ID:</label>
            <input type="text" id="destination_user_id" name="destination_user_id" required>

            <label for="message_content">Message Content:</label>
            <textarea id="message_content" name="message_content" rows="4" required></textarea>

            <input type="submit" value="Send Message">
        </form>

        <script>
            function validateForm() {
                // Validate that the message content has at least one character
                var messageContent = document.getElementById('message_content').value;
                if (messageContent.trim().length === 0) {
                    alert('Please enter at least one character in the message content.');
                    return false;
                }

                // Validate that the destination user ID is a valid integer
                var destinationUserId = document.getElementById('destination_user_id').value;
                if (isNaN(destinationUserId) || destinationUserId.indexOf('.') !== -1) {
                    alert('Please enter a valid integer for the destination user ID.');
                    return false;
                }

                return true;
            }
        </script>
    </div>
</body>

</html>