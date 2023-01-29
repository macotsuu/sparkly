<?php

namespace BFST\Order\Application\SearchOrder;

use Volcano\Foundation\Controller;
use Volcano\Http\Response;

class SearchOrderController extends Controller
{
    public function __invoke(SearchOrderAction $searchOrderAction): Response
    {
        return $this->json($searchOrderAction->handle());
    }

}