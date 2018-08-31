<?php

require_once __DIR__ . '/vendor/autoload.php';

$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection(
    'localhost',
    '5672',
    'guest',
    'guest'
);
$chanel = $connection->channel();
$chanel->exchange_declare('logs', 'fanout', false, false, false);

$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = "info: Hello World!";
}
$msg = new \PhpAmqpLib\Message\AMQPMessage($data);

$chanel->basic_publish($msg, 'logs');

$chanel->close();
$connection->close();
