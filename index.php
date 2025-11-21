<?php
require 'includes/DatabaseConnection.php';
require 'includes/DataBaseFunctions.php';

startUserSession();

$questions = allQuestions($pdo);
$currentUser = getCurrentUser();
$title = 'Student Q&A - Questions';
ob_start();
include 'templates/questions_list.php';
$output = ob_get_clean();
include 'templates/layout.php';
?>
