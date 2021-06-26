<?php

if ($_GET['tableId']) {
    $db = new PDO("mysql:dbname=todo", 'todo', 'admin');
    $stmt = $db->prepare("DELETE FROM tables WHERE id = ? AND user_id = ?");
    $stmt->execute([
        $_GET['tableId'],
        $_SESSION['user_id']
    ]);
    http_response_code(204);
    header('Content-type: application/json');
}
exit;