<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags -->
    <title>Employee Profile</title>
    <!-- Styles -->
    <style>
        /* Add your styles here */
        /* ... (style your elements as needed) ... */

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

        .company-profile {
            text-align: center;
            margin-bottom: 20px;
        }

        .company-profile img {
            max-width: 200px;
            height: auto;
        }

        .employees-list {
            margin-top: 20px;
        }

        .employees-list ul {
            list-style: none;
            padding: 0;
            text-align: left;
        }

        .employees-list li {
            margin-bottom: 5px;
        }

        .edit-button {
            text-align: center;
            margin-top: 20px;
        }

        .edit-button a {
            padding: 8px 16px;
            text-decoration: none;
            background-color: #3498db;
            color: #fff;
            border-radius: 5px;
            margin-right: 10px;
        }

        .edit-button a:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="company-profile">
            <!-- Company Profile -->
            <!-- Display the user's profile based on the user ID from the session -->
            <?php
            // Start the session
            session_start();

            // Include your database connection file
            require_once('E:\AppServ\www\Airlines\connection.php');

            // Check if the user is authorized
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];

                // Fetch user profile data from the 'userr' table using the $userId
                $sql = "SELECT * FROM userr WHERE id = $userId";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    // Display the user's profile data from 'userr' table
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='company-profile'>";
                        echo "<img src='path_to_user_image' alt='User Image'>";
                        echo "<h2>Name: " . $row['name'] . "</h2>";
                    }

                    // Fetch user profile data from the 'employee' table using the $userId
                    $sql1 = "SELECT * FROM employee WHERE user_id = $userId";
                    $result2 = $con->query($sql1);

                    if ($result2->num_rows > 0) {
                        // Display the user's profile data from 'employee' table
                        while ($row = $result2->fetch_assoc()) {
                            echo "<p>Bio: " . $row['bio'] . "</p>";
                            echo "<p>Address: " . $row['address'] . "</p>";
                            // Display other user information as needed
                        }
                    } else {
                        // No employee profile found for this user
                        echo "<p>No employee profile found.</p>";
                    }

                    // Fetch flights associated with the employee
                    $sqlFlights = "SELECT flight.* FROM flight
                        INNER JOIN user_flights ON flight.flight_id = user_flights.flight_id
                        WHERE user_flights.user_id = $userId";
                    $resultFlights = $con->query($sqlFlights);

                    if ($resultFlights->num_rows > 0) {
                        // Display the list of flights associated with the employee
                        echo "<div class='employees-list'>";
                        echo "<h3>Flights:</h3>";
                        echo "<ul>";
                        while ($flightRow = $resultFlights->fetch_assoc()) {
                            echo "<li>" . $flightRow['name'] . " - " . $flightRow['itinerary'] . "</li>";
                            // Display other flight information as needed
                        }
                        echo "</ul>";
                        echo "</div>";
                    } else {
                        // No flights associated with this employee
                        echo "<p>No flights associated with this employee.</p>";
                    }

                    // Add an Edit button
                    echo "<div class='edit-button'>";
                    echo "<a href='home.php'>Home</a>";
                    echo "<a href='logout.php'>Logout</a>";
                    echo "<a href='editEmployeeProfile.php'>Edit Profile</a>";
                    echo "</div>";
                    echo "</div>";
                } else {
                    // No user profile found for the given user ID
                    echo "<p>No user profile found.</p>";
                }
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