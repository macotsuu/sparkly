<?php

namespace Volcano\Http;

class Request
{


    private string $method;
    private array $headers;

    public function __construct()
    {
        foreach ($_SERVER as $key => $value) {
            $this->headers[$key] = $value;
        }

        $this->setMethod($this->getHeader('REQUEST_METHOD'));
    }

    /**
     * @param string $method
     * @return $this
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getHeader(string $key): mixed
    {
        if (!isset($this->headers[$key])) {
            return null;
        }

        return $this->headers[$key];
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function uri(): Uri
    {
        return new Uri(
            sprintf(
                '%s://%s%s',
                isset($this->headers['HTTPS']) ? 'https' : 'http',
                $this->headers['HTTP_HOST'] ?? 'localhost',
                $this->headers['REQUEST_URI'] ?? '/'
            )
        );
    }
}
