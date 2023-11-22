<?php

$json = file_get_contents('php://input');
if (empty($json) || !$_GET['tableId']) {
    header("Location: /");
    exit;
}



$stmt = $db->prepare("UPDATE tables SET name = ? WHERE id = ? AND user_id = ?");
$newTableName = json_decode($json);
$stmt->execute([
    $newTableName,
    $_GET['tableId'],
    $_SESSION['user_id']
]);
http_response_code(200);
header('Content-type: application/json');
echo json_encode([
    "id" => $_GET['tableId'],
    "newName" => $newTableName
]);
exit;
