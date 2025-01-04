<?php
// Start session to access session variables
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medion";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in. Please log in to submit feedback.");
}

// Get the logged-in user's ID from the session
$customer_id = intval($_SESSION['user_id']); 

// Retrieve form data
$doctor_id = isset($_POST['doctor_id']) ? intval($_POST['doctor_id']) : 0;
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
$comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
$suggestions = isset($_POST['suggestions']) ? trim($_POST['suggestions']) : '';

// Validate `customer_id` exists in `users` table
$sql = "SELECT COUNT(*) AS count FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    die("Invalid customer ID. Please log in again.");
}

// Insert feedback into the database
$sql = "
    INSERT INTO feedback (doctor_id, customer_id, rating, comment, suggestions)
    VALUES (?, ?, ?, ?, ?)
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiss", $doctor_id, $customer_id, $rating, $comment, $suggestions);

if ($stmt->execute()) {
    echo "Feedback submitted successfully.";
} else {
    echo "Error: " . $conn->error;
}

// Close connection
$conn->close();
?>
