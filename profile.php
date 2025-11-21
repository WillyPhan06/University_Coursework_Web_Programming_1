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

// Get user's questions
$sql = "SELECT q.id, q.text AS questiontext, q.date, q.img, q.moduleid,
               m.name AS modulename
        FROM question q
        LEFT JOIN module m ON q.moduleid = m.id
        WHERE q.userid = :userid
        ORDER BY q.date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([':userid' => $user['id']]);
$userQuestions = $stmt->fetchAll();

// Get user's comments
$sql = "SELECT c.id, c.text, c.date, q.id AS questionid, q.text AS questiontext
        FROM comment c
        JOIN question q ON c.questionid = q.id
        WHERE c.userid = :userid
        ORDER BY c.date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([':userid' => $user['id']]);
$userComments = $stmt->fetchAll();

$title = "Profile - " . htmlspecialchars($user['name']);
ob_start();
include 'templates/user_profile.php';
$output = ob_get_clean();
include 'templates/layout.php';
?>
