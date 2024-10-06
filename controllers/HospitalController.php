<?php
require_once __DIR__ . '/../models/Hospital.php';

class HospitalController {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Fetch all hospitals
    public function getAllHospitals() {
        $query = "SELECT * FROM Hospital";
        $result = $this->conn->query($query);

        if (!$result) {
            die("Query failed: " . $this->conn->error);
        }

        $hospitals = [];
        while ($row = $result->fetch_assoc()) {
            $hospitals[] = $row;
        }

        return $hospitals;
    }

    // Add a new hospital
    public function addHospital($name, $longitude, $latitude, $address, $city, $status = 1) {
        $stmt = $this->conn->prepare("INSERT INTO Hospital (name, longitude, latitude, address, city, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sddssi", $name, $longitude, $latitude, $address, $city, $status);

        if (!$stmt->execute()) {
            die("Error adding hospital: " . $stmt->error);
        }

        return $this->conn->insert_id; // Return the ID of the newly added hospital
    }

    // Get a specific hospital by ID
    public function getHospitalById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM Hospital WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Update hospital information
    public function updateHospital($id, $name, $longitude, $latitude, $address, $city, $status) {
        $stmt = $this->conn->prepare("UPDATE Hospital SET name = ?, longitude = ?, latitude = ?, address = ?, city = ?, status = ? WHERE id = ?");
        $stmt->bind_param("sddssii", $name, $longitude, $latitude, $address, $city, $status, $id);

        if (!$stmt->execute()) {
            die("Error updating hospital: " . $stmt->error);
        }

        return $stmt->affected_rows; // Return the number of affected rows
    }

    // Delete a hospital
    public function deleteHospital($id) {
        $stmt = $this->conn->prepare("DELETE FROM Hospital WHERE id = ?");
        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            die("Error deleting hospital: " . $stmt->error);
        }

        return $stmt->affected_rows; // Return the number of affected rows
    }
}
