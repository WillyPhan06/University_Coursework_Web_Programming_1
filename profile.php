<?php
require 'includes/DatabaseConnection.php';
require 'includes/DataBaseFunctions.php';

startUserSession();

if (!isset($_GET['username'])) {
    header('Location: index.php');
    exit;
}

$username = $_GET['username'];
$user = getUserByUsername($pdo, $username);

if (!$user) {
    header('HTTP/1.1 404 Not Found');
    echo 'User not found';
    exit;
}

$currentUser = getCurrentUser();
$isOwnProfile = ($currentUser && $currentUser['id'] == $user['id']);

$successMessage = '';
$errorMessage = '';

// Handle avatar actions (only for own profile)
if ($isOwnProfile && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        try {
            switch ($_POST['action']) {
                case 'upload_avatar':
                    if (!empty($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
                        $file = $_FILES['avatar'];
                        $allowed = ['image/jpeg', 'image/png', 'image/gif'];
                        
                        if ($file['error'] === UPLOAD_ERR_OK && in_array(mime_content_type($file['tmp_name']), $allowed)) {
                            if ($file['size'] <= 2 * 1024 * 1024) { // 2MB limit for avatars
                                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                                $avatarFileName = uniqid('avatar_', true) . '.' . $ext;
                                $destination = __DIR__ . '/images/avatars/' . $avatarFileName;
                                
                                if (move_uploaded_file($file['tmp_name'], $destination)) {
                                    // Delete old avatar file if exists
                                    if (!empty($user['avatar'])) {
                                        $oldFile = __DIR__ . '/images/avatars/' . $user['avatar'];
                                        if (file_exists($oldFile)) {
                                            unlink($oldFile);
                                        }
                                    }
                                    
                                    updateUserAvatar($pdo, $user['id'], $avatarFileName);
                                    $successMessage = 'Avatar updated successfully!';
                                    
                                    // Refresh user data and session
                                    $user = getUserByUsername($pdo, $username);
                                    $_SESSION['user']['avatar'] = $avatarFileName;
                                } else {
                                    throw new Exception('Failed to upload avatar.');
                                }
                            } else {
                                throw new Exception('Avatar is too large (max 2MB).');
                            }
                        } else {
                            throw new Exception('Invalid image format. Use JPG, PNG, or GIF.');
                        }
                    }
                    break;
                    
                case 'delete_avatar':
                    if (!empty($user['avatar'])) {
                        $avatarFile = __DIR__ . '/images/avatars/' . $user['avatar'];
                        if (file_exists($avatarFile)) {
                            unlink($avatarFile);
                        }
                        deleteUserAvatar($pdo, $user['id']);
                        $successMessage = 'Avatar deleted successfully!';
                        
                        // Refresh user data and session
                        $user = getUserByUsername($pdo, $username);
                        $_SESSION['user']['avatar'] = null;
                    }
                    break;
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
        }
    }
}

// Get user's questions using database function
$userQuestions = getUserQuestions($pdo, $user['id']);

// Get user's comments using database function
$userComments = getUserComments($pdo, $user['id']);

$title = "Profile - " . htmlspecialchars($user['name']);
ob_start();
include 'templates/user_profile.php';
$output = ob_get_clean();
include 'templates/layout.php';
?>