<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags -->
    <title>Passenger Profile</title>
    <!-- Styles -->
    <style>
        header {

            padding: 15px;
            text-align: center;
            margin-left: 450px;
        }

        /* Styling for the header links */
        header a {
            color: black;
            text-decoration: none;
            margin: 10px;
            margin-left: 10px;
            margin-top: 20px;
        }

        /* Add your styles here */
        body {

            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            background-color: #F0F0F0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1100px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            position: relative;
            /* Replace 'path_to_your_image.jpg' with the actual path to your image */
            background-size: cover;
            /* Adjust the background size as needed */
            background-repeat: no-repeat;
            background-position: center;

        }

        .company-info {
            text-align: left;
            margin-bottom: 20px;
        }

        .company-info h2 {
            text-align: center;
            /* Center the text horizontally */
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

        .logout {
            position: absolute;
            top: 10px;
            /* Adjust the top value as needed */
            right: 20px;
            /* Align to the right side */
        }

        .navigation {
            display: flex;
            margin-left: 950px;
            margin-bottom: 20px;
        }

        .navigation a {
            text-decoration: none;
            padding: 15px;
            background-color: black;
            color: #fff;
            border-radius: 90px;
            transition: background-color 0.3s ease;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        // Start the session
        session_start();

        // Include your database connection file
        require_once('C:\AppServ\www\Airlines\connection.php');

        // Retrieve the user ID from the session
        $userId = $_SESSION['user_id'];
        ?>

        <header>
            <a href="passengerHome.php"><b>HOME |</b></a>
            <a href="passengerProfile.php">PROFILE |</a>
            <a href="editPassengerProfile.php?user_id=<?php echo $userId; ?>">EDIT PROFILE |</a>
            <a href="logout.php">LOGOUT</a>
        </header>
        <?php
        // Display the user's profile based on the user ID
        $sqlUser = "SELECT * FROM userr WHERE id = $userId";
        $resultUser = $con->query($sqlUser);

        // Display the account_balance from the passenger table
        $sqlPassenger = "SELECT * FROM passenger WHERE user_id = $userId";
        $resultPassenger = $con->query($sqlPassenger);
        echo "<img src='omar.jpg' alt= 'User Image' style='width: 200px;'>";
        if ($resultUser && $resultUser->num_rows > 0) {
            while ($rowUser = $resultUser->fetch_assoc()) {
                echo "<h2>Name: " . $rowUser['name'] . "</h2>";
                echo "<div class='additional-info'>";
                echo "<li>UserName: " . $rowUser['username'] . "</li>";
                echo "<li>E-mail: " . $rowUser['email'] . "</li>";
                echo "<li>Telephone: " . $rowUser['tel'] . "</li>";
                // Display account_balance if available
                if ($resultPassenger && $resultPassenger->num_rows > 0) {
                    $rowPassenger = $resultPassenger->fetch_assoc();
                    echo "<li>Account Balance: $" . $rowPassenger['account_balance'] . "</li>";
                } else {
                    echo "<li>Account Balance: N/A</li>";
                }
                echo "</div>";
            }
        } else {
            echo "<p>No user profile found.</p>";
        }

        // Close the database connection
        $con->close();
        ?>

    </div>
</body>

</html>