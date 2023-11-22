<?php

$json = file_get_contents('php://input');
if (empty($json)) {
    header("Location: /");
    exit;
}

$data = json_decode($json, true);

$stmt = $db->prepare("INSERT INTO tables (name, user_id) VALUES (?, ?)");
$stmt->execute([
    $data['tableName'],
    $_SESSION['user_id'],
]);

$stmt = $db->prepare("SELECT id, name FROM tables WHERE name = ? AND user_id = ? ORDER BY id DESC");
$stmt->execute([
    $data['tableName'],
    $_SESSION['user_id'],
]);

http_response_code(201);
header('Content-type: application/json');
echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
exit;
