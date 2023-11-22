<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'todo', 'todo');
$rabbit = $connection->channel();
