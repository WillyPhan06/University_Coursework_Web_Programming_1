<?php
function query($pdo, $sql, $params = []) {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

function allQuestions($pdo) {
    $sql = "SELECT q.id, q.text AS questiontext, q.date, q.img, q.userid, q.moduleid,
                   m.name AS modulename, u.username AS username
            FROM question q
            LEFT JOIN module m ON q.moduleid = m.id
            LEFT JOIN `user` u ON q.userid = u.id
            ORDER BY q.date DESC";
    return query($pdo, $sql)->fetchAll();
}

function getQuestion($pdo, $id) {
    $sql = "SELECT q.*, m.name AS modulename, u.username AS username
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
    query($pdo, 'DELETE FROM question WHERE id = :id', [':id' => $id]);
}

function allModules($pdo) {
    return query($pdo, 'SELECT id, name FROM module ORDER BY name')->fetchAll();
}

?>
