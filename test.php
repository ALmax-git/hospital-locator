<?php

$host = "127.0.0.1";
$db_name = "hospital_og";
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

echo json_decode($conn);
