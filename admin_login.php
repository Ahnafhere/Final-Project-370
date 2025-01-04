<?php
// Start session to store login status
session_start();

// Database credentials (replace these with your own)
$servername = "localhost";
$username = "root";    // Default MySQL username for XAMPP
$password = "";        // Default MySQL password for XAMPP (empty string)
$dbname = "medion";    // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form inputs
$admin_email = $_POST['admin_email'];
$admin_password = $_POST['admin_password'];

// Query to check admin credentials
$sql = "SELECT * FROM admin WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $admin_email, $admin_password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Login successful
    $_SESSION['admin'] = $admin_email;
    header("Location: admin.html"); // Redirect to admin panel
    exit(); // Always call exit() after header redirection
} else {
    // Login failed
    $error = "Invalid email or password.";
    header("Location: admin_login.html?error=" . urlencode($error));
    exit(); // Always call exit() after header redirection
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
