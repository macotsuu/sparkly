<?php

namespace Volcano\Handlers;

use Volcano\Cache\Cache;

class MainPageHandler extends AbstractHandler
{
    public function beforeAction()
    {
        if (!isset($_SESSION['user'])) {
            redirect('/authorize');
        }
    }

    public function action()
    {
        $result = Cache::cache()->get(__CLASS__);

        if ($result === false) {
            $result = require_once BFST_DIR_CORE . 'mainpage.php';
            Cache::cache()->set(__CLASS__ . $result, 15);
        }

        return $result;
    }
}
