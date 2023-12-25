<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Details</title>
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

        .flight-details {
            margin-bottom: 20px;
        }

        .flight-details h2 {
            margin-bottom: 10px;
        }

        .flight-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .flight-details th,
        .flight-details td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .flight-details th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="flight-details">
            <?php
            // Start the session
            session_start();

            // Check if the user is logged in
            if (!isset($_SESSION['user_id'])) {
                // Redirect to login page or unAuthorized.php
                header("Location: login.php");
                exit(); // Ensure that the script stops execution after redirection
            }

            // Include your database connection file
            require_once('C:\AppServ\www\Airlines\connection.php');

            // Retrieve user ID from the session
            $userId = $_SESSION['user_id'];

            // Retrieve flight ID from the URL
            $flightId = isset($_GET['flight_id']) ? $_GET['flight_id'] : null;

            // Check if the flight ID is provided in the URL
            if (!$flightId) {
                // Redirect to a page indicating that no flight ID is provided
                header("Location: noFlightId.php");
                exit();
            }

            // Retrieve flight details from the database
            $flightSql = "SELECT * FROM flight WHERE flight_id = $flightId";
            $flightResult = $con->query($flightSql);

            // Retrieve user's account balance
            $userSql = "SELECT account_balance FROM passenger WHERE user_id = $userId";
            $userResult = $con->query($userSql);

            if ($flightResult->num_rows > 0 && $userResult->num_rows > 0) {
                $flightRow = $flightResult->fetch_assoc();
                $userRow = $userResult->fetch_assoc();
                $flightFees = $flightRow['fees'];
                $userBalance = $userRow['account_balance'];

                echo "<h2>Flight Details</h2>";
                echo "<table>";
                echo "<tr><th>ID</th><td>" . $flightRow['flight_id'] . "</td></tr>";
                echo "<tr><th>Name</th><td>" . $flightRow['name'] . "</td></tr>";
                echo "<tr><th>Itinerary</th><td>" . $flightRow['itinerary'] . "</td></tr>";
                echo "<tr><th>Departure Time</th><td>" . $flightRow['start_time'] . "</td></tr>";
                echo "<tr><th>Arrival Time</th><td>" . $flightRow['end_time'] . "</td></tr>";
                echo "<tr><th>Fees</th><td>$" . $flightFees . "</td></tr>";
                // Add more attributes as needed
                echo "</table>";

                // Display the Book Flight button
                echo "<form method='post' action='bookingSteps.php'>";
                echo "<input type='hidden' name='flight_id' value='$flightId'>";
                echo "<input type='hidden' name='user_id' value='$userId'>";
                echo "<input type='submit' name='book_flight' value='Book Flight'>";
                echo "</form>";
            } else {
                echo "<p>No flight details available for the provided ID or user not found.</p>";
            }

            // Close the database connection
            $con->close();
            ?>
        </div>
    </div>
</body>

</html>