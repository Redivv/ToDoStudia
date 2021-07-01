<?php

declare(strict_types=1);

$request = $_SERVER['REQUEST_URI'];
$pathWithoutParameters = strstr($request, '?', true);
$request = $pathWithoutParameters ? $pathWithoutParameters : $request;

switch ($request) {
   case '/':
      require __DIR__ . '/src/guards/anonGuard.php';
      require __DIR__ . '/views/forms.html';
      break;
   case '/register':
      require __DIR__ . '/src/guards/anonGuard.php';
      require __DIR__ . '/src/register.php';
      break;
   case '/login':
      require __DIR__ . '/src/guards/anonGuard.php';
      require __DIR__ . '/src/login.php';
      break;
   case '/todo':
      require __DIR__ . '/src/guards/authGuard.php';
      require __DIR__ . '/views/todo.html';
      break;
   case '/logout':
      require __DIR__ . '/src/guards/authGuard.php';
      require __DIR__ . '/src/logout.php';
      break;
   case '/getTables':
      require __DIR__ . '/src/guards/authGuard.php';
      require __DIR__ . '/src/getTables.php';
      break;
   case '/getTable':
      require __DIR__ . '/src/guards/authGuard.php';
      require __DIR__ . '/src/getTable.php';
      break;
   case '/addTable':
      require __DIR__ . '/src/guards/authGuard.php';
      require __DIR__ . '/src/addTable.php';
      break;
   case '/addTask':
      require __DIR__ . '/src/guards/authGuard.php';
      require __DIR__ . '/src/addTask.php';
      break;
   case '/editTaskName':
      require __DIR__ . '/src/guards/authGuard.php';
      require __DIR__ . '/src/editTaskName.php';
      break;
   case '/editTaskLevel':
      require __DIR__ . '/src/guards/authGuard.php';
      require __DIR__ . '/src/editTaskLevel.php';
      break;
   case '/moveTask':
      require __DIR__ . '/src/guards/authGuard.php';
      require __DIR__ . '/src/moveTask.php';
      break;
   case '/deleteTask':
      require __DIR__ . '/src/guards/authGuard.php';
      require __DIR__ . '/src/deleteTask.php';
      break;
   case '/deleteTable':
      require __DIR__ . '/src/guards/authGuard.php';
      require __DIR__ . '/src/deleteTable.php';
      break;
   case '/editTable':
      require __DIR__ . '/src/guards/authGuard.php';
      require __DIR__ . '/src/editTable.php';
      break;
   default:
      http_response_code(404);
      require __DIR__ . '/views/404.html';
      break;
}
