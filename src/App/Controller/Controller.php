<?php

namespace Controller;

use Twig\Environment;
use Handler\TwigHandler;
use Handler\SessionHandler;
use Handler\PermissionHandler;
use Twig\Loader\FilesystemLoader;

class Controller
{
    protected TwigHandler $twigHandler;
    protected SessionHandler $sessionHandler;
    protected PermissionHandler $permissionHandler;

    public function __construct(array $parameters, array $arguments)
    {
        $this->twigHandler = TwigHandler::getTwigHandler();
        $this->sessionHandler = SessionHandler::getSessionHandler();
        $this->permissionHandler = PermissionHandler::getPermissionHandler();

        // function call
        call_user_func_array(array($this, $parameters['_route']), $arguments);
    }
}
