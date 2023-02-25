<?php

use React\Http\HttpServer;
use React\Socket\SocketServer;
use Sparkly\Core\HttpKernel\HttpKernel;
use Sparkly\Framework\Kernel\Kernel;

require_once __DIR__ . '/../app/bootstrap.php';

$kernel = Kernel::getInstance();
$kernel->boot();

$http = new HttpServer(new HttpKernel($kernel));
$http->on('error', function (Exception|TypeError $e) {
    sparkly('logger')->error($e->getMessage());
    sparkly('logger')->error($e->getTraceAsString());
})->listen(new SocketServer('0.0.0.0:8080'));
