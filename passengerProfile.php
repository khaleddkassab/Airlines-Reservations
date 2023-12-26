<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags -->
    <title>Passenger Profile</title>
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

    .passenger-profile {
        text-align: center;
        margin-bottom: 20px;
    }

    .passenger-profile img {
        max-width: 200px;
        height: auto;
    }

    .passenger-info {
        margin-top: 20px;
    }

    .passenger-info ul {
        list-style: none;
        padding: 0;
        text-align: left;
    }

    .passenger-info li {
        margin-bottom: 5px;
    }

    .edit-button {
        text-align: center;
        margin-top: 20px;
    }

    .edit-button a,
    .logout-btn,
    .home-btn {
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 5px;
        color: #fff;
    }

    .edit-button a {
        background-color: #3498db;
    }

    .edit-button a:hover {
        background-color: #2980b9;
    }

    .logout-btn {
        background-color: #e74c3c;
    }

    .logout-btn:hover {
        background-color: #c0392b;
    }

    .home-btn {
        background-color: #27ae60;
    }

    .home-btn:hover {
        background-color: #219d54;
    }
    </style>
</head>

<body>
    <div class="container">
        <?php
// Start the session
session_start();

// Check if the user is not authenticated
if (!isset($_SESSION['user_id'])) {
    // Redirect to unAuthorized.php or login page
    header("Location: unAuthorized.php");
    exit(); // Ensure that the script stops execution after redirection
}

// Include your database connection file
require_once('C:\AppServ\www\Airlines\connection.php');

// Retrieve the user ID from the session
$userId = $_SESSION['user_id'];

// Create a link to the home page
echo "<a href='passengerHome.php' class='home-btn'>Home</a>";

echo "<div class='passenger-profile'>";
// Display the user's profile based on the user ID
$sql = "SELECT * FROM userr WHERE id = $userId";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<img src='path_to_user_image' alt='User Image'>";
        echo "<h2>Name: " . $row['name'] . "</h2>";
    }

    $sql1 = "SELECT * FROM passenger WHERE user_id = $userId";
    $result2 = $con->query($sql1);

    if ($result2->num_rows > 0) {
        echo "<div class='passenger-info'>";
        echo "<h3>Passenger Information</h3>";
        echo "<ul>";
        while ($row = $result2->fetch_assoc()) {
            echo "<li>Photo: " . $row['photo'] . "</li>";
            echo "<li>Account Balance: " . $row['account_balance'] . "</li>";
            echo "<li>Passport Image: " . $row['passport_img'] . "</li>";
            // Display other passenger information as needed
        }
        echo "</ul>";
        echo "</div>";

        // Add an Edit button
        echo "<div class='edit-button'>";
        echo "<a href='editPassengerProfile.php?user_id=$userId'>Edit Profile</a>";
        echo "</div>";
    } else {
        // No passenger profile found for this user
        echo "<p>No passenger profile found.</p>";
    }
} else {
    // No user profile found for the given user ID
    echo "<p>No user profile found.</p>";
}

// Logout button
echo "<a href='logout.php' class='logout-btn'>Logout</a>";

echo "</div>";

// Close the database connection
$con->close();
?>

    </div>
</body>

</html>