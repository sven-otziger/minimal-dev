<?php

namespace Controller;

use Service\TwigService;
use Service\SessionService;
use Service\PermissionService;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    protected TwigService $twigService;
    protected SessionService $sessionService;
    protected PermissionService $permissionService;

    public function __construct(array $parameters, array $arguments)
    {
        $this->twigService = TwigService::getTwigService();
        $this->sessionService = SessionService::getSessionService();
        $this->permissionService = PermissionService::getPermissionService();

        $methodName = $parameters['_route'];
        $exceptions = [
            'renderSignupForm',
            'createUser'
        ];

        if (!$this instanceof LoginController && !in_array($methodName, $exceptions)){
            $this->sessionService->handleSession();
        }
        call_user_func_array(array($this, $methodName), $arguments);
    }
}
