<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    // Redirect to unAuthorized.php if not logged in
    header("Location: unAuthorized.php");
    exit();
}

// Access user data from the session
$userId = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];

// Check if the user is not authorized
if ($userType !== 'passenger') {
    // Redirect unauthorized users to unAuthorized.php
    header("Location: unAuthorized.php");
    exit();
}

// Include your database connection file
require_once('C:\AppServ\www\Airlines\connection.php');

// Rest of the code remains unchanged
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Home</title>
    <style>
        /* Add your styles here */
        header {

            padding: 15px;
            text-align: center;
            margin-left: 450px;
        }

        /* Styling for the header links */
        header a {
            color: black;
            text-decoration: none;
            margin: 10px;
            margin-left: 10px;
            margin-top: 20px;
        }

        /* Add your styles here */
        body {

            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            background-color: #F0F0F0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1100px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            position: relative;
            background-image: url('images/bg.jpg');
            /* Replace 'path_to_your_image.jpg' with the actual path to your image */
            background-size: cover;
            /* Adjust the background size as needed */
            background-repeat: no-repeat;
            background-position: center;

        }

        .company-info {
            text-align: left;
            margin-bottom: 20px;
        }

        .company-info h2 {
            text-align: center;
            /* Center the text horizontally */
        }

        .company-info img {
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

        .navigation-card {
            width: fit-content;
            height: fit-content;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
            background-color: rgb(255, 255, 255);
            padding: 15px 20px;
            border-radius: 50px;
        }

        .tab {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            overflow: hidden;
            background-color: rgb(252, 252, 252);
            padding: 15px;
            border-radius: 50%;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
        }

        .tab:hover {
            background-color: rgb(223, 223, 223);
        }

        .logout {
            position: absolute;
            top: 10px;
            /* Adjust the top value as needed */
            right: 20px;
            /* Align to the right side */
        }

        .navigation {
            display: flex;
            margin-left: 950px;
            margin-bottom: 20px;
        }

        .navigation a {
            text-decoration: none;
            padding: 15px;
            background-color: black;
            color: #fff;
            border-radius: 90px;
            transition: background-color 0.3s ease;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>

            <a href="#"><b>HOME |</b></a>
            <a href="passengerProfile.php">PROFILE |</a>
            <a href="displaymessage.php">NOTIFICATIONS |</a>
            <a href="createmessage.php">SEND MESSAGE |</a>
            <a href="logout.php">LOGOUT</a>
        </header>
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


            // Display All Flights
            if ($resultAllFlights->num_rows > 0) {
                echo "<h3>All Flights</h3>";

                // Add the search form
                echo "<form method='GET' action=''>";
                echo "<label for='searchFlight'>Search for a Flight:</label>";
                echo "<input type='text' id='searchFlight' name='searchFlight' placeholder='Enter flight ID'>";
                echo "<input type='submit' value='Search'>";
                echo "</form>";

                echo "<table class='flight-table'>";
                while ($row = $resultAllFlights->fetch_assoc()) {
                    // Check if a search query is present
                    $searchQuery = isset($_GET['searchFlight']) ? $_GET['searchFlight'] : '';

                    // Check if the current row matches the search query
                    if (empty($searchQuery) || stripos($row['flight_id'], $searchQuery) !== false) {
                        echo "<tr>";
                        echo "<td><a href='flightDetailsPassenger.php?flight_id=" . $row['flight_id'] . "'>" . $row['flight_id'] . "</a></td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "</tr>";
                    }
                }
                echo "</table>";
            } else {
                echo "<p>No flights available</p>";
            }





            // Close the database connection
            $con->close();
            ?>
        </div>


    </div>

    <script>
        // JavaScript to handle displaying flight details
        // ... (Your JavaScript code remains unchanged)
    </script>
</body>

</html>