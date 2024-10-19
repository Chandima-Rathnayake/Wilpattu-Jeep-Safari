<?php
require __DIR__ . '/../../vendor/autoload.php'; // Adjust the path as necessary

use Dotenv\Dotenv;

// Load environment variables from .env file in the root directory
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Database connection using environment variables
$conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve feedback
$sql = "SELECT name, role, feedback, rating, image_url, submission_date FROM feedback ORDER BY submission_date DESC";
$result = $conn->query($sql);

$feedbacks = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $feedbacks[] = $row; // Store each feedback entry
    }
}

$conn->close();

// Return feedback as JSON
header('Content-Type: application/json');
echo json_encode($feedbacks);
