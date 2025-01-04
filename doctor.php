<?php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medion";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Search parameter (sanitize input)
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// SQL query to search for doctors based on name or specialty (using prepared statement)
$sql = "
    SELECT d_id AS id, name, specialty, location, contact, availability 
    FROM doctors 
    WHERE name LIKE ? OR specialty LIKE ?
";
$stmt = $conn->prepare($sql);
$searchTerm = '%' . $search . '%';
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

echo '<style>
    body {
        font-family: Arial, sans-serif;
        background-color:rgb(10, 173, 214);
        margin: 0;
        padding: 0;
    }
    .doctor-card {
        background-color: #fff;
        margin: 100px;
        padding: 50px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(12, 1, 1, 0.87);
    }
    .doctor-card h3 {
        margin: 0;
        font-size: 24px;
        color: #333;
    }
    .doctor-card p {
        font-size: 16px;
        margin: 5px 0;
        color: #555;
    }
    .doctor-card button {
        padding: 10px 20px;
        font-size: 16px;
        background-color:rgb(8, 155, 171);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .doctor-card button:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }
    form {
        margin-top: 20px;
    }
    form label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }
    form input, form textarea {
        width: 50%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
    }
    form button {
        padding: 10px 20px;
        background-color:rgb(4, 25, 9);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    form button:hover {
        background-color:rgb(4, 37, 12);
    }
</style>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="doctor-card">';
        echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
        echo '<p><strong>Specialty:</strong> ' . htmlspecialchars($row['specialty']) . '</p>';
        echo '<p><strong>Location:</strong> ' . htmlspecialchars($row['location']) . '</p>';
        echo '<p><strong>Contact:</strong> ' . htmlspecialchars($row['contact']) . '</p>';
        echo '<p><strong>Availability:</strong> ' . htmlspecialchars($row['availability']) . '</p>';
        
        // Booking form
        echo '<form action="book.php" method="post">';
        echo '<input type="hidden" name="doctor_id" value="' . htmlspecialchars($row['id']) . '">';
        echo '<button type="submit"';
        if ((int)$row['availability'] <= 0) {
            echo ' disabled';
        }
        echo '>Book Now</button>';
        echo '</form>';
        
        // Feedback form
        echo '<h4>Give Feedback</h4>';
        echo '<form action="submit_feedback.php" method="post">';
        echo '<input type="hidden" name="doctor_id" value="' . htmlspecialchars($row['id']) . '">';
        echo '<label for="rating">Rating (1-5):</label>';
        echo '<input type="number" id="rating" name="rating" min="1" max="5" required><br>';
        echo '<label for="comment">Comment:</label>';
        echo '<textarea id="comment" name="comment" required></textarea><br>';
        echo '<label for="suggestions">Suggestions:</label>';
        echo '<textarea id="suggestions" name="suggestions"></textarea><br>';
        echo '<button type="submit">Submit Feedback</button>';
        echo '</form>';

        echo '</div>';
    }
} else {
    echo '<p>No doctors found matching your search criteria.</p>';
}

// Close connection
$conn->close();
?>

