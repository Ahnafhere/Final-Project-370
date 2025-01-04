<?php
session_start(); // Start the session at the top of the page

$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "medion";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($password == $row['password']) { // Assuming plain password (should use hashing in production)
            $_SESSION['user_id'] = $row['user_id']; // Store user_id in session

            // Debugging: Check session data
            var_dump($_SESSION); // This should show the user_id after login

            header("Location: index.html"); // Redirect to homepage
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No account found with this email.";
    }
}

$conn->close();
?>