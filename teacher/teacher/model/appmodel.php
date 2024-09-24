<?php
require_once '../config/database.php'; // Assuming database.php has the connection setup

class ApplicationModel {
    private $conn;

    // Constructor: Establish the database connection
    public function __construct() {
        $this->conn = Database::getConnection();
    }

    // Method to get a specific application by its ID
    public function getApplicationById($application_id) {
        $query = "SELECT * FROM drop_applications WHERE application_id = :application_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':application_id', $application_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to update the application status and teacher's comment
    public function updateApplicationStatus($application_id, $teacher_id, $status, $comment = null) {
        $query = "UPDATE drop_applications 
                  SET status = :status, teacher_id = :teacher_id, comment = :comment, updated_at = NOW()
                  WHERE application_id = :application_id";

        $stmt = $this->conn->prepare($query);

        // Binding the values
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':teacher_id', $teacher_id);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':application_id', $application_id);

        // Execute the query
        return $stmt->execute();
    }
}
