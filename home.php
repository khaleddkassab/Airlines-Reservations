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

    </style>
</head>

<body>

    <div class="container">

        <header>
            <!-- <img src="images/logo.png<?php echo $employeeLogoPath; ?>" alt="Employee Logo" width="100" height="50">-->
            <a href="#"><b>HOME |</b></a>
            <a href="employeeProfile.php">PROFILE |</a>
            <a href="displaymessage.php">NOTIFICATIONS |</a>
            <a href="createmessage.php">SEND MESSAGE |</a>
            <a href="logout.php">LOGOUT</a>

        </header>
        <div class="company-info">
            <!-- Employee Logo and Name and Welcome Message -->
            <h2>Welcome,
                <?php echo $employeeName; ?>!
            </h2>
        </div>
        <br>
        <h1>Life is short and<br>
            WORLD is wide!</h1>
        <br>
        <br>

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
            row.addEventListener('click', function () {
                const flightId = this.getAttribute('data-flight-id');
                // Fetch flight details using AJAX or update details directly
                // Display flight details in the flight-details section
            });
        });
    </script>
</body>

</html>