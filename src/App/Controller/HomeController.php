<?php

namespace Controller;

use Handler\SessionHandler;
use Repository\UserRepository;

class HomeController extends Controller
{
    private UserRepository $userRepo;

    public function __construct(array $parameters, array $arguments)
    {
        $this->userRepo = new UserRepository();
        parent::__construct($parameters, $arguments);
    }

    public function home():void
    {
        $id = SessionHandler::getId();
        $username = SessionHandler::getUsername();
        $permissions = $this->permissionHandler->getPermissions($id);

        $data = [
            'username' => $username,
            'permissions' => $permissions
        ];

//        echo "<pre>";
//        var_dump($data);
//        echo "</pre>";
//        die();

        $this->twigHandler::renderTwigTemplate('home.html.twig', $data);
    }
}