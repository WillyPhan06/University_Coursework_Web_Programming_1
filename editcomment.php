<?php
require 'includes/DatabaseConnection.php';
require 'includes/DataBaseFunctions.php';

startUserSession();

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$commentid = (int)$_GET['id'];
$comment = getComment($pdo, $commentid);

if (!$comment) {
    header('Location: index.php');
    exit;
}

$currentUser = getCurrentUser();
if ($comment['userid'] != $currentUser['id'] && !isAdmin()) {
    header('HTTP/1.1 403 Forbidden');
    echo 'You cannot edit this comment.';
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = trim($_POST['text'] ?? '');
    
    if (empty($text)) {
        $error = 'Comment cannot be empty.';
    } elseif (strlen($text) > 5000) {
        $error = 'Comment is too long (max 5000 characters).';
    } else {
        try {
            updateComment($pdo, $commentid, $text);
            header('Location: question.php?id=' . $comment['questionid']);
            exit;
        } catch (Exception $e) {
            $error = 'Failed to update comment.';
        }
    }
}

$title = 'Edit Comment';
ob_start();
include 'templates/comment_form.php';
$output = ob_get_clean();
include 'templates/layout.php';
?>
