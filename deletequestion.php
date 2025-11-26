<?php
require 'includes/DatabaseConnection.php';
require 'includes/DataBaseFunctions.php';

startUserSession();

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
    $id = (int)$_POST['id'];
    $question = getQuestion($pdo, $id);
    
    if (!$question) {
        header('Location: index.php');
        exit;
    }
    
    $currentUser = getCurrentUser();
    
    // Check if user owns the question or is admin
    if ($question['userid'] != $currentUser['id'] && !isAdmin()) {
        header('HTTP/1.1 403 Forbidden');
        echo 'You cannot delete this question.';
        exit;
    }
    
    deleteQuestion($pdo, $id);
}
header('Location: index.php');
exit;
?>