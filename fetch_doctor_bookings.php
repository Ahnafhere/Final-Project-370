<?php
// Database connection
$host = "localhost";
$user = "root";
$password = ""; // Replace with your database password
$dbname = "medion";

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch booking details
$sql = "
    SELECT 
        d.name AS doctor_name,
        d.specialty,
        d.location,
        u.username AS customer_name,
        b.booking_date,
        b.id AS booking_id
    FROM 
        mybookings AS b
    INNER JOIN 
        doctors AS d ON b.d_id = d.d_id
    INNER JOIN 
        users AS u ON b.user_id = u.user_id
";

$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    // Fetch all data into an array
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Return data in JSON format
header('Content-Type: application/json');
echo json_encode($data);

// Close the connection
$conn->close();
?>
