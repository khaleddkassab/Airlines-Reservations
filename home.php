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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Home</title>
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
            <a href="logout.php">Logout</a>
        </div>
        <div class="company-info">
            <!-- Company Logo and Name -->
            <img src="path_to_your_logo" alt="Company Logo">
            <h2>Company Name</h2>
        </div>

        <div class="navigation-card">
            <a href="addFlight.php" class="tab">
                <svg class="svgIcon" viewBox="0 0 104 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100.5 40.75V96.5H66V68.5V65H62.5H43H39.5V68.5V96.5H3.5V40.75L52 4.375L100.5 40.75Z"
                        stroke="black" stroke-width="7"></path>
                </svg>
            </a>

            <a href='employeeProfile.php' class="tab">
                <svg width="104" height="100" viewBox="0 0 104 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="21.5" y="3.5" width="60" height="60" rx="30" stroke="black" stroke-width="7"></rect>
                    <g clip-path="url(#clip0_41_27)">
                        <mask id="mask0_41_27" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="61"
                            width="104" height="52">
                            <path d="M0 113C0 84.2812 23.4071 61 52.1259 61C80.706 61 104 84.4199 104 113H0Z"
                                fill="white"></path>
                        </mask>
                        <g mask="url(#mask0_41_27)">
                            <path
                                d="M-7 113C-7 80.4152 19.4152 54 52 54H52.2512C84.6973 54 111 80.3027 111 112.749H97C97 88.0347 76.9653 68 52.2512 68H52C27.1472 68 7 88.1472 7 113H-7ZM-7 113C-7 80.4152 19.4152 54 52 54V68C27.1472 68 7 88.1472 7 113H-7ZM52.2512 54C84.6973 54 111 80.3027 111 112.749V113H97V112.749C97 88.0347 76.9653 68 52.2512 68V54Z"
                                fill="black"></path>
                        </g>
                    </g>
                    <defs>
                        <clipPath id="clip0_41_27">
                            <rect width="104" height="39" fill="white" transform="translate(0 61)"></rect>
                        </clipPath>
                    </defs>
                </svg>
            </a>

            <a href="message.php" class="tab">
                <svg width="101" height="114" viewBox="0 0 101 114" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="46.1726" cy="46.1727" r="29.5497" transform="rotate(36.0692 46.1726 46.1727)"
                        stroke="black" stroke-width="7"></circle>
                    <line x1="61.7089" y1="67.7837" x2="97.7088" y2="111.784" stroke="black" stroke-width="7"></line>
                </svg>
            </a>
        </div>

        <h3><a href="addFlight.php">Add Flight</a></h3>

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
                    // Include your database connection file
                    require_once('C:\AppServ\www\Airlines\connection.php');

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