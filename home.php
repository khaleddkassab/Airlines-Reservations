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

        .company-info {
            text-align: center;
            margin-bottom: 20px;
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
    </style>
</head>

<body>
    <div class="container">
        <div class="logout">
            <h3><a href="logout.php">Logout</a></h3>
        </div>

        <div class="company-info">
            <!-- Employee Logo and Name and Welcome Message -->
            <img src="<?php echo $employeeLogoPath; ?>" alt="Employee Logo">
            <h2>Welcome,
                <?php echo $employeeName; ?>!
            </h2>
        </div>

        <h3><a href="employeeProfile.php">Profile</a></h3>
        <h3><a href="addFlight.php">Add Flight</a></h3>
        <h3><a href="displaymessage.php">View Messages</a></h3>
        <h3><a href="createmessage.php">Compose Message</a></h3>

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