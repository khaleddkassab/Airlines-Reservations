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
        margin-bottom: 50px;
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
        background-color: black;
        color: #fff;
        border-radius: 5px;
        margin-right: 10px;
    }

    .edit-button a:hover {
        background-color: #fff;
        color: black;
    }

    .company-profile {
        text-align: left;
        margin-bottom: 20px;
    }

    .company-profile img {
        max-width: 200px;
        height: 100px;
        border-radius: 10px;
        /* Apply border-radius for square corners */
        display: block;
        margin: 10px auto;
        /* Center the image horizontally with margin */
    }

    .header {
        background-color: #f2f2f2;
        color: black;
        padding: 30px;
        text-align: right;
        /* Align text to the right */
    }

    .header a {
        color: black;
        /* Set text color to black */
        text-decoration: none;
        /* Remove underline from links */
        margin-left: 10px;
        /* Add some space between links */
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
            require_once('C:\AppServ\www\Airlines\connection.php');
         
            // Check if the user is authorized
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];

                // Fetch user profile data from the 'userr' table using the $userId
                $sql = "SELECT * FROM userr WHERE id = $userId";
                $result = $con->query($sql);
                 // Add an Edit button
          echo "<div class='header'>";
          echo "<a href='home.php'><b>Home |</a>";
          echo "<a href='logout.php'><b>Logout |</a>";
          echo "<a href='editEmployeeProfile.php?user_id=$userId'>Edit Profile</a>";
          echo "</div>";
          echo "</div>";

                if ($result->num_rows > 0) {
                    // Display the user's profile data from 'userr' table
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='company-profile'>";
                        echo "<img src='EgyptAir-Logo.jpg' alt='User Image'>";
                        echo "<h3>Name: " . $row['name'] . "</h3>";
                        echo "UserName: " . $row['username'] . "<br>";
                        echo "Tel: " . $row['tel'] . "<br>";
                        echo "Email: " . $row['email'] . "<br>";


                    }

                    // Fetch user profile data from the 'employee' table using the $userId
                    $sql1 = "SELECT * FROM employee WHERE user_id = $userId";
                    $result2 = $con->query($sql1);

                    if ($result2->num_rows > 0) {
                        // Display the user's profile data from 'employee' table
                        while ($row = $result2->fetch_assoc()) {
                            echo "<p>Bio: " . $row['bio'] . "</p>";
                            echo "<p>Address: " . $row['address'] . "</p>";
                            echo "<p>Account_balance:" . $row['account_balance'] . "</p>";
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
                        echo "<h1>All Flights:</h1>";
                      
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