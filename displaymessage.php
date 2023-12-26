<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Messages</title>
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

        .message-table {
            width: 100%;
            border-collapse: collapse;
        }

        .message-table th,
        .message-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .message-table th {
            background-color: #f4f4f4;
        }

        .return-button {
            margin-top: 20px;
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
    </style>
</head>

<body>
    <div class="container">
        <?php
        // Start the session
        session_start();

        // Include your database connection file
        require_once('C:\AppServ\www\Airlines\connection.php');

        // Retrieve user_id and user_type from the session
        $currentId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $userType = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : null;

        if (!$currentId || !$userType) {
            echo "<p>Error: User ID or User Type not found in the session</p>";
        } else {
            // Retrieve sent messages
            $sentMessagesSql = "SELECT * FROM message WHERE from_id = $currentId";
            $sentMessagesResult = $con->query($sentMessagesSql);

            // Retrieve received messages
            $receivedMessagesSql = "SELECT * FROM message WHERE to_id = $currentId";
            $receivedMessagesResult = $con->query($receivedMessagesSql);
        }
        ?>

        <h1>Display Messages</h1>

        <div class="message-list">
            <h3>Sent Messages</h3>
            <?php if ($sentMessagesResult->num_rows > 0): ?>
                <table class="message-table">
                    <tr>
                        <th>Time</th>
                        <th>Message</th>
                        <th>Destination User ID</th>
                    </tr>
                    <?php while ($row = $sentMessagesResult->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php echo $row['time']; ?>
                            </td>
                            <td>
                                <?php echo $row['message']; ?>
                            </td>
                            <td>
                                <?php echo $row['to_id']; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>No sent messages available</p>
            <?php endif; ?>

            <h3>Received Messages</h3>
            <?php if ($receivedMessagesResult->num_rows > 0): ?>
                <table class="message-table">
                    <tr>
                        <th>Time</th>
                        <th>Message</th>
                        <th>Sender User ID</th>
                    </tr>
                    <?php while ($row = $receivedMessagesResult->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php echo $row['time']; ?>
                            </td>
                            <td>
                                <?php echo $row['message']; ?>
                            </td>
                            <td>
                                <?php echo $row['from_id']; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>No received messages available</p>
            <?php endif; ?>

            <!-- Return button based on user type -->
            <div class="return-button">
                <?php
                $returnPage = ($userType === 'employee') ? 'home.php' : 'passengerHome.php';
                ?>
                <a href="<?php echo $returnPage; ?>"><input type="submit" value="Return to Home"></a>
            </div>
        </div>
    </div>
</body>

</html>