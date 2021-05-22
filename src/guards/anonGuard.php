<?php

declare(strict_types=1);

session_start();

$anonymousCondition = !isset($_SESSION['AUTH']) || empty($_SESSION['AUTH']);
if (!$anonymousCondition) {
   header('location: /todo');
   exit;
}
