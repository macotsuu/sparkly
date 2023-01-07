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
        return require_once BFST_DIR_CORE . 'authorize.php';
    }
}
