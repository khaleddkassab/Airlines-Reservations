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
        background-image: url('images/bg.jpg');
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
        <header>

            <a href="passengerHome.php"><b>HOME |</b></a>
            <a href="passengerProfile.php">PROFILE |</a>
            <a href="editPassengerProfile.php">EDIT PROFILE |</a>
            <a href="logout.php">LOGOUT</a>
        </header>
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



        echo "<div class='passenger-profile'>";
        // Display the user's profile based on the user ID
        $sql = "SELECT * FROM userr WHERE id = $userId";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<img src='' alt='User Image'>";
                echo "<h2>Name: " . $row['name'] . "</h2>";
            }

            $sql1 = "SELECT * FROM passenger WHERE user_id = $userId";
            $result2 = $con->query($sql1);

            if ($result2->num_rows > 0) {
                echo "<div class='passenger-info'>";
                echo "<h3>Passenger Information</h3>";
                echo "<ul>";
                while ($row = $result2->fetch_assoc()) {
                    echo "<div class='additional-info'>";
                    echo "<li>Photo: " . $row['photo'] . "</li>";
                    echo "<li>Account Balance: " . $row['account_balance'] . "</li>";
                    echo "<li>Passport Image: " . $row['passport_img'] . "</li>";
                    echo "</div>";
                    // Display other passenger information as needed
                }

                echo "</ul>";
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
        

        echo "</div>";

        // Close the database connection
        $con->close();
        ?>

    </div>
</body>

</html>