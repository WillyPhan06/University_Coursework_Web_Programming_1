<?php
require 'includes/DatabaseConnection.php';
require 'includes/DataBaseFunctions.php';

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

$title = 'View Question';
ob_start();
include 'templates/question_view.php';
$output = ob_get_clean();
include 'templates/layout.php';
?>
