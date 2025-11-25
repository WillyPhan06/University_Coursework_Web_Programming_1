<?php
require 'includes/DatabaseConnection.php';
require 'includes/DataBaseFunctions.php';

startUserSession();

if (!isset($_GET['username'])) {
    header('Location: index.php');
    exit;
}

$username = $_GET['username'];
$user = getUserByUsername($pdo, $username);

if (!$user) {
    header('HTTP/1.1 404 Not Found');
    echo 'User not found';
    exit;
}

// Get user's questions using database function
$userQuestions = getUserQuestions($pdo, $user['id']);

// Get user's comments using database function
$userComments = getUserComments($pdo, $user['id']);

$title = "Profile - " . htmlspecialchars($user['name']);
ob_start();
include 'templates/user_profile.php';
$output = ob_get_clean();
include 'templates/layout.php';
?>