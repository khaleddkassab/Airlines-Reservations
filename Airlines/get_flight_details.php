<?php
// get_flight_details.php

// Include your database connection file
require_once('C:\AppServ\www\project1\connection.php');

// Check if flight_id is sent via GET request
if (isset($_GET['flight_id'])) {
    $flight_id = $_GET['flight_id'];

    // Fetch flight details from the database based on the flight_id
    $sql = "SELECT * FROM flights WHERE flight_id = $flight_id";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        // Flight found, return details as JSON response
        $flightData = $result->fetch_assoc();
        echo json_encode($flightData);
    } else {
        // No flight found for the given ID
        echo json_encode(array('error' => 'Flight not found'));
    }
} else {
    // If flight_id is not provided in the request
    echo json_encode(array('error' => 'Flight ID not provided'));
}

// Close the database connection
$con->close();
?>
