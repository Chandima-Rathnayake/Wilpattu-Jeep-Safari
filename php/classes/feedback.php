<?php
// Include the Composer autoload file and load environment variables
require_once(__DIR__ . '/../../vendor/autoload.php');

use Cloudinary\Cloudinary;
use Dotenv\Dotenv;

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load environment variables from .env file in the root directory
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../'); 
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize response array
    $response = ['success' => false, 'message' => ''];

    // Default image URL
    $imageUrl = 'https://res.cloudinary.com/dgtbkkzzb/image/upload/v1729322754/Default_pfp_poakvm.jpg'; // Default image

    // Check if the file was uploaded without errors
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
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
            $uploadResult = $cloudinary->uploadApi()->upload($_FILES['image']['tmp_name'], [
                'folder' => 'Users'
            ]);

            // Get the image URL
            $imageUrl = $uploadResult['secure_url'];

        } catch (Exception $e) {
            $response['message'] = 'Error uploading image: ' . $e->getMessage();
            echo json_encode($response);
            exit;
        }
    }

    // Get feedback details from POST
    $name = $_POST['name'];
    $role = $_POST['role'];
    $feedback = $_POST['feedback'];
    $rating = $_POST['rating'];
    $submission_date = date('Y-m-d H:i:s'); // Set the current date and time

    // Database connection using environment variables
    $conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);

    // Check connection
    if ($conn->connect_error) {
        $response['message'] = "Connection failed: " . $conn->connect_error;
        echo json_encode($response);
        exit;
    }

    // Insert into the feedback table
    $stmt = $conn->prepare("INSERT INTO feedback (name, role, feedback, rating, image_url, submission_date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $role, $feedback, $rating, $imageUrl, $submission_date);

    if ($stmt->execute()) {
        // Return success response
        $response['success'] = true;
        $response['message'] = 'Feedback submitted successfully!';
    } else {
        $response['message'] = "Database error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    echo json_encode($response);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
