<?php

namespace Sparkly\Core\HttpKernel;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface HttpKernelInterface
{
    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request): ResponseInterface;
}
