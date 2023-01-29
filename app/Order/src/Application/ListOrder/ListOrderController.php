<?php

namespace BFST\Order\Application\ListOrder;

use Volcano\Foundation\Controller;
use Volcano\Http\Response;

class ListOrderController extends Controller
{
    public function __invoke(): Response
    {
        return $this->view('ord_list.php');
    }
}