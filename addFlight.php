<?php
// Start the session
session_start();

// Include your database connection file
require_once('C:\AppServ\www\Airlines\connection.php');

// Function to go back to the previous page
function goBack()
{
    header("Location: javascript://history.go(-1)");
}

// Function to log out and clear the session
function logout()
{
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location: login.php");
    exit();
}

// Check if the user is logged in and has a user_id and user_type in the session
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id']) || $_SESSION['user_type'] !== 'employee') {
    // Redirect to unAuthorized.php if not authenticated
    header("Location: unAuthorized.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve flight details from the form
    $flightName = $_POST['flight_name'];
    $itinerary = $_POST['itinerary'];
    $fees = $_POST['fees'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];

    // Prepare and execute the SQL query to insert flight details into the database
    $sql = "INSERT INTO Flight (name, itinerary, fees, start_time, end_time)
            VALUES ('$flightName', '$itinerary', '$fees', '$startTime', '$endTime')";

    if ($con->query($sql) === TRUE) {
        // Flight added successfully
        echo "<p>Flight added successfully!</p>";

        // Get the flight_id of the added flight
        $flightId = $con->insert_id;

        // Get the user_id from the session
        $userId = $_SESSION['user_id'];
        $user_type = 'Employee';  // Assuming user_type is set to 'Employee'

        // Insert record into user_flights table
        $insertStatement = $con->prepare("INSERT INTO user_flights (user_id, flight_id, user_type) VALUES (?, ?, ?)");
        $insertStatement->bind_param("iis", $userId, $flightId, $user_type);

        $insertStatement->execute();
        $insertStatement->close();

        echo "<p>Flight associated with the user successfully!</p>";
    } else {
        // Error occurred while adding flight
        echo "<p>Error: " . $sql . "<br>" . $con->error . "</p>";
    }

    // Close the database connection
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Flight</title>
    <style>
        /* Add your styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            position: relative;
        }

        .close-btn,
        .logout-btn {
            background-color: #f44336;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: absolute;
            top: 10px;
        }

        .close-btn {
            right: 10px;
        }

        .logout-btn {
            left: 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .submit-btn {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <button onclick="goBack()" class="close-btn">X</button>
        <h2>Add Flight</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="flight_name">Flight Name:</label>
                <input type="text" id="flight_name" name="flight_name" required>
            </div>
            <div class="form-group">
                <label for="itinerary">Itinerary:</label>
                <input type="text" id="itinerary" name="itinerary" required>
            </div>
            <div class="form-group">
                <label for="fees">Fees:</label>
                <input type="text" id="fees" name="fees" required>
            </div>
            <div class="form-group">
                <label for="start_time">Start Time:</label>
                <input type="datetime-local" id="start_time" name="start_time" required>
            </div>
            <div class="form-group">
                <label for="end_time">End Time:</label>
                <input type="datetime-local" id="end_time" name="end_time" required>
            </div>
            <button type="submit" class="submit-btn">Add Flight</button>
        </form>
    </div>

    <script>
        // JavaScript function to go back to the previous page
        function goBack() {
            window.history.back();
        }

        // JavaScript function to log out and clear the session
        function logout() {
            window.location.href = 'logout.php';
        }
    </script>
</body>

</html>