CREATE TABLE userr (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    userType VARCHAR(50),
    name VARCHAR(100),
    tel VARCHAR(15),
    email VARCHAR(100) UNIQUE
);
 CREATE TABLE employee (
    employee_id INT PRIMARY KEY,
    user_id INT,
    bio TEXT,
    address VARCHAR(255),
    location VARCHAR(255),
    account_balance DECIMAL(10, 2)
);
CREATE TABLE passenger (
    passenger_id INT PRIMARY KEY,
    user_id INT,
    photo BLOB, -- Assuming photo is a binary large object (BLOB) to store image data
    passport_img BLOB, -- Assuming passport_img is a binary large object (BLOB) to store image data
    account_balance DECIMAL(10, 2)
);
 CREATE TABLE flight (
    flight_id INT PRIMARY KEY,
    name VARCHAR(100),
    itinerary TEXT,
    registered_passengers INT,
    pending_passengers INT,
    fees DECIMAL(10, 2),
    end_time DATETIME,
    start_time DATETIME,
    completed BOOLEAN
);
CREATE TABLE user_flights (
    user_id INT,
    flight_id INT,
    user_type VARCHAR(50),
    payment_type ENUM('VISA', 'CASH') DEFAULT NULL,
    PRIMARY KEY (user_id, flight_id),
    FOREIGN KEY (user_id) REFERENCES userr(id),
    FOREIGN KEY (flight_id) REFERENCES flight(flight_id)
);
CREATE TABLE message (
    id INT AUTO_INCREMENT PRIMARY KEY,
    time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    message TEXT NOT NULL,
    from_id INT NOT NULL,
    to_id INT NOT NULL
);
