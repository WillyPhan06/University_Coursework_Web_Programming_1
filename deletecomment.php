<?php
require 'includes/DatabaseConnection.php';
require 'includes/DataBaseFunctions.php';

startUserSession();

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
    $commentid = (int)$_POST['id'];
    $comment = getComment($pdo, $commentid);
    
    if (!$comment) {
        header('Location: index.php');
        exit;
    }
    
    $currentUser = getCurrentUser();
    $question = getQuestion($pdo, $comment['questionid']);
    
    // Check if user owns the comment, owns the question, or is admin
    if ($comment['userid'] != $currentUser['id'] && $question['userid'] != $currentUser['id'] && !isAdmin()) {
        header('HTTP/1.1 403 Forbidden');
        echo 'You cannot delete this comment.';
        exit;
    }
    
    deleteComment($pdo, $commentid);
    header('Location: question.php?id=' . $comment['questionid']);
    exit;
}

// If accessed via GET or without POST id, redirect to index
header('Location: index.php');
exit;
?>
