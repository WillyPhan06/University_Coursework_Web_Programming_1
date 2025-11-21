<?php
require __DIR__ . '/../includes/DatabaseConnection.php';
require __DIR__ . '/../includes/DataBaseFunctions.php';

startUserSession();

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

if (!isset($_GET['qid']) || !is_numeric($_GET['qid'])) {
    header('Location: ../index.php');
    exit;
}

$questionid = (int)$_GET['qid'];
$question = getQuestion($pdo, $questionid);

if (!$question) {
    header('Location: ../index.php');
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
            $user = getCurrentUser();
            if (!$user || !isset($user['id']) || $user['id'] <= 0) {
                $error = 'User session error. Please log in again.';
            } else {
                insertComment($pdo, $text, $user['id'], $questionid);
                header('Location: ../question.php?id=' . $questionid);
                exit;
            }
        } catch (Exception $e) {
            error_log('Comment insertion error: ' . $e->getMessage());
            $error = 'Failed to add comment.';
        }
    }
}

$title = 'Add Comment';
ob_start();
include __DIR__ . '/../templates/comment_form.php';
$output = ob_get_clean();
include __DIR__ . '/../templates/layout.php';
?>
