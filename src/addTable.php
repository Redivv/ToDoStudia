<?php

$json = file_get_contents('php://input');
if (empty($json)) {
    header("Location: /");
    exit;
}

$data = json_decode($json, true);

$db = new PDO("mysql:dbname=todo", 'todo', 'admin');
$stmt = $db->prepare("INSERT INTO tables (name, user_id) VALUES (?, ?)");
$stmt->execute([
    $data['tableName'],
    $_SESSION['user_id']
]);

http_response_code(201);
header('Content-type: application/json');
echo json_encode(['newTableName' => $data['tableName']]);
exit;