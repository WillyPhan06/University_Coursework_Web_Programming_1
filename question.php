<?php
require 'includes/DatabaseConnection.php';
require 'includes/DataBaseFunctions.php';

startUserSession();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$question = getQuestion($pdo, $_GET['id']);
if (!$question) {
    header('HTTP/1.1 404 Not Found');
    echo 'Question not found';
    exit;
}

$comments = getCommentsByQuestion($pdo, $_GET['id']);
$currentUser = getCurrentUser();

// Check for success message
$successMessage = '';
if (isset($_GET['success']) && $_GET['success'] === 'question_updated') {
    $successMessage = 'Question updated successfully!';
}

$title = 'View Question';
ob_start();

// Show success message if any
if (!empty($successMessage)) {
    echo '<div class="alert alert-success">' . htmlspecialchars($successMessage) . '</div>';
}

include 'templates/question_view.php';
$output = ob_get_clean();
include 'templates/layout.php';
?>