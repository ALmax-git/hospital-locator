<?php
// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the Hospital model
require_once '../models/Hospital.php';

// Database configuration
$host = "127.0.0.1";
$db_name = "hospital_log";
$username = "root";
$password = "";
$conn = null;

// Database connection
try {
    $conn = new mysqli($host, $username, $password, $db_name);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die(json_encode(['success' => false, 'message' => "Database connection error: " . $e->getMessage()]));
}

$hospital = new Hospital($conn);

// Check if 'location' parameter is provided
if (isset($_GET['location']) && !empty($_GET['location'])) {
    $location = urlencode($_GET['location']);
    $url = "https://nominatim.openstreetmap.org/search?q={$location}&format=json&addressdetails=1";

    // Initialize cURL request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FAILONERROR, true); // Return error messages on failure
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Optional: Set timeout to avoid hanging
    curl_setopt($ch, CURLOPT_USERAGENT, 'hospital-locator/1.0 (alimustaphashettima@gmail.com)'); // Comply with OpenStreetMap API

    // Execute the cURL request
    $response = curl_exec($ch);

    if ($response === false) {
        // Error fetching data from the API
        $error = curl_error($ch);
        curl_close($ch);
        die(json_encode(['success' => false, 'message' => 'Error fetching data from the location API: ' . $error]));
    }

    curl_close($ch);

    // Decode the JSON response
    $data = json_decode($response, true);

    // Check if the response contains data
    if (empty($data)) {
        die(json_encode(['success' => false, 'message' => 'No data returned from the location API.']));
    }

    // Debugging: Output the raw API response (optional)
    // echo "<pre>";
    // print_r($data); // Comment or remove this after debugging
    // echo "</pre>";
    // exit;

    // Check if latitude and longitude are available
    if (isset($data[0]['lat']) && isset($data[0]['lon'])) {
        $latitude = $data[0]['lat'];
        $longitude = $data[0]['lon'];
        $address = $data[0]['display_name']; // Full address from the API

        // Attempt to save the location to the database
        try {
            $hospitalId = $hospital->createHospital($_GET['location'], $longitude, $latitude, $address, 'Maiduguri');

            if ($hospitalId) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Hospital location successfully saved!',
                    'hospital' => [
                        'id' => $hospitalId,
                        'name' => $_GET['location'],
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'address' => $address
                    ]
                ]);
            } else {
                throw new Exception('Failed to save the hospital location. Please try again.');
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Errors: ' . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No location found. Please check the name and try again.'
        ]);
    }
} else {
    // Handle case when 'location' parameter is missing
    echo json_encode([
        'success' => false,
        'message' => 'Location parameter is missing. Please provide a location to search.'
    ]);
}