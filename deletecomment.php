<?php
require 'includes/DatabaseConnection.php';
require 'includes/DataBaseFunctions.php';

startUserSession();

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Accept id from POST (preferred) or GET (handle cases where JS/links are used)
$commentid = null;
if (!empty($_POST['id'])) {
    $commentid = (int)$_POST['id'];
} elseif (!empty($_GET['id'])) {
    $commentid = (int)$_GET['id'];
}

if ($commentid !== null) {
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
} else {
    // No id supplied - log and redirect back
    error_log('deletecomment.php called without id. REQUEST: ' . json_encode($_REQUEST));
    header('Location: index.php');
    exit;
}
?>
