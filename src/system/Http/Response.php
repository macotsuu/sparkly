<?php

namespace Sparkly\System\Http;
class Response
{
    /** @var int $httpCode */
    private int $httpCode;

    /** @var array $headers */
    private array $headers = [];
    /** @var string $responseBody */
    private string $responseBody;

    public function __construct(mixed $body = "", int $httpCode = 200, array $headers = [])
    {
        $this->setHttpCode($httpCode);
        $this->setResponseBody($body);
        $this->setHeaders($headers);
    }

    /**
     * @param int $code
     * @return $this
     */
    public function setHttpCode(int $code): self
    {
        $this->httpCode = $code;
        return $this;
    }

    /**
     * @param string|array $responseBody
     * @return $this
     */
    public function setResponseBody(string|array $responseBody): self
    {
        if (is_array($responseBody)) {
            $responseBody = json_encode($responseBody);
        }

        $this->responseBody = $responseBody;

        return $this;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = array_merge($headers, $this->headers);

        return $this;
    }

    /**
     * @return void
     */
    public function respond(): void
    {
        $this->sendHeaders();
        $this->sendBody();
    }

    /**
     * @return void
     */
    private function sendHeaders(): void
    {
        if (headers_sent()) {
            return;
        }

        foreach ($this->headers as $header => $value) {
            header("$header: $value", true);
        }
    }

    /**
     * @return void
     */
    private function sendBody(): void
    {
        echo $this->responseBody;
    }
}