<?php
require 'includes/DatabaseConnection.php';
require 'includes/DataBaseFunctions.php';

startUserSession();

$questions = allQuestions($pdo);
$currentUser = getCurrentUser();

// Check if user just deleted their account
$accountDeleted = isset($_GET['deleted']) && $_GET['deleted'] == '1';

$title = 'Student Q&A - Questions';
ob_start();

// Show success message if account was deleted
if ($accountDeleted) {
    echo '<div class="alert alert-success">Your account has been successfully deleted. Thank you for using our platform.</div>';
}

include 'templates/questions_list.php';
$output = ob_get_clean();
include 'templates/layout.php';
?>