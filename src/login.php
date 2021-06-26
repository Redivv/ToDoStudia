<?php

declare(strict_types=1);
if (!isset($_POST['username']) && !isset($_POST['password'])) {
   header("Location: /");
   exit;
}

$db = new PDO("mysql:dbname=todo", 'todo', 'admin');
$stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([
   $_POST['username']
]);
if (empty($user = $stmt->fetch(PDO::FETCH_ASSOC))) {
   displayErrorInformationWithLinkAndExit();
}
if (!password_verify($_POST['password'], $user['password'])) {
   displayErrorInformationWithLinkAndExit();
}
$_SESSION['AUTH'] = $_POST['username'];
$_SESSION['user_id'] = $user['id'];
header("Location: /todo");
exit;

function displayErrorInformationWithLinkAndExit()
{
   echo 'Błędne dane.<br>';
   echo "<a href='/'>Wróć do strony logowania</a>";
   exit;
}
