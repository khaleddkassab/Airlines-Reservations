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

        .flight-details th, .flight-details td {
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
            // Include your database connection file
            require_once('C:\AppServ\www\project1\connection.php');

            // Check if the flight ID is provided in the URL
            if (isset($_GET['flight_id']) && isset($_GET['user_id'])) {
                $flightId = $_GET['flight_id'];
                $userId = $_GET['user_id'];

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
                    echo "<tr><th>Fees</th><td>$" . $flightFees . "</td></tr>";
                    // Add more attributes as needed
                    echo "</table>";

                    // Display the Book Flight button
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='flight_id' value='$flightId'>";
                    echo "<input type='hidden' name='user_id' value='$userId'>";
                    echo "<input type='submit' name='book_flight' value='Book Flight'>";
                    echo "</form>";

                    // Check if the Book Flight button is clicked
                    if (isset($_POST['book_flight'])) {
                        if ($userBalance >= $flightFees) {
                            $newBalance = $userBalance - $flightFees;

                            // Update passenger's account balance
                            $deductFeesSql = "UPDATE passenger SET account_balance = $newBalance WHERE user_id = $userId";
                            if ($con->query($deductFeesSql) === TRUE) {

                                // Increase the number of registered passengers in the flights table
                                $registeredPassengers = $flightRow['registered_passengers'] + 1;
                                $updateFlightSql = "UPDATE flight SET registered_passengers = $registeredPassengers WHERE flight_id = $flightId";
                                $con->query($updateFlightSql);

                                // Create a new record in the users_flights table
                                $insertUserFlightSql = "INSERT INTO user_flights (user_id, flight_id, user_type) VALUES ($userId, $flightId, 'passenger')";
                                if ($con->query($insertUserFlightSql) === TRUE) {
                                    echo "<p>Flight booked successfully. Amount deducted from account balance. Passenger registered for the flight.</p>";
                                } else {
                                    echo "<p>Error booking flight: " . $con->error . "</p>";
                                }
                            } else {
                                echo "<p>Error booking flight: " . $con->error . "</p>";
                            }
                        } else {
                            echo "<p>Insufficient balance to book this flight.</p>";
                        }
                    }
                } else {
                    echo "<p>No flight details available for the provided ID or user not found.</p>";
                }
            } else {
                echo "<p>No flight ID or user ID provided.</p>";
            }

            // Close the database connection
            $con->close();
            ?>
        </div>
    </div>
</body>
</html>
