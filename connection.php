 <?php
        // Include your database connection file
        $servername = "localhost";
        $username = "root"; // Change if your MySQL username is different
        $password = "123456789"; // Change if your MySQL password is different
        $dbname = "database3"; // Change to your actual database name

        // Create connection
        $con = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
?>