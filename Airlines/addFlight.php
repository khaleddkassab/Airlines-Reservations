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
                <label for="passenger_count">Passenger Count:</label>
                <input type="number" id="passenger_count" name="passenger_count" required>
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
        
        <?php
        // Include your database connection file
        require_once('C:\AppServ\www\project1\connection.php');

        // Check if the form is submitted
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
            } else {
                // Error occurred while adding flight
                echo "<p>Error: " . $sql . "<br>" . $con->error . "</p>";
            }

            // Close the database connection
            $con->close();
        }
        ?>
         <a href="home.php" class="home-btn">Home</a>
    </div>

</body>
</html>
