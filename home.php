<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Access user data from the session
$userId = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];

// Check if the user is authorized (you may modify this condition based on your authorization logic)
if ($userType !== 'employee') {
    // Redirect unauthorized users to unAuthorized.php
    header("Location: unAuthorized.php");
    exit();
}

// Include your database connection file
require_once('C:\AppServ\www\Airlines\connection.php');

// Retrieve employee name and logo from the database
$employeeInfoSql = "SELECT name FROM userr WHERE id = $userId";
$employeeInfoResult = $con->query($employeeInfoSql);

// Check if the query was successful
if ($employeeInfoResult->num_rows > 0) {
    $employeeInfoRow = $employeeInfoResult->fetch_assoc();
    $employeeName = $employeeInfoRow['name'];
    $employeeLogoPath = $employeeInfoRow['logo_path'];
} else {
    // Fallback to a default name and logo path if not found
    $employeeName = "Employee";
    $employeeLogoPath = "default_logo_path.jpg";
}

// Retrieve flights from the user_flights table based on user ID
$sql = "SELECT flight.* FROM flight
        INNER JOIN user_flights ON flight.flight_id = user_flights.flight_id
        WHERE user_flights.user_id = $userId";
$result = $con->query($sql);

// Close the database connection

?>

<!DOCTYPE html>
<html lang="en">

<!-- Rest of the HTML remains unchanged -->

</html>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Home</title>
    <link rel="stylesheet" href="styles.css">
    <style>
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


    .container {
        max-width: 1100px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: white;
    }

    .flight-list {
        max-width: 1000px;
        margin: 20px auto;
        padding: 0px;
        border-radius: 5px;
        background-color: #F0F0F0;
    }

    .header-container {
        position: relative;
    }

    .header-container img {
        width: 100%;
        height: auto;
        display: block;
    }

    .header-container h1 {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-image: url('plane.jpg');
        background-size: cover;
        color: black;
        /* Hide the text to reveal the background image */
        -webkit-background-clip: text;
        /* Clip the background image to the text */
        background-clip: text;
        text-align: center;
        font-size: 40px;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <!--<img src="logoo.jpeg<?php echo $employeeLogoPath; ?>" alt="Employee Logo" width="100" height="50">-->
    <div class="container">

        <div class="header">

            <a href="#"><b>HOME |</b></a>
            <a href="employeeProfile.php">PROFILE |</a>
            <a href="displaymessage.php">NOTIFICATIONS |</a>
            <a href="createmessage.php">SEND MESSAGE |</a>
            <a href="logout.php">LOGOUT</a>

        </div>
        <div class="company-info">
            <!-- Employee Logo and Name and Welcome Message -->

            <h2>Welcome,
                <?php echo $employeeName; ?>!
            </h2>
        </div>

        <h1>Life is short and<br> WORLD is wide!</h1>
        <div class="header-container">

            <img src="plane.jpg" alt="Employee Logo" width="1100" height="300">

        </div>

        <div class="navigation">
            <h3><a href="addFlight.php">Add Flight</a></h3>
        </div>
        <div class="flight-list">
            <!-- Flight list table -->
            <table class="flight-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Retrieve flights from the user_flights table based on user ID
                    $sql = "SELECT flight.* FROM flight
                            INNER JOIN user_flights ON flight.flight_id = user_flights.flight_id
                            WHERE user_flights.user_id = $userId";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><a href='flightDetails.php?flight_id=" . $row['flight_id'] . "'>" . $row['flight_id'] . "</a></td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No flights available</td></tr>";
                    }
                    // Close the database connection
                    $con->close();
                    ?>
                </tbody>
            </table>
        </div>

        <div class="flight-details">
            <!-- Flight details section (will be displayed when a row is clicked) -->
        </div>
    </div>

    <script>
    // JavaScript to handle displaying flight details
    const showDetails = document.querySelectorAll('.show-details');
    showDetails.forEach(row => {
        row.addEventListener('click', function() {
            const flightId = this.getAttribute('data-flight-id');
            // Fetch flight details using AJAX or update details directly
            // Display flight details in the flight-details section
        });
    });
    </script>
</body>

</html>