<?php

namespace Volcano\Callback;

use Exception;

final class Callback
{
    public function __construct(
        private readonly string $instance,
        private readonly string $method = '__invoke'
    )
    {

    }

    /**
     * @return void
     * @throws Exception
     */
    public function execute(): void
    {
        $response = call_user_func([new $this->instance, $this->method]);

        if (is_array($response) || is_object($response)) {
            $json = json_encode($response);

            if (json_last_error()) {
                throw new Exception(json_last_error_msg(), json_last_error());
            }
            $response = $json;
        }

        echo $response;
    }

}