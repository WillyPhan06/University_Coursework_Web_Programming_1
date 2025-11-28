<?php
require 'includes/DatabaseConnection.php';
require 'includes/DataBaseFunctions.php';

startUserSession();

$questions = allQuestions($pdo);
$currentUser = getCurrentUser();

// Check for success messages
$successMessage = '';
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 'question_added':
            $successMessage = 'Question added successfully!';
            break;
        case 'question_deleted':
            $successMessage = 'Question deleted successfully!';
            break;
        case 'deleted':
            $successMessage = 'Your account has been successfully deleted. Thank you for using our platform.';
            break;
    }
}

// Check if user just deleted their account
$accountDeleted = isset($_GET['deleted']) && $_GET['deleted'] == '1';

$title = 'Student Q&A - Questions';
ob_start();

// Show success message if any
if (!empty($successMessage)) {
    echo '<div class="alert alert-success">' . htmlspecialchars($successMessage) . '</div>';
}

if ($accountDeleted) {
    echo '<div class="alert alert-success">Your account has been successfully deleted. Thank you for using our platform.</div>';
}


include 'templates/questions_list.php';
$output = ob_get_clean();
include 'templates/layout.php';
?>