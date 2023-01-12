<?php

namespace Volcano\Http;

class Request
{

    public array $headers;
    public string $method;

    public function __construct()
    {
        $this->headers = $_SERVER;
        $this->method = filter_input(INPUT_SERVER, 'REQUEST_METHOD') ?: 'GET';
    }

    public function uri(): Uri
    {
        return new Uri(
            sprintf(
                '%s://%s%s',
                isset($this->headers['HTTPS']) ? 'https' : 'http',
                $this->headers['HTTP_HOST'],
                $this->headers['REQUEST_URI']
            )
        );
    }
}
