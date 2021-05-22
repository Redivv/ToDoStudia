<?php

declare(strict_types=1);

session_start();

$loggedInCondition = isset($_SESSION['AUTH']) && !empty($_SESSION['AUTH']);
if (!$loggedInCondition) {
   header('location: /');
   exit;
}
