<?php

$json = file_get_contents('php://input');
if (empty($json) || !$_GET['taskId']) {
    header("Location: /");
    exit;
}

$newTaskLevel = json_decode($json);
if (!is_numeric($newTaskLevel)) {
    http_response_code(406);
    exit;
}


$db = new PDO("mysql:dbname=todo", 'todo', 'admin');
$stmt = $db->prepare("SELECT t1.id FROM tasks t1 JOIN TABLES t2 ON t1.table_id = t2.id WHERE t1.id = ? AND t2.user_id = ?");
$stmt->execute([
    $_GET['taskId'],
    $_SESSION['user_id']
]);
$verifiedTaskId = $stmt->fetch(PDO::FETCH_COLUMN);

$stmt = $db->prepare("UPDATE tasks SET level = ? WHERE id = ?");
$stmt->execute([
    $newTaskLevel,
    $verifiedTaskId,
]);
http_response_code(200);
header('Content-type: application/json');
echo json_encode([
    "id" => $verifiedTaskId,
    "newLevel" => $newTaskLevel
]);
exit;
