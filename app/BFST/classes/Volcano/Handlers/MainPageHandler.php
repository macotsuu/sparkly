<?php

namespace Volcano\Handlers;

class MainPageHandler extends AbstractHandler
{
    public function beforeAction()
    {
        if (!isset($_SESSION['user'])) {
            //redirect('/authorize');
        }
    }

    public function action()
    {
        $result = cache()->get(__CLASS__);

        if ($result === false) {
            ob_start();
            require_once config()->path()->core . 'mainpage.php';
            $result = ob_get_clean();

            cache()->set(__CLASS__ . $result, 15);
        }

        return $result;
    }
}
