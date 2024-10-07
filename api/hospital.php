<?php
header('Content-Type: application/json');

$host = "127.0.0.1";
$db_name = "hospital_log";
$username = "root";
$password = "";
$conn;

$conn = null;
try {
    $conn =  mysqli_connect($host, $username, $password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}

$sql = "SELECT * FROM Hospital"; 
$result = $conn->query($sql);

if ($result === false) {
    // Database query failed
    echo json_encode(['success' => false, 'message' => 'Database query failed: ' . $conn->error]);
    exit;
}

$hospitals = [];
while ($row = $result->fetch_assoc()) {
    $hospitals[] = $row;
}

echo json_encode(['success' => true, 'hospitals' => $hospitals]);
