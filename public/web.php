<?php

use React\Http\HttpServer;
use React\Socket\SocketServer;
use Sparkly\Framework\Foundation\Kernel;

require_once __DIR__ . '/../app/bootstrap.php';

$sparkly = Kernel::getInstance();
$sparkly->bootstrap();

$http = new HttpServer($sparkly->make('http.kernel'));
$http->on('error', function (Exception|TypeError $e) {
    sparkly('logger')->error($e->getMessage());
    sparkly('logger')->error($e->getTraceAsString());
})->listen(new SocketServer('0.0.0.0:8080'));
