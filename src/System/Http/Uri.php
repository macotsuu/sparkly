<?php

namespace Sparkly\System\Http;

class Uri
{
    public string $host = '';
    public string $path = '';
    public string $query = '';

    public function __construct(string $uri)
    {
        $parts = parse_url($uri);

        if (isset($parts['host'])) {
            $this->host = $parts['host'];
        }

        if (isset($parts['path'])) {
            $this->path = $parts['path'];
        }

        if (isset($parts['query'])) {
            $this->query = $parts['query'];
        }
    }
}
