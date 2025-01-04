<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$username = "root";  // Default MySQL username for XAMPP
$password = "";      // Default MySQL password for XAMPP (empty string)
$dbname = "medion";  // Database name (update if necessary)

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch products sold along with customer details, summing quantity and total price
$sql = "SELECT oi.product_id, p.product_name, u.email AS customer_email, 
                u.user_id,  -- Added user_id here
                SUM(oi.quantity) AS total_quantity, 
                oi.price AS unit_price,  -- Using price from order_items table
                SUM(oi.quantity * oi.price) AS total_price, 
                MAX(o.created_at) AS order_date
        FROM order_items oi
        JOIN orders o ON oi.order_id = o.id
        JOIN product p ON oi.product_id = p.id
        JOIN users u ON o.user_id = u.user_id
        GROUP BY oi.product_id, p.product_name, u.email, u.user_id, oi.price
        ORDER BY MAX(o.created_at) DESC";

$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    $data = [];
}

// Return the data as JSON
echo json_encode($data);

// Close the database connection
$conn->close();
?>

