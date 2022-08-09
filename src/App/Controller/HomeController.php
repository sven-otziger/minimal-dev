<?php

namespace Controller;

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
        $id = $_SESSION['id'];
        $username = $this->userRepo->getUsernameById($id);
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