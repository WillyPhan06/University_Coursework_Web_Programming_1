<?php
// Database connection for the coursework app
// Adjust credentials if your MySQL root user uses a password
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=cw_train;charset=utf8mb4', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // In production you might log the error instead
    die('Database connection failed: ' . $e->getMessage());
}

?>
