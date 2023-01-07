<?php

namespace Volcano\Handlers;

use Exception;

abstract class AbstractHandler
{
    public function __invoke()
    {
        if (method_exists($this, 'beforeAction')) {
            $this->beforeAction();
        }

        return $this->action();
    }

    /**
     * @return mixed
     * @throws Exception
     */
    abstract protected function action();

    /**
     * @return array
     * @throws Exception
     */
    public function getRequestBody(): array
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception(json_last_error_msg(), json_last_error());
        }

        return $input;
    }
}
