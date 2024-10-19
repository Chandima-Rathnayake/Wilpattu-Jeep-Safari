<?php
// Include the Composer autoload file and load environment variables
require_once(__DIR__ . '/../../vendor/autoload.php');

use Cloudinary\Cloudinary;
use Dotenv\Dotenv;

// Load environment variables from .env file in the root directory
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../'); 
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the file was uploaded without errors
    if (isset($_FILES['animal_image']) && $_FILES['animal_image']['error'] == 0) {
        try {
            // Configure Cloudinary
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'],
                    'api_key'    => $_ENV['CLOUDINARY_API_KEY'],
                    'api_secret' => $_ENV['CLOUDINARY_API_SECRET'],
                ]
            ]);

            // Upload the image to Cloudinary
            $uploadResult = $cloudinary->uploadApi()->upload($_FILES['animal_image']['tmp_name'], [
                'folder' => 'Animals'
            ]);

            // Get the image URL
            $imageUrl = $uploadResult['secure_url'];

            // Get animal details from POST
            $animalName = $_POST['animal_name'];
            $animalDetails = $_POST['animal_details'];

            // Database connection using environment variables
            $conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);

            // Check connection
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }

            // Insert into database
            $stmt = $conn->prepare("INSERT INTO animals (name, details, image_url) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $animalName, $animalDetails, $imageUrl);

            if ($stmt->execute()) {
                // Return success response
                echo json_encode(['success' => true, 'message' => 'Upload successful!']);
            } else {
                throw new Exception("Database error: " . $stmt->error);
            }

            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'File upload error: ' . $_FILES['animal_image']['error']]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

