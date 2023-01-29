<?php

namespace Volcano\Foundation;

use Exception;
use Volcano\Http\Response;

class Controller
{
    public function json($data): Response
    {
        return $this->createResponse(
            $data,
            ['Content-Type' => 'application/json;charset=utf8']
        );
    }

    /**
     * @param string $template
     * @param array $attributes
     * @return Response
     * @throws Exception
     */
    public function view(string $template, array $attributes = []): Response
    {
        return $this->createResponse(
            $this->renderView($template, $attributes),
            ['Content-Type' => 'text/html']
        );
    }

    /**
     * @param mixed $body
     * @param array $headers
     * @return Response
     */
    private function createResponse(mixed $body, array $headers = []): Response
    {
        return new Response($body, 200, $headers);
    }

    /**
     * @param string $template
     * @param array $attributes
     * @return string
     */
    private function renderView(string $template, array $attributes): string
    {
        return (new View())
            ->view($template)
            ->attributes($attributes)
            ->passable(get_called_class())
            ->render();
    }
}