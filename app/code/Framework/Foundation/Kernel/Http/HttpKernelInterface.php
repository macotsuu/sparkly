<?php

namespace Sparkly\Framework\Foundation\Kernel\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface HttpKernelInterface
{
    /**
     * Handle HTTP Request
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request): ResponseInterface;
}
