<?php

$json = file_get_contents('php://input');
if (empty($json)) {
    header("Location: /");
    exit;
}
$data = json_decode($json, true);
if (!in_array($data['columnNumber'], range(1, 4))) {
    http_response_code(400);
    exit;
}

$db = new PDO("mysql:dbname=todo", 'todo', 'admin');
$stmt = $db->prepare("SELECT t1.id FROM tasks t1 JOIN TABLES t2 ON t1.table_id = t2.id WHERE t1.id = ? AND t2.user_id = ?");
$stmt->execute([
    $data['taskId'],
    $_SESSION['user_id']
]);
$verifiedTaskId = $stmt->fetch(PDO::FETCH_COLUMN);

$stmt = $db->prepare("UPDATE tasks SET column_number = ? WHERE id = ?");
$stmt->execute([
    $data['columnNumber'],
    $verifiedTaskId,
]);


http_response_code(204);
exit;
