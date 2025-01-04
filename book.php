<?php
// Start session to retrieve the logged-in user's ID
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medion";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in (make sure user_id is available in session)
if (!isset($_SESSION['user_id'])) {
    echo '<p>You must be logged in to make a booking.</p>';
    exit();
}

$user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session

// Check if the request is valid
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['doctor_id'])) {
    $doctor_id = $conn->real_escape_string($_POST['doctor_id']);

    // Check if doctor exists and is available
    $checkAvailabilitySql = "SELECT availability FROM doctors WHERE d_id = '$doctor_id'";
    $result = $conn->query($checkAvailabilitySql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ((int)$row['availability'] > 0) {
            // Update doctor's availability and booked count
            $updateDoctorSql = "
                UPDATE doctors
                SET availability = availability - 1, booked = booked + 1
                WHERE d_id = '$doctor_id'
            ";
            if ($conn->query($updateDoctorSql) === TRUE) {
                // Insert into mybookings table with user_id
                $insertBookingSql = "
                    INSERT INTO mybookings (d_id, user_id, booking_date)
                    VALUES ('$doctor_id', '$user_id', NOW())
                ";
                if ($conn->query($insertBookingSql) === TRUE) {
                    echo '<p>Booking successful!</p>';
                } else {
                    echo '<p>Error while saving booking: ' . $conn->error . '</p>';
                }
            } else {
                echo '<p>Error while updating doctor data: ' . $conn->error . '</p>';
            }
        } else {
            echo '<p>Sorry, no availability for this doctor.</p>';
        }
    } else {
        echo '<p>Doctor not found.</p>';
    }
} else {
    echo '<p>Invalid request or missing doctor_id.</p>';
}

$conn->close();
?>
 <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Successful</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <style>
    .success-container {
      text-align: center;
      margin-top: 50px;
    }

    .success-container h1 {
      color: green;
    }

    .success-container a {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #10e7f4;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }

    .success-container a:hover {
      background-color: #007bff;
    }
  </style>
</head>

<body>
  <div class="success-container">
    <h1>Booking Successful!</h1>
    <p>Thank you for choosing our service.</p>
    <a href="doctor.html">Go Back</a>
  </div>
</body>

</html>