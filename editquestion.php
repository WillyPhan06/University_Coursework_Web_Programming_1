<?php
require 'includes/DatabaseConnection.php';
require 'includes/DataBaseFunctions.php';

startUserSession();

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$modules = allModules($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = $_POST['id'];
        $currentUser = getCurrentUser();
        $question = getQuestion($pdo, $id);
        
        if (!$question) {
            header('Location: index.php');
            exit;
        }
        
        // Check ownership - only owner can edit
        if ($question['userid'] != $currentUser['id']) {
            header('HTTP/1.1 403 Forbidden');
            echo 'You cannot edit this question.';
            exit;
        }
        
        $imageFileName = null;
        if (!empty($_FILES['questionimage']) && $_FILES['questionimage']['error'] !== UPLOAD_ERR_NO_FILE) {
            $file = $_FILES['questionimage'];
            $allowed = ['image/jpeg', 'image/png', 'image/gif'];
            if ($file['error'] === UPLOAD_ERR_OK && in_array(mime_content_type($file['tmp_name']), $allowed)) {
                if ($file['size'] <= 3 * 1024 * 1024) {
                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $imageFileName = uniqid('qimg_', true) . '.' . $ext;
                    $destination = __DIR__ . '/images/questions/' . $imageFileName;
                    move_uploaded_file($file['tmp_name'], $destination);
                } else {
                    throw new Exception('Image is too large (max 3MB).');
                }
            } else {
                throw new Exception('Invalid image uploaded.');
            }
        } else {
            // keep existing image if any
            $existing = getQuestion($pdo, $id);
            $imageFileName = $existing['img'] ?? null;
        }

        updateQuestion($pdo, $id, $_POST['questiontext'], $_POST['moduleid'] ?: null, $imageFileName);
        
        // Redirect with success message
        header('Location: question.php?id=' . $id . '&success=question_updated');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
} else {
    $currentUser = getCurrentUser();
    $question = getQuestion($pdo, $_GET['id']);
    if (!$question) {
        header('Location: index.php');
        exit;
    }
    
    // Check ownership - only owner can edit
    if ($question['userid'] != $currentUser['id']) {
        header('HTTP/1.1 403 Forbidden');
        echo 'You cannot edit this question.';
        exit;
    }
}

$title = 'Edit Question';
ob_start();
include 'templates/question_form.php';
$output = ob_get_clean();
include 'templates/layout.php';
?>