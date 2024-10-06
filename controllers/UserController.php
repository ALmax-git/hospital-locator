<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Fetch all users
    public function getAllUsers() {
        $query = "SELECT * FROM users";
        $result = $this->conn->query($query);

        if (!$result) {
            die("Query failed: " . $this->conn->error);
        }

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

    // Add a new user
    public function addUser($name, $email, $password, $address, $phone_number) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, address, phone_number) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $hashedPassword, $address, $phone_number);

        if (!$stmt->execute()) {
            die("Error adding user: " . $stmt->error);
        }

        return $this->conn->insert_id; // Return the ID of the newly added user
    }

    // Get a specific user by ID
    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Update user information
    public function updateUser($id, $name, $email, $address, $phone_number, $is_admin) {
        $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ?, address = ?, phone_number = ?, is_admin = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $email, $address, $phone_number, $is_admin, $id);

        if (!$stmt->execute()) {
            die("Error updating user: " . $stmt->error);
        }

        return $stmt->affected_rows; // Return the number of affected rows
    }

    // Delete a user
    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            die("Error deleting user: " . $stmt->error);
        }

        return $stmt->affected_rows; // Return the number of affected rows
    }
}
