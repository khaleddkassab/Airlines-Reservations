<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Home</title>
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

        .passenger-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .passenger-info img {
            max-width: 200px;
            height: auto;
        }

        .flight-list {
            margin-bottom: 20px;
        }

        .flight-list h3 {
            margin-bottom: 10px;
        }

        .flight-table {
            width: 100%;
            border-collapse: collapse;
        }

        .flight-table th,
        .flight-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .flight-table th {
            background-color: #f4f4f4;
        }

        .flight-details {
            display: none;
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .flight-details h3 {
            margin-top: 0;
        }

        .show-details {
            cursor: pointer;
            color: blue;
        }

        .logout-btn,
        .profile-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 16px;
            text-decoration: none;
            background-color: #3498db;
            color: #fff;
            border-radius: 5px;
        }

        .logout-btn:hover,
        .profile-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="passenger-info">
            <?php
            // Start the session
            session_start();

            // Include your database connection file
            require_once('C:\AppServ\www\Airlines\connection.php');

            // Retrieve the user ID from the session
            $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

            // Check if the user is not authenticated
            if (!$userId) {
                // Redirect to unAuthorized.php
                header("Location: unAuthorized.php");
                exit(); // Ensure that the script stops execution after redirection
            }

            // Create a link to the passenger profile with the current user ID
// Retrieve passenger information from the database
            $true = "true";
            $null = "null";
            $sql2 = "SELECT * FROM userr WHERE id = $userId"; // Assuming $userId holds the user's ID
            $sqlCurrentFlights = "SELECT flight.*, user_flights.* FROM flight
    INNER JOIN user_flights ON flight.flight_id = user_flights.flight_id
    WHERE user_flights.user_id = $userId AND flight.completed ='$null'";
            $sqlAllFlights = "SELECT * FROM flight";
            $sqlDoneFlights = "SELECT flight.*, user_flights.* FROM flight
    INNER JOIN user_flights ON flight.flight_id = user_flights.flight_id
    WHERE user_flights.user_id = $userId AND flight.completed = '$true'"; // Updated this line
            

            $result2 = $con->query($sql2);
            $resultCurrentFlights = $con->query($sqlCurrentFlights);
            $resultAllFlights = $con->query($sqlAllFlights);
            $resultDoneFlights = $con->query($sqlDoneFlights);

            if ($result2->num_rows > 0) {
                $row = $result2->fetch_assoc();
                // Set user_id in the session
                $_SESSION['user_id'] = $row['id'];
                echo "<h1>Welcome, " . $row['name'] . "</h1>";
                echo "<p>Email: " . $row['email'] . "</p>";
                echo "<p>Tel: " . $row['tel'] . "</p>";
            }

            echo "<div class='flight-list'>";

            // Display Current Flights
            if ($resultCurrentFlights->num_rows > 0) {
                echo "<h3>Current Flights</h3>";
                echo "<table class='flight-table'>";
                while ($row = $resultCurrentFlights->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><a href='flightDetailsPassenger.php?flight_id=" . $row['flight_id'] . "'>" . $row['flight_id'] . "</a></td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No current flights available</p>";
            }

            // Display All Flights
            if ($resultAllFlights->num_rows > 0) {
                echo "<h3>All Flights</h3>";
                echo "<table class='flight-table'>";
                while ($row = $resultAllFlights->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><a href='flightDetailsPassenger.php?flight_id=" . $row['flight_id'] . "'>" . $row['flight_id'] . "</a></td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No flights available</p>";
            }

            // Display Done Flights
            if ($resultDoneFlights->num_rows > 0) {
                echo "<h3>Done Flights</h3>";
                echo "<table class='flight-table'>";
                while ($row = $resultDoneFlights->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><a href='flightDetailsPassenger.php?flight_id=" . $row['flight_id'] . "'>" . $row['flight_id'] . "</a></td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No done flights available</p>";
            }

            echo "</div>";

            // Close the database connection
            $con->close();
            ?>


        </div>



        <!-- Logout and Profile buttons -->
        <a href="logout.php" class="logout-btn">Logout</a>
        <a href="passengerProfile.php" class="profile-btn">Profile</a>
    </div>

    <script>
        // JavaScript to handle displaying flight details
        // ... (Your JavaScript code remains unchanged)
    </script>
</body>

</html>