<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
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

        .message-list {
            margin-top: 20px;
        }

        .message-list ul {
            list-style: none;
            padding: 0;
            text-align: left;
        }

        .message-list li {
            margin-bottom: 10px;
        }

        .back-button {
            text-align: center;
            margin-top: 20px;
        }

        .back-button a {
            padding: 8px 16px;
            text-decoration: none;
            background-color: #3498db;
            color: #fff;
            border-radius: 5px;
        }

        .back-button a:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="message-list">
            <h2>Messages</h2>
            <!-- Display messages based on the user and flight -->
            <?php
            // Start the session
            session_start();

            // Include your database connection file
            require_once('E:\AppServ\www\Airlines\connection.php');

            // Check if the user is authorized
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];

                // Fetch messages associated with the user
                $sql = "SELECT * FROM messages WHERE user_id = $userId";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    echo "<div class='message-list'>";
                    echo "<ul>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<li><strong>Flight ID:</strong> " . $row['flight_id'] . " - <strong>Message:</strong> " . $row['content'] . " - <strong>Timestamp:</strong> " . $row['timestamp'] . "</li>";
                    }
                    echo "</ul>";
                    echo "</div>";
                } else {
                    echo "<p>No messages found for this user.</p>";
                }

                // Add a back button
                echo "<div class='back-button'>";
                echo "<a href='home.php'>Back to Home</a>";
                echo "</div>";
            } else {
                // User is not authorized
                echo "<p>You are not authorized to view this page. Please log in.</p>";
            }

            // Close the database connection
            $con->close();
            ?>
        </div>
    </div>
</body>

</html>