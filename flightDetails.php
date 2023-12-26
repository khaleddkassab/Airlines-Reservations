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

        .cancel-button,
        .complete-button {
            background-color: #ff0000;
            color: #fff;
            padding: 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="flight-details">
            <?php
            // Include your database connection file
            require_once('C:\AppServ\www\Airlines\connection.php');
            $True = 'true';

            $cancelSql = ""; // Define the variable outside the conditional block
            $completeSql = ""; // Define the variable outside the conditional block
            
            // Check if the flight ID is provided in the URL
            if (isset($_GET['flight_id'])) {
                $flightId = $_GET['flight_id'];

                // Retrieve flight details from the database
                $sql = "SELECT * FROM flight WHERE flight_id = $flightId ";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<h2>Flight Details</h2>";
                    echo "<table>";
                    echo "<tr><th>ID</th><td>" . $row['flight_id'] . "</td></tr>";
                    echo "<tr><th>Name</th><td>" . $row['name'] . "</td></tr>";
                    echo "<tr><th>Itinerary</th><td>" . $row['itinerary'] . "</td></tr>";
                    echo "<tr><th>Registered passengers</th><td>" . $row['registered_passengers'] . "</td></tr>";
                    echo "<tr><th>Pending passengers</th><td>" . $row['pending_passengers'] . "</td></tr>";
                    // Add more attributes as needed
                    echo "</table>";

                    // Check if the cancellation form has been submitted
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_flight'])) {
                        // Perform the cancellation logic here
                        $cancelFlightId = $_POST['flight_id'];
                        $Employee = 'Employee';
                        $Passenger = 'Passenger';

                        // Fetch flight fees for refund and company deduction
                        $flightFeesSql = "SELECT fees FROM flight WHERE flight_id = $cancelFlightId";
                        $flightFeesResult = $con->query($flightFeesSql);

                        if ($flightFeesResult->num_rows > 0) {
                            $flightFeesRow = $flightFeesResult->fetch_assoc();
                            $flightFees = $flightFeesRow['fees'];

                            // Refund the users with payment_type = Visa and user_type = Passenger
                            $refundSql = "SELECT user_id FROM user_flights WHERE flight_id =$cancelFlightId AND payment_type = 'VISA' AND user_type = 'Passenger'";
                            $refundResult = $con->query($refundSql);

                            while ($refundRow = $refundResult->fetch_assoc()) {
                                $userId = $refundRow['user_id'];

                                // Refund flight fees to user's account_balance
                                $refundUserSql = "UPDATE passenger SET account_balance = account_balance + $flightFees WHERE user_id = $userId";
                                $con->query($refundUserSql);
                            }

                            // Deduct refunded fees from the company's account_balance
                            $companyDeductSql = "UPDATE employee 
                            SET account_balance = account_balance - ($flightFees * 
                                (SELECT COUNT(*) FROM user_flights 
                                 WHERE flight_id = $cancelFlightId 
                                   AND user_type = 'Passenger' 
                                   AND payment_type ='VISA'))
                            WHERE user_id IN (SELECT user_id FROM user_flights 
                                              WHERE flight_id = $cancelFlightId 
                                                AND user_type = '$Employee' 
                                                AND payment_type IS NULL)";

                            // Example: Perform a query to cancel the flight (You can replace this with your deletion logic)
                            $cancelSql = "DELETE FROM user_flights WHERE flight_id = $cancelFlightId";
                            $cancelSql2 = "DELETE FROM flight WHERE flight_id = $cancelFlightId";
                            $con->query($companyDeductSql);

                            if ($con->query($cancelSql) === TRUE && $con->query($cancelSql2) === TRUE) {
                                // Execute the deduction statements and cancellation statements here
            
                                echo "<p>Flight canceled successfully. Refunds processed.</p>";
                            } else {
                                echo "<p>Error canceling the flight: " . $con->error . "</p>";
                            }
                        } else {
                            echo "<p>Error retrieving flight fees: " . $con->error . "</p>";
                        }
                    }

                    // Form for cancelling the flight
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='flight_id' value='" . $row['flight_id'] . "'>";
                    echo "<input type='submit' class='cancel-button' name='cancel_flight' value='Cancel Flight'>";
                    echo "</form>";

                    // Check if the complete form has been submitted
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['complete_flight'])) {
                        // Perform the completion logic here
                        $completeFlightId = $_POST['flight_id'];

                        // Example: Perform a query to update the flight as completed
                        $completeSql = "UPDATE flight SET completed = true WHERE flight_id = $completeFlightId";

                        if ($con->query($completeSql) === TRUE) {
                            echo "<p>Flight marked as completed.</p>";
                        } else {
                            echo "<p>Error marking the flight as completed: " . $con->error . "</p>";
                        }
                    }

                    // Form for completing the flight
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='flight_id' value='" . $row['flight_id'] . "'>";
                    echo "<input type='submit' class='complete-button' name='complete_flight' value='Complete Flight'>";
                    echo "</form>";
                } else {
                    echo "<p>No flight details available for the provided ID.</p>";
                }
            } else {
                echo "<p>No flight ID provided.</p>";
            }

            // Close the database connection
            $con->close();
            ?>
        </div>
    </div>
</body>

</html>