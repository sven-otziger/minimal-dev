<?php

namespace Controller;

use Enum\SessionStatus;
use Service\TwigService;
use Service\SessionService;
use Service\PermissionService;

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
            $sessionStatus = $this->sessionService->getSessionStatus();
            switch ($sessionStatus) {
                case SessionStatus::NotLoggedIn:
                case SessionStatus::Expired:
                case SessionStatus::Discontinued:
                    $this->twigService->renderTwigTemplate(
                        'login.html.twig', ['message' => $sessionStatus->value]
                    );
                    exit();
                case SessionStatus::LoggedIn:
                    break;
            }
        }
        call_user_func_array(array($this, $methodName), $arguments);
    }
}
