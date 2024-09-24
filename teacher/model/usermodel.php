<?php
require_once '../config/database.php';

class UserModel {
    private $conn;

    // Constructor: Establish the database connection
    public function __construct() {
        $this->conn = Database::getConnection();
    }

    // Method for user registration
    public function register($username, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        return $stmt->execute();
    }

    // Method for user login
    public function login($username, $password) {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Return user data if login is successful
        }
        return null; // Return null if login fails
    }

    // Method to get user by ID
    public function getUserById($user_id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to update user profile
    public function updateProfile($user_id, $username) {
        $query = "UPDATE users SET username = :username WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':id', $user_id);
        return $stmt->execute();
    }

    // Method to change password
    public function changePassword($user_id, $new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':id', $user_id);
        return $stmt->execute();
    }
}
