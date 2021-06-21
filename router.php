<?php

declare(strict_types=1);

$request = $_SERVER['REQUEST_URI'];

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
   case '/addTable':
      require __DIR__ . '/src/guards/authGuard.php';
      require __DIR__ . '/src/addTable.php';
      break;
   case '/info':
      echo phpinfo();
      break;
   default:
      http_response_code(404);
      require __DIR__ . '/views/404.html';
      break;
}
