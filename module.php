<?php
require 'includes/DatabaseConnection.php';
require 'includes/DataBaseFunctions.php';

startUserSession();

// Check if module ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$moduleId = (int)$_GET['id'];
$module = getModule($pdo, $moduleId);

// If module doesn't exist, redirect
if (!$module) {
    header('Location: index.php');
    exit;
}

// Get all questions for this module
$questions = getQuestionsByModule($pdo, $moduleId);
$currentUser = getCurrentUser();

$title = 'Module: ' . htmlspecialchars($module['name']);
ob_start();
include 'templates/module_questions.php';
$output = ob_get_clean();
include 'templates/layout.php';
?>