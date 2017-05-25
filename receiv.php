<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$callback = function ($msg) {
    $data = json_decode($msg->body, true);
    echo "id: ". $data['id']. "\n";
};

$channel->basic_consume('input', '', false, true, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}
