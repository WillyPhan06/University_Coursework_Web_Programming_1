<?php
require 'includes/DatabaseConnection.php';
require 'includes/DataBaseFunctions.php';

startUserSession();

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$modules = allModules($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $imageFileName = null;
        if (!empty($_FILES['questionimage']) && $_FILES['questionimage']['error'] !== UPLOAD_ERR_NO_FILE) {
            $file = $_FILES['questionimage'];
            $allowed = ['image/jpeg', 'image/png', 'image/gif'];
            if ($file['error'] === UPLOAD_ERR_OK && in_array(mime_content_type($file['tmp_name']), $allowed)) {
                if ($file['size'] <= 3 * 1024 * 1024) {
                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $imageFileName = uniqid('qimg_', true) . '.' . $ext;
                    $destination = __DIR__ . '/images/' . $imageFileName;
                    move_uploaded_file($file['tmp_name'], $destination);
                } else {
                    throw new Exception('Image is too large (max 3MB).');
                }
            } else {
                throw new Exception('Invalid image uploaded.');
            }
        }

        $moduleid = !empty($_POST['moduleid']) ? $_POST['moduleid'] : null;
        $userid = getCurrentUser()['id'];
        insertQuestion($pdo, $_POST['questiontext'], $userid, $moduleid, $imageFileName);
        header('Location: index.php');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$title = 'Add Question';
ob_start();
include 'templates/question_form.php';
$output = ob_get_clean();
include 'templates/layout.php';
?>