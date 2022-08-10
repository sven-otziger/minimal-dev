<?php

namespace Controller;

use Handler\SessionHandler;
use Repository\UserRepository;

class HomeController extends Controller
{
    public function __construct(array $parameters, array $arguments)
    {
        parent::__construct($parameters, $arguments);
    }

    public function home():void
    {
        $id = $this->sessionHandler->getId();
        $username = $this->sessionHandler->getUsername();
        $permissions = $this->permissionHandler->getPermissions($id);

        $data = [
            'username' => $username,
            'permissions' => $permissions
        ];
        $this->twigHandler->renderTwigTemplate('home.html.twig', $data);
    }
}