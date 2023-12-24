
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags -->
    <title>Employee Profile</title>
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

        .company-profile {
            text-align: center;
            margin-bottom: 20px;
        }

        .company-profile img {
            max-width: 200px;
            height: auto;
        }

        .employees-list {
            margin-top: 20px;
        }

        .employees-list ul {
            list-style: none;
            padding: 0;
            text-align: left;
        }

        .employees-list li {
            margin-bottom: 5px;
        }

        .edit-button {
            text-align: center;
            margin-top: 20px;
        }

        .edit-button a {
            padding: 8px 16px;
            text-decoration: none;
            background-color: #3498db;
            color: #fff;
            border-radius: 5px;
        }

        .edit-button a:hover {
            background-color: #2980b9;
        }
    
    </style>
</head>
<body>
    <div class="container">
        <div class="company-profile">
            <!-- Company Profile -->
            <!-- Display the user's profile based on the user ID -->
            <?php
            // Include your database connection file
            require_once('C:\AppServ\www\project1\connection.php');

            // Retrieve the user ID from the URL
            $userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;

            // Check if the user ID is available in the URL
            if ($userId) {
                // Fetch user profile data from the 'userr' table using the $userId
                $sql = "SELECT * FROM userr WHERE id = $userId";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    // Display the user's profile data from 'userr' table
                    while ($row = $result->fetch_assoc()) {
                        echo "<img src='path_to_user_image' alt='User Image'>";
                        echo "<h2>Name: " . $row['name'] . "</h2>";
                    }

                    // Fetch user profile data from the 'employee' table using the $userId
                    $sql1 = "SELECT * FROM passenger WHERE user_id = $userId";
                    $result2 = $con->query($sql1);

                    if ($result2->num_rows > 0) {
                        // Display the user's profile data from 'employee' table
                        while ($row = $result2->fetch_assoc()) {
                            echo "<p>Photo: " . $row['photo'] . "</p>";
                            echo "<p>Account_Balance: " . $row['account_balance'] . "</p>";
                            echo "<p>Passport_Image: " . $row['passport_img'] . "</p>";
                            // Display other user information as needed
                        }
                    } else {
                        // No employee profile found for this user
                        echo "<p>No employee profile found.</p>";
                    }

                    // Add an Edit button
                    echo "<div class='edit-button'>";
                    echo "<a href='editPassengerProfile.php?user_id=$userId'>Edit Profile</a>";
                    echo "</div>";
                } else {
                    // No user profile found for the given user ID
                    echo "<p>No user profile found.</p>";
                }
            } else {
                // No user ID specified
                echo "<p>No user ID specified.</p>";
            }

            // Close the database connection
            $con->close();
            ?>
        </div>
    </div>
</body>
</html>
