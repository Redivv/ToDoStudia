<?php

if (!$_GET['taskId']) {
    header("Location: /");
    exit;
}

$db = new PDO("mysql:dbname=todo", 'todo', 'admin');
$stmt = $db->prepare("SELECT t1.id FROM tasks t1 JOIN TABLES t2 ON t1.table_id = t2.id WHERE t1.id = ? AND t2.user_id = ?");
$stmt->execute([
    $_GET['taskId'],
    $_SESSION['user_id']
]);
$verifiedTaskId = $stmt->fetch(PDO::FETCH_COLUMN);

$stmt = $db->prepare("DELETE FROM tasks WHERE id = ?");
$stmt->execute([
    $verifiedTaskId,
]);

http_response_code(204);
exit;
