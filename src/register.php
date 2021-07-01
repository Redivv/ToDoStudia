<?php

declare(strict_types=1);
if (!isset($_POST['username']) && !isset($_POST['password'])) {
   header("Location: /todo");
   exit;
}

$db = new PDO("mysql:dbname=todo", 'todo', 'admin');
$stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([
   $_POST['username']
]);
if (!empty($stmt->fetchAll())) {
   echo 'Podana nazwa użytkownika jest już zajęta.<br>';
   echo "<a href='/'>Wróć do strony rejestracji</a>";
   exit;
}
$stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->execute([
   $_POST['username'],
   password_hash($_POST['password'], PASSWORD_DEFAULT)
]);
$stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([
   $_POST['username']
]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


$_SESSION['AUTH'] = $_POST['username'];
$_SESSION['user_id'] = $user['id'];
header("Location: /todo");
exit;
