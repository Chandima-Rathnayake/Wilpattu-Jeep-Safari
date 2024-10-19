<?php
// fetch_animals.php
require __DIR__ . '/../../vendor/autoload.php'; // Correct the path based on your structure


use Dotenv\Dotenv;

// Load environment variables from .env file in the root directory
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../'); 
$dotenv->load();

// Database connection
$conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch animals from the database
$sql = "SELECT name, details, image_url FROM animals";
$result = $conn->query($sql);

// Initialize an array to hold animal data
$animals = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $animals[] = $row;
    }
}

// Close the database connection
$conn->close();

// Output the animal data as JSON
header('Content-Type: application/json');
echo json_encode($animals);
?>
