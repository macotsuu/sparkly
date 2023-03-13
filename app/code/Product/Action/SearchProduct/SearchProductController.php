<?php

namespace Sparkly\Product\Action\SearchProduct;

use React\Http\Message\Response;
use Sparkly\Framework\Database\ORM\EntityManager;

class SearchProductController
{
    public function __invoke(EntityManager $entityManager): Response
    {
        return Response::html('OK');
    }
}
