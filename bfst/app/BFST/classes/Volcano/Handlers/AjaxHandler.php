<?php

namespace Volcano\Handlers;

use RuntimeException;

class AjaxHandler extends AbstractHandler
{
    public function beforeAction()
    {
        if (!isset($_SESSION['user'])) {
            redirect('/authorize');
        }
    }

    public function action()
    {
        $requestBody = $this->getRequestBody();

        [$class, $method] = explode('::', $requestBody['function']);
        if (!class_exists($class)) {
            if ($method) {
                $class .= '::' . $method . '()';
            }

            throw new RuntimeException(sprintf('Callable %s does not exist', $class));
        }

        return call_user_func([new $class, $method], ...$requestBody['arguments'] ?? []);
    }
}
