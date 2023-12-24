<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <style>
        /* Add your styles here */
        
        .registration-form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
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

        .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            height: 80px;
        }

        .submit-btn {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }
        
    </style>
</head>
<body>

<div class="registration-form">
        <h2>Register</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
           
           
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="tel">Telephone:</label>
                <input type="tel" id="tel" name="tel" required>
            </div>
            
            <div class="form-group">
                <label for="type">User Type:</label><br>
                <input type="radio" id="employee" name="user_type" value="employee">
                <label for="employee">Employee</label><br>
                <input type="radio" id="passenger" name="user_type" value="passenger">
                <label for="passenger">Passenger</label><br>
            </div>

            <button type="submit" class="submit-btn">Register</button>
        </form>
        <form method="get" action="login.php">
            <button type="submit" class="submit-btn">Go to Login</button>
        </form>
    </div>
 <?php
require_once('C:\AppServ\www\project1\connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $userType = isset($_POST['user_type']) ? $_POST['user_type'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $tel = isset($_POST['tel']) ? $_POST['tel'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Insert data into Userr table
    $sql = "INSERT INTO Userr (username, password, userType, name, tel, email) VALUES ('$username', '$password', '$userType', '$name', '$tel', '$email')";
    if ($con->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $con->error;
    } else {
        $lastId = $con->insert_id; // Get the last inserted ID

        if ($userType === 'employee') {
            header("Location: registerEmployee.php?id=$lastId"); // Redirect to RegisterEmployee.php
            exit();
        } else if ($userType === 'passenger') {
            header("Location: registerPassenger.php?id=$lastId"); // Redirect to RegisterPassenger.php
            exit();
        } else {
            echo "User registered successfully!"; // Display success message
        }
    }
}

$con->close();
?>


</body>
</html>
