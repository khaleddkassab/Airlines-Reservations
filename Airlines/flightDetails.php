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
            if (isset($_GET['flight_id'])) {
                $flightId = $_GET['flight_id'];

                // Retrieve flight details from the database
                $sql = "SELECT * FROM flight WHERE flight_id = $flightId";
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
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['flight_id'])) {
                        // Perform the cancellation logic here
                        $cancelFlightId = $_POST['flight_id'];

                        // Example: Perform a query to cancel the flight (You can replace this with your deletion logic)
                        $cancelSql = "DELETE FROM flight WHERE flight_id = $cancelFlightId";
                        if ($con->query($cancelSql) === TRUE) {
                            echo "<p>Flight canceled successfully.</p>";
                        } else {
                            echo "<p>Error canceling the flight: " . $con->error . "</p>";
                        }
                    }

                    // Form for cancelling and deleting the flight
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='flight_id' value='" . $row['flight_id'] . "'>";
                    echo "<input type='submit' class='cancel-button' value='Cancel Flight'>";
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
