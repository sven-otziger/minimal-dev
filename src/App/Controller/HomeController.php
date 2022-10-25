<?php

namespace Controller;

use Service\SessionService;
use Repository\UserRepository;

class HomeController extends Controller
{
    public function __construct(array $parameters, array $arguments)
    {
        parent::__construct($parameters, $arguments);
    }

    public function home():void
    {
        $id = $this->sessionService->getId();
        $username = $this->sessionService->getUsername();
        $permissions = $this->permissionService->getPermissions($id);

        $data = [
            'username' => $username,
            'permissions' => $permissions
        ];
        $this->twigService->renderTwigTemplate('home.html.twig', $data);
    }
}