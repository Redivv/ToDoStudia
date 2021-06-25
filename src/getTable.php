<?php

if ($_GET['tableId']) {
    $db = new PDO("mysql:dbname=todo", 'todo', 'admin');
    $stmt = $db->prepare("SELECT name FROM tables WHERE id = ?");
    $stmt->execute([
        $_GET['tableId']
    ]);
    $jsonResponse = json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    http_response_code(200);
    header('Content-type: application/json');
    echo $jsonResponse;
}
exit;
