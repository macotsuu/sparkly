<?php

namespace code\Product\Action\SearchProduct;

use React\Http\Message\Response;

class SearchProductController
{
    public function __invoke(): Response
    {
        return Response::html('OK');
    }
}
