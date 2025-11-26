<?php
// Session management
function startUserSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function getCurrentUser() {
    startUserSession();
    return $_SESSION['user'] ?? null;
}

function isLoggedIn() {
    startUserSession();
    return isset($_SESSION['user']);
}

function isAdmin() {
    startUserSession();
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

// Auth functions
function registerUser($pdo, $username, $name, $email, $password) {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO `user` (username, name, email, password) VALUES (:username, :name, :email, :password)";
    query($pdo, $sql, [
        ':username' => $username,
        ':name' => $name,
        ':email' => $email,
        ':password' => $hashedPassword
    ]);
    return $pdo->lastInsertId();
}

function loginUser($pdo, $username, $password) {
    $sql = "SELECT id, username, name, email, password, role, avatar FROM `user` WHERE username = :username";
    $stmt = query($pdo, $sql, [':username' => $username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        unset($user['password']);
        startUserSession();
        $_SESSION['user'] = $user;
        return true;
    }
    return false;
}

function logoutUser() {
    startUserSession();
    unset($_SESSION['user']);
    session_destroy();
}

function getUserById($pdo, $id) {
    $sql = "SELECT id, username, name, email, role, avatar, created_at FROM `user` WHERE id = :id";
    return query($pdo, $sql, [':id' => $id])->fetch();
}

function getUserByUsername($pdo, $username) {
    $sql = "SELECT id, username, name, email, role, avatar, created_at FROM `user` WHERE username = :username";
    return query($pdo, $sql, [':username' => $username])->fetch();
}

function userExists($pdo, $username, $email) {
    $sql = "SELECT COUNT(*) as count FROM `user` WHERE username = :username OR email = :email";
    $result = query($pdo, $sql, [':username' => $username, ':email' => $email])->fetch();
    return $result['count'] > 0;
}

function getAllUsers($pdo) {
    $sql = "SELECT id, username, name, email, role, avatar, created_at FROM `user` ORDER BY created_at DESC";
    return query($pdo, $sql)->fetchAll();
}

function deleteUser($pdo, $id) {
    query($pdo, 'DELETE FROM `user` WHERE id = :id', [':id' => $id]);
}

function updateUserRole($pdo, $id, $role) {
    // Convert role to lowercase for case-insensitivity
    $role = strtolower(trim($role));
    // Validate role
    if (!in_array($role, ['user', 'admin'])) {
        throw new Exception('Invalid role. Must be "user" or "admin".');
    }
    $sql = "UPDATE `user` SET role = :role WHERE id = :id";
    query($pdo, $sql, [':role' => $role, ':id' => $id]);
}

// Question functions
function query($pdo, $sql, $params = []) {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

function allQuestions($pdo) {
    $sql = "SELECT q.id, q.text AS questiontext, q.date, q.img, q.userid, q.moduleid,
                   m.name AS modulename, u.name AS name, u.username AS username, u.avatar
            FROM question q
            LEFT JOIN module m ON q.moduleid = m.id
            LEFT JOIN `user` u ON q.userid = u.id
            ORDER BY q.date DESC";
    return query($pdo, $sql)->fetchAll();
}

function getQuestion($pdo, $id) {
    $sql = "SELECT q.*, m.name AS modulename, u.name AS name, u.username AS username, u.avatar
            FROM question q
            LEFT JOIN module m ON q.moduleid = m.id
            LEFT JOIN `user` u ON q.userid = u.id
            WHERE q.id = :id";
    return query($pdo, $sql, [':id' => $id])->fetch();
}

function insertQuestion($pdo, $text, $userid = null, $moduleid = null, $img = null) {
    $sql = "INSERT INTO question SET `text` = :text, `date` = NOW(), userid = :userid, moduleid = :moduleid, img = :img";
    query($pdo, $sql, [
        ':text' => $text,
        ':userid' => $userid,
        ':moduleid' => $moduleid,
        ':img' => $img
    ]);
    return $pdo->lastInsertId();
}

function updateQuestion($pdo, $id, $text, $moduleid = null, $img = null) {
    $sql = "UPDATE question SET `text` = :text, moduleid = :moduleid, img = :img WHERE id = :id";
    query($pdo, $sql, [':text' => $text, ':moduleid' => $moduleid, ':img' => $img, ':id' => $id]);
}

function deleteQuestion($pdo, $id) {
    // Delete associated comments first
    query($pdo, 'DELETE FROM comment WHERE questionid = :id', [':id' => $id]);
    query($pdo, 'DELETE FROM question WHERE id = :id', [':id' => $id]);
}

// Comment functions
function insertComment($pdo, $text, $userid, $questionid) {
    $sql = "INSERT INTO comment (text, userid, questionid, date) VALUES (:text, :userid, :questionid, NOW())";
    query($pdo, $sql, [
        ':text' => $text,
        ':userid' => $userid,
        ':questionid' => $questionid
    ]);
    return $pdo->lastInsertId();
}

function getCommentsByQuestion($pdo, $questionid) {
    $sql = "SELECT c.id, c.text, c.date, c.userid, u.name AS name, u.username AS username, u.avatar
            FROM comment c
            LEFT JOIN `user` u ON c.userid = u.id
            WHERE c.questionid = :questionid
            ORDER BY c.date DESC";
    return query($pdo, $sql, [':questionid' => $questionid])->fetchAll();
}

function getComment($pdo, $id) {
    $sql = "SELECT c.id, c.text, c.date, c.userid, c.questionid, u.name AS name, u.username AS username, u.avatar
            FROM comment c
            LEFT JOIN `user` u ON c.userid = u.id
            WHERE c.id = :id";
    return query($pdo, $sql, [':id' => $id])->fetch();
}

function updateComment($pdo, $id, $text) {
    $sql = "UPDATE comment SET text = :text, date = NOW() WHERE id = :id";
    query($pdo, $sql, [':text' => $text, ':id' => $id]);
}

function deleteComment($pdo, $id) {
    query($pdo, 'DELETE FROM comment WHERE id = :id', [':id' => $id]);
}

// NEW FUNCTIONS FOR ADMIN PANEL
function getAllComments($pdo) {
    $sql = "SELECT c.id, c.text, c.date, c.userid, c.questionid, u.username, u.name, q.text AS questiontext
            FROM comment c
            LEFT JOIN `user` u ON c.userid = u.id
            LEFT JOIN question q ON c.questionid = q.id
            ORDER BY c.date DESC";
    return query($pdo, $sql)->fetchAll();
}

// NEW FUNCTIONS FOR USER PROFILE
function getUserQuestions($pdo, $userid) {
    $sql = "SELECT q.id, q.text AS questiontext, q.date, q.img, q.moduleid,
                   m.name AS modulename
            FROM question q
            LEFT JOIN module m ON q.moduleid = m.id
            WHERE q.userid = :userid
            ORDER BY q.date DESC";
    return query($pdo, $sql, [':userid' => $userid])->fetchAll();
}

function getUserComments($pdo, $userid) {
    $sql = "SELECT c.id, c.text, c.date, q.id AS questionid, q.text AS questiontext
            FROM comment c
            JOIN question q ON c.questionid = q.id
            WHERE c.userid = :userid
            ORDER BY c.date DESC";
    return query($pdo, $sql, [':userid' => $userid])->fetchAll();
}

// Module functions
function allModules($pdo) {
    return query($pdo, 'SELECT id, name FROM module ORDER BY name')->fetchAll();
}

function getModule($pdo, $id) {
    $sql = "SELECT id, name FROM module WHERE id = :id";
    return query($pdo, $sql, [':id' => $id])->fetch();
}

function insertModule($pdo, $name) {
    $sql = "INSERT INTO module (name) VALUES (:name)";
    query($pdo, $sql, [':name' => $name]);
    return $pdo->lastInsertId();
}

function updateModule($pdo, $id, $name) {
    $sql = "UPDATE module SET name = :name WHERE id = :id";
    query($pdo, $sql, [':name' => $name, ':id' => $id]);
}

function deleteModule($pdo, $id) {
    query($pdo, 'DELETE FROM module WHERE id = :id', [':id' => $id]);
}

?>