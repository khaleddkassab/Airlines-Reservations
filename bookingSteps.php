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

    .wallet {
        --bg-color: #ceb2fc;
        --bg-color-light: #f0e7ff;
        --text-color-hover: #fff;
        --box-shadow-color: rgba(206, 178, 252, 0.48);
    }

    .card {
        width: 220px;
        height: 321px;
        background: #fff;
        border-top-right-radius: 10px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
        box-shadow: 0 14px 26px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease-out;
        text-decoration: none;
    }

    .card:hover {
        transform: translateY(-5px) scale(1.005) translateZ(0);
        box-shadow: 0 24px 36px rgba(0, 0, 0, 0.11),
            0 24px 46px var(--box-shadow-color);
    }

    .card:hover .overlay {
        transform: scale(4) translateZ(0);
    }

    .card:hover .circle {
        border-color: var(--bg-color-light);
        background: var(--bg-color);
    }

    .card:hover .circle:after {
        background: var(--bg-color-light);
    }

    .card:hover p {
        color: var(--text-color-hover);
    }

    .card p {
        font-size: 17px;
        color: #4c5656;
        margin-top: 30px;
        z-index: 1000;
        transition: color 0.3s ease-out;
    }

    .circle {
        width: 131px;
        height: 131px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid var(--bg-color);
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        z-index: 1;
        transition: all 0.3s ease-out;
    }

    .circle:after {
        content: "";
        width: 118px;
        height: 118px;
        display: block;
        position: absolute;
        background: var(--bg-color);
        border-radius: 50%;
        top: 7px;
        left: 7px;
        transition: opacity 0.3s ease-out;
    }

    .circle svg {
        z-index: 10000;
        transform: translateZ(0);
    }

    .overlay {
        width: 118px;
        position: absolute;
        height: 118px;
        border-radius: 50%;
        background: var(--bg-color);
        top: 70px;
        left: 50px;
        z-index: 0;
        transition: transform 0.3s ease-out;
    }

    input[type='submit'] {
        background-color: black;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    /* Style for when the button is hovered over */
    input[type='submit']:hover {
        background-color: #005f75;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="booking-steps">
            <?php
            // Include your database connection file
            require_once('C:\AppServ\www\Airlines\connection.php');

            // Retrieve flight ID and user ID from the form data
            $flightId = isset($_POST['flight_id']) ? $_POST['flight_id'] : null;
            $userId = isset($_POST['user_id']) ? $_POST['user_id'] : null;

            // Check if the flight ID and user ID are provided
            if (!$flightId || !$userId) {
                // Redirect to a page indicating that no flight ID or user ID is provided
                header("Location: noFlightIdOrUserId.php");
                exit();
            }

            // Check if the user has already booked this flight
            $checkBookingSql = "SELECT * FROM user_flights WHERE user_id = $userId AND flight_id = $flightId";
            $checkBookingResult = $con->query($checkBookingSql);

            if ($checkBookingResult->num_rows > 0) {
                echo "<p>You have already booked this flight.</p>";
            } else {
                // Display payment options
                echo "<h2>Payment Options</h2>";
                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='flight_id' value='$flightId'>";
                echo "<input type='hidden' name='user_id' value='$userId'>";
                echo "<input type='submit' name='pay_cash' value='Pay with Cash'>";
                echo "<input type='submit' name='pay_visa' value='Pay with Visa'>";
                echo "<a href='passengerHome.php'><button type='button'>X</button></a>";
                echo "</form>";

                // Check if payment button is clicked
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['pay_cash'])) {
                        // Determine user_type based on the user's account balance and employee status
                        $userType = 'Passenger'; // Default to Passenger
            
                        // Check if the user is an employee based on additional criteria (you may need to adjust this based on your database structure)
                        $checkEmployeeSql = "SELECT * FROM employee WHERE user_id = $userId";
                        $checkEmployeeResult = $con->query($checkEmployeeSql);

                        if ($checkEmployeeResult->num_rows > 0) {
                            $userType = 'Employee';
                        }

                        // Determine payment_type based on the button clicked
                        $paymentType = 'Cash';

                        // Update pending_passengers in the flights table
                        $updatePendingPassengersSql = "UPDATE flight SET pending_passengers = pending_passengers + 1 WHERE flight_id = $flightId";
                        $con->query($updatePendingPassengersSql);

                        // Add the flight to user_flights
                        $addUserFlightSql = "INSERT INTO user_flights (user_id, flight_id, user_type, payment_type) VALUES ($userId, $flightId, '$userType', '$paymentType')";
                        $con->query($addUserFlightSql);

                        echo "<p>Booking successful. Payment with $paymentType processed.</p>";
                    } elseif (isset($_POST['pay_visa'])) {
                        // Determine user_type based on the user's account balance and employee status
                        $userType = 'Passenger'; // Default to Passenger
            
                        // Check if the user is an employee based on additional criteria (you may need to adjust this based on your database structure)
                        $checkEmployeeSql = "SELECT * FROM employee WHERE user_id = $userId";
                        $checkEmployeeResult = $con->query($checkEmployeeSql);

                        if ($checkEmployeeResult->num_rows > 0) {
                            $userType = 'Employee';
                        }

                        // Determine payment_type based on the button clicked
                        $paymentType = 'Visa';
                        $Employee = 'Employee';

                        // Update user_account_balance if payment is made with Visa
                        $flightSql = "SELECT fees FROM flight WHERE flight_id = $flightId";
                        $flightResult = $con->query($flightSql);

                        if ($flightResult->num_rows > 0) {
                            $flightRow = $flightResult->fetch_assoc();
                            $flightFees = $flightRow['fees'];

                            // Deduct fees from passenger's account balance
                            $deductFeesSql = "UPDATE passenger SET account_balance = account_balance - $flightFees WHERE user_id = $userId";
                            $con->query($deductFeesSql);
                            $companyDeductSql = "UPDATE employee 
                            SET account_balance = account_balance + $flightFees 
                            WHERE user_id IN (SELECT user_id FROM user_flights 
                                              WHERE flight_id =  $flightId
                                              AND user_type = '$Employee' 
                                              AND payment_type IS NULL)";
                            $con->query($companyDeductSql);

                        } else {
                            echo "<p>Error retrieving flight details: " . $con->error . "</p>";
                        }

                        // Increase registered_passengers in the flights table
                        $updateRegisteredPassengersSql = "UPDATE flight SET registered_passengers = registered_passengers + 1 WHERE flight_id = $flightId";
                        $con->query($updateRegisteredPassengersSql);

                        // Add the flight to user_flights
                        $addUserFlightSql = "INSERT INTO user_flights (user_id, flight_id, user_type, payment_type) VALUES ($userId, $flightId, '$userType', '$paymentType')";
                        $con->query($addUserFlightSql);

                        echo "<p>Booking successful. Payment with $paymentType processed.</p>";
                    }
                }
            }

            // Close the database connection
            $con->close();
            ?>
        </div>
    </div>
</body>

</html>