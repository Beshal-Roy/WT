
<?php
session_start();
require_once '../models/UserModel.php';

$userModel = new UserModel();

// User Registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate input
    if (!empty($username) && !empty($password)) {
        if ($userModel->register($username, $password)) {
            $_SESSION['message'] = "Registration successful!";
            header("Location: /app/views/user/login.php");
            exit();
        } else {
            $_SESSION['error'] = "Registration failed. Please try again.";
        }
    }
}

// User Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate input
    if (!empty($username) && !empty($password)) {
        $user = $userModel->login($username, $password);
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: /app/views/user/profile.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid credentials.";
        }
    }
}

// User Profile
if (isset($_SESSION['user_id'])) {
    $user = $userModel->getUserById($_SESSION['user_id']);
}

// Update Profile
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $username = $_POST['username'] ?? '';
    if ($userModel->updateProfile($_SESSION['user_id'], $username)) {
        $_SESSION['message'] = "Profile updated successfully!";
        header("Location: /app/views/user/profile.php");
        exit();
    }
}

// Change Password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $new_password = $_POST['new_password'] ?? '';
    if ($userModel->changePassword($_SESSION['user_id'], $new_password)) {
        $_SESSION['message'] = "Password changed successfully!";
        header("Location: /app/views/user/profile.php");
        exit();
    }
}
