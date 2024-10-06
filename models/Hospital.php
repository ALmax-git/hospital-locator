<?php

class Hospital
{
    private $conn;

    // Properties
    public $id;
    public $name;
    public $longitude;
    public $latitude;
    public $created_at;
    public $updated_at;
    public $deleted_at;
    public $status;
    public $address;
    public $photos;
    public $city;

    // Constructor with database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }


    // Create hospital function
    public function createHospital($name, $longitude, $latitude, $address, $city, $status = 1)
    {
        $stmt = $this->conn->prepare("INSERT INTO Hospital (name, longitude, latitude, address, city, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sddssi", $name, $longitude, $latitude, $address, $city, $status);

        if (!$stmt->execute()) {
            die("Error creating hospital: " . $stmt->error);
        }

        return $this->conn->insert_id; // Return the ID of the newly created hospital
    }

    // Get hospital by ID
    public function getHospitalById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Hospital WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
    // Create a new hospital
    public function create()
    {
        $query = "INSERT INTO Hospital (name, longitude, latitude, status, address, city)
                  VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ddisss", $this->name, $this->longitude, $this->latitude, $this->status, $this->address, $this->city);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Read all hospitals
    public function read()
    {
        $query = "SELECT * FROM Hospital WHERE deleted_at IS NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Update a hospital
    public function update()
    {
        $query = "UPDATE Hospital SET name = ?, longitude = ?, latitude = ?, address = ?, city = ?, status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ddissii", $this->name, $this->longitude, $this->latitude, $this->address, $this->city, $this->status, $this->id);
        return $stmt->execute();
    }

    // Delete a hospital (soft delete)
    public function delete()
    {
        $query = "UPDATE Hospital SET deleted_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }
}