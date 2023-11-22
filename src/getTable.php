<?php
if (!$_GET['tableId']) {
    header("Location: /");
    exit;
}


$stmt = $db->prepare("SELECT id, name FROM tables WHERE id = ?");
$stmt->execute([
    $_GET['tableId']
]);
$tableData = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $db->prepare("SELECT id, title, column_number, level FROM tasks WHERE table_id = ? ORDER BY title");
$stmt->execute([
    $tableData['id']
]);
$tasksByColumnNumber = sortTasksByColumnNumber($stmt->fetchAll(PDO::FETCH_ASSOC));

$jsonResponse = json_encode([
    "tableData" => $tableData, 
    "tasks" => $tasksByColumnNumber
]);
http_response_code(200);
header('Content-type: application/json');
echo $jsonResponse;
exit;


function sortTasksByColumnNumber(array $tasks): array{
    $sortedTasks = [
        1 => [],
        2 => [],
        3 => [],
        4 => []
    ];
    foreach($tasks as $task){
        $sortedTasks[(int)$task['column_number']][] = $task;
    }
    return $sortedTasks;
}
