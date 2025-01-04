<?php

session_start(); // Make sure session is started at the top

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("<p>Please log in to continue.</p>");
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medion";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . htmlspecialchars($conn->connect_error));
}

$logged_in_user_id = $_SESSION['user_id']; // Get logged-in user's ID

// Handle "Buy Now" action
if (isset($_POST['buy_now'])) {
    $product_id = intval($_POST['product_id']); // Get the product ID from the form

    // Ensure product_id is set before proceeding
    if (!isset($product_id)) {
        die("<p>Product ID is missing.</p>");
    }

    // Fetch product details including stock
    $stmt = $conn->prepare("SELECT price, stock FROM product WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($product_price, $stock);
    if (!$stmt->fetch()) {
        die("<p>Product not found.</p>");
    }
    $stmt->close();

    // Ensure enough stock is available
    $quantity = 1; // Default quantity as 1 for "Buy Now"
    if ($stock < $quantity) {
        die("<p>Sorry, not enough stock available for this product.</p>");
    }

    // Calculate the total price
    $total_price = $product_price * $quantity;

    // Start a transaction to ensure data consistency
    $conn->begin_transaction();

    try {
        // Insert into orders table
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
        $stmt->bind_param("id", $logged_in_user_id, $total_price);
        $stmt->execute();
        $order_id = $stmt->insert_id;
        $stmt->close();

        // Insert into order_items table
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $product_price);
        $stmt->execute();
        $stmt->close();

        // Update stock in product table
        $new_stock = $stock - $quantity;
        $stmt = $conn->prepare("UPDATE product SET stock = ? WHERE id = ?");
        $stmt->bind_param("ii", $new_stock, $product_id);
        $stmt->execute();
        $stmt->close();

        // Commit the transaction
        $conn->commit();

        echo "<p style='color: green; font-weight: bold;'>Purchase successfully done!</p>";
    } catch (Exception $e) {
        // Rollback the transaction if anything goes wrong
        $conn->rollback();
        echo "<p style='color: red;'>There was an error processing your order. Please try again.</p>";
    }
}

// Check if the search query is set
if (isset($_GET['query'])) {
    $search = htmlspecialchars(trim($_GET['query']), ENT_QUOTES, 'UTF-8');

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT id, product_name, price, product_image FROM product WHERE product_name LIKE ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $searchTerm = "%$search%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any results were returned
    if ($result->num_rows > 0) {
        echo "<h2>Search Results for '" . htmlentities($search) . "':</h2>";
        echo "<div style='display: flex; flex-wrap: wrap; gap: 20px;'>";

        while ($row = $result->fetch_assoc()) {
            echo "<div class='product-card'>";
            echo "<img src='" . htmlentities($row['product_image']) . "' alt='" . htmlentities($row['product_name']) . "' class='product-image'>";
            echo "<h3 class='product-name'>" . htmlentities($row['product_name']) . "</h3>";
            echo "<p class='product-price'>Price: " . htmlentities($row['price']) . "/-</p>";
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='product_id' value='" . htmlentities($row['id']) . "'>";
            echo "<button type='submit' name='buy_now' class='buy-now-button'>Buy Now</button>";
            echo "</form>";
            echo "</div>";
        }

        echo "</div>";
    } else {
        echo "<p>No product found matching your search query.</p>";
    }

    $stmt->close();
} else {
    echo "<p>Please enter a search query.</p>";
}

$conn->close();
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color:rgb(15, 214, 232);
        margin: 0;
        padding: 0;
    }
    h2 {
        color: #333;
        padding: 20px;
    }
    .product-card {
        border: 1px solid #ddd;
        padding: 15px;
        width: 250px;
        text-align: center;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgb(2, 22, 28);
        transition: transform 0.2s ease-in-out;
    }
    .product-card:hover {
        transform: translateY(-5px);
    }
    .product-image {
        width: 150px;
        height: 150px;
        object-fit: contain;
        margin-bottom: 10px;
    }
    .product-name {
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }
    .product-price {
        font-size: 16px;
        color: #777;
        margin-bottom: 15px;
    }
    .buy-now-button {
        padding: 10px 20px;
        background-color:rgb(16, 216, 63);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    .buy-now-button:hover {
        background-color:rgb(3, 23, 7);
    }
</style>
