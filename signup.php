<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "medion";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);


  
    $plain_password = $password;

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$plain_password')";

    if ($conn->query($sql) == TRUE) {
        echo "Signup successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
