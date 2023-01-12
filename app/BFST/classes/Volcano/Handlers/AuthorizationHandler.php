<?php

namespace Volcano\Handlers;

class AuthorizationHandler extends AbstractHandler
{
    public function beforeAction()
    {
        if (isset($_SESSION['user'])) {
            redirect('/');
        }
    }

    /**
     * @inheritDoc
     */
    protected function action()
    {
        return include_once config()->path()->core . 'authorize.php';
    }
}
