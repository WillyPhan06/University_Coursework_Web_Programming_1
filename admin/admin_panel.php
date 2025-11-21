<?php
require __DIR__ . '/../includes/DatabaseConnection.php';
require __DIR__ . '/../includes/DataBaseFunctions.php';

startUserSession();

if (!isAdmin()) {
    header('HTTP/1.1 403 Forbidden');
    echo 'Access denied. Admin only.';
    exit;
}

$allUsers = getAllUsers($pdo);
$allModules = allModules($pdo);
$allQuestions = allQuestions($pdo);

// Get all comments
$sql = "SELECT c.id, c.text, c.date, c.userid, c.questionid, u.username, u.name, q.text AS questiontext
        FROM comment c
        LEFT JOIN `user` u ON c.userid = u.id
        LEFT JOIN question q ON c.questionid = q.id
        ORDER BY c.date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$allComments = $stmt->fetchAll();

$successMessage = '';
$errorMessage = '';

// Handle deletions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['action'])) {
        try {
            switch ($_POST['action']) {
                case 'delete_user':
                    if (!empty($_POST['user_id'])) {
                        deleteUser($pdo, (int)$_POST['user_id']);
                        $successMessage = 'User deleted successfully.';
                    }
                    break;
                    
                case 'delete_question':
                    if (!empty($_POST['question_id'])) {
                        deleteQuestion($pdo, (int)$_POST['question_id']);
                        $successMessage = 'Question deleted successfully.';
                    }
                    break;
                    
                case 'delete_comment':
                    if (!empty($_POST['comment_id'])) {
                        deleteComment($pdo, (int)$_POST['comment_id']);
                        $successMessage = 'Comment deleted successfully.';
                    }
                    break;
                    
                case 'delete_module':
                    if (!empty($_POST['module_id'])) {
                        deleteModule($pdo, (int)$_POST['module_id']);
                        $successMessage = 'Module deleted successfully.';
                    }
                    break;
            }
            
            // Refresh data after modification
            if (!empty($successMessage)) {
                $allUsers = getAllUsers($pdo);
                $allModules = allModules($pdo);
                $allQuestions = allQuestions($pdo);
                $sql = "SELECT c.id, c.text, c.date, c.userid, c.questionid, u.username, u.name, q.text AS questiontext
                        FROM comment c
                        LEFT JOIN `user` u ON c.userid = u.id
                        LEFT JOIN question q ON c.questionid = q.id
                        ORDER BY c.date DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $allComments = $stmt->fetchAll();
            }
        } catch (Exception $e) {
            $errorMessage = 'Error: ' . $e->getMessage();
        }
    }
}

$title = 'Admin Panel';
ob_start();
include __DIR__ . '/../templates/admin_panel.php';
$output = ob_get_clean();
include __DIR__ . '/../templates/layout.php';
?>
