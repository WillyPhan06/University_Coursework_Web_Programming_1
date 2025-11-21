<?php
require 'includes/DatabaseConnection.php';
require 'includes/DataBaseFunctions.php';

startUserSession();

// If already logged in, redirect to home
if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validation
    if (empty($username) || empty($name) || empty($email) || empty($password)) {
        $error = 'All fields are required.';
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $error = 'Username must be between 3 and 50 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (userExists($pdo, $username, $email)) {
        $error = 'Username or email already exists.';
    } else {
        try {
            registerUser($pdo, $username, $name, $email, $password);
            // Auto-login after registration
            loginUser($pdo, $username, $password);
            header('Location: index.php');
            exit;
        } catch (Exception $e) {
            $error = 'Registration failed. Please try again.';
        }
    }
}

$title = 'Register';
ob_start();
include 'templates/register_form.php';
$output = ob_get_clean();
include 'templates/layout.php';
?>
