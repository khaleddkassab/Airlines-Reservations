<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add your styles here */

        .registration-form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f2f2f2;


        }

        body {
            background-image: url('background.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .form-group {
            margin-bottom: 15px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .form-group .message {
            position: absolute;
            top: 100%;
            left: 0;
            color: red;
        }

        .submit-btn {
            background-color: black;
            color: white;
            padding: 10px;
            border: none;
            width: 140px;
            border-radius: 5px;
            cursor: pointer;
            width: 100px;
            margin-top: 10px;
            margin-left: 299px;
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
                <div class="message" id="nameMessage"></div>
            </div>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <div class="message" id="usernameMessage"></div>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <div class="message" id="passwordMessage"></div>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <div class="message" id="emailMessage"></div>
            </div>

            <div class="form-group">
                <label for="tel">Telephone:</label>
                <input type="tel" id="tel" name="tel" required>
                <div class="message" id="telMessage"></div>
            </div>

            <div class="form-group">
                <label for="type">User Type:</label><br>
                <input type="radio" id="employee" name="user_type" value="employee">
                <label for="employee">Employee</label><br>
                <input type="radio" id="passenger" name="user_type" value="passenger">
                <label for="passenger">Passenger</label><br>
                <div class="message" id="userTypeMessage"></div>
            </div>

            <button type="submit" class="submit-btn">Register</button>
            <button type="button" class="submit-btn" id="goToLoginBtn">Go to Login</button>

        </form>

    </div>

    <?php
    require_once('C:\AppServ\www\Airlines\connection.php');

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

    <script>
        var nameInput = document.getElementById('name');
        var nameMessage = document.getElementById('nameMessage');

        nameInput.addEventListener('input', function () {
            // You can customize the validation logic based on your requirements
            if (nameInput.value.length < 3) {
                nameMessage.textContent = 'Name should be at least 3 characters long.';
                nameMessage.style.color = 'red';
            } else {
                nameMessage.textContent = ''; // Clear the message
            }
        });

        var usernameInput = document.getElementById('username');
        var usernameMessage = document.getElementById('usernameMessage');

        usernameInput.addEventListener('input', function () {
            // You can customize the validation logic based on your requirements
            if (usernameInput.value.length < 3) {
                usernameMessage.textContent = 'Username should be at least 3 characters long.';
                usernameMessage.style.color = 'red';
            } else {
                usernameMessage.textContent = ''; // Clear the message
            }
        });

        var passwordInput = document.getElementById('password');
        var passwordMessage = document.getElementById('passwordMessage');

        passwordInput.addEventListener('input', function () {
            // You can customize the validation logic based on your requirements
            if (passwordInput.value.length < 8) {
                passwordMessage.textContent = 'Password should be at least 8 characters long.';
                passwordMessage.style.color = 'red';
            } else {
                passwordMessage.textContent = ''; // Clear the message
            }
        });

        var emailInput = document.getElementById('email');
        var emailMessage = document.getElementById('emailMessage');

        emailInput.addEventListener('input', function () {
            // You can customize the validation logic based on your requirements
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (!emailPattern.test(emailInput.value)) {
                emailMessage.textContent = 'Invalid email format.';
                emailMessage.style.color = 'red';
            } else {
                emailMessage.textContent = ''; // Clear the message
            }
        });

        var telInput = document.getElementById('tel');
        var telMessage = document.getElementById('telMessage');

        telInput.addEventListener('input', function () {
            // You can customize the validation logic based on your requirements
            var telPattern = /^\d{10}$/; // Assuming a 10-digit telephone number
            if (!telPattern.test(telInput.value)) {
                telMessage.textContent = 'Invalid telephone number format.';
                telMessage.style.color = 'red';
            } else {
                telMessage.textContent = ''; // Clear the message
            }
        });

        var userTypeMessage = document.getElementById('userTypeMessage');
        var employeeRadio = document.getElementById('employee');
        var passengerRadio = document.getElementById('passenger');

        // Check if at least one user type is selected
        function validateUserType() {
            if (!employeeRadio.checked && !passengerRadio.checked) {
                userTypeMessage.textContent = 'Please select a user type.';
                userTypeMessage.style.color = 'red';
            } else {
                userTypeMessage.textContent = ''; // Clear the message
            }
        }

        employeeRadio.addEventListener('change', validateUserType);
        passengerRadio.addEventListener('change', validateUserType);
    </script>

    <script>
        // Get the button elements by their IDs
        var goToLoginBtn = document.getElementById('goToLoginBtn');

        goToLoginBtn.addEventListener('click', function () {
            // Redirect to login.php (replace with your actual login page)
            window.location.href = 'login.php';
        });
    </script>
</body>

</html>