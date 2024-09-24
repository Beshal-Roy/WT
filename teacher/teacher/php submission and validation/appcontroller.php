
<?php
session_start();
require_once '../models/ApplicationModel.php';

$applicationModel = new ApplicationModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle drop application submission
    $student_id = $_POST['student_id'];
    $reason = $_POST['reason'];
    
    $applicationModel->submitApplication($student_id, $reason);
    echo "Application submitted successfully!";
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getApplications') {
    // Fetch applications from the database
    $applications = $applicationModel->getAllApplications(); 
    echo json_encode($applications); 
}






<?php
session_start();  // Starting session to track the teacher's actions

require_once '../models/ApplicationModel.php';  // Including the model for handling database logic

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Retrieve form data
    $status = $_POST['status'] ?? '';
    $comment = $_POST['comment'] ?? '';
    
    // Validation flag
    $errors = [];

    // Validate the status (must be 'accept' or 'reject')
    if (!preg_match("/^(accept|reject)$/", $status)) {
        $errors[] = "Invalid status. Please select 'accept' or 'reject'.";
    }

    // Validate comment only if the status is 'reject'
    if ($status === 'reject') {
        if (empty($comment)) {
            $errors[] = "Comment is required if rejecting the application.";
        } elseif (!preg_match("/^[a-zA-Z0-9\s.,!?]{5,200}$/", $comment)) {
            // Regex for comment: allows alphanumeric characters, punctuation, and spaces (min 5 characters, max 200)
            $errors[] = "Comment must be between 5 and 200 characters long, with valid punctuation.";
        }
    }

    // If there are no errors, process the application
    if (empty($errors)) {
        // Call the model to save the application decision to the database
        $applicationModel = new ApplicationModel();
        
        // Assume updateApplicationStatus is a method in ApplicationModel
        $result = $applicationModel->updateApplicationStatus($_SESSION['teacher_id'], $status, $comment);

        if ($result) {
            // Success: Redirect to success page or display a success message
            header("Location: /app/views/application/success.php");
            exit();
        } else {
            // Database error handling
            $errors[] = "Failed to update the application status. Please try again.";
        }
    }
}

// If there are errors, display them (this should be redirected to a view)
if (!empty($errors)) {
    // You can store errors in session or display them directly
    $_SESSION['errors'] = $errors;
    header("Location: /app/views/application/form.php");
    exit();
}
?>
