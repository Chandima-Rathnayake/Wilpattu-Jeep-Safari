<?php
require 'vendor/autoload.php'; // Load Composer dependencies

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database connection parameters
$host = getenv('DB_HOST');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set charset to UTF-8 for better compatibility
$conn->set_charset("utf8");

// Function to close the connection (if needed)
function closeConnection($conn) {
    if ($conn) {
        $conn->close();
    }
}

?>
