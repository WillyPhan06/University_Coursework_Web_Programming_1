<?php
require __DIR__ . '/../includes/DatabaseConnection.php';
require __DIR__ . '/../includes/DataBaseFunctions.php';

if (!isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

$modules = allModules($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = $_POST['id'];
        $imageFileName = null;
        if (!empty($_FILES['questionimage']) && $_FILES['questionimage']['error'] !== UPLOAD_ERR_NO_FILE) {
            $file = $_FILES['questionimage'];
            $allowed = ['image/jpeg', 'image/png', 'image/gif'];
            if ($file['error'] === UPLOAD_ERR_OK && in_array(mime_content_type($file['tmp_name']), $allowed)) {
                if ($file['size'] <= 3 * 1024 * 1024) {
                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $imageFileName = uniqid('qimg_', true) . '.' . $ext;
                    $destination = __DIR__ . '/../images/' . $imageFileName;
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
        header('Location: ../question.php?id=' . $id);
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
} else {
    $question = getQuestion($pdo, $_GET['id']);
    if (!$question) {
        header('Location: ../index.php');
        exit;
    }
}

$title = 'Edit Question';
ob_start();
include __DIR__ . '/../templates/question_form.php';
$output = ob_get_clean();
include __DIR__ . '/../templates/layout.php';
?>
