<?php

namespace Controller;

use Repository\UserRepository;
use Test\ORM;

class DemoController extends Controller
{
    private UserRepository $userRepo;

    public function __construct(array $parameters, array $arguments)
    {
        $this->userRepo = new UserRepository();
        parent::__construct($parameters, $arguments);
    }

    public function orm(): void
    {
        $test = new ORM(3);

        echo "<pre>ORM Object: ";
        var_dump($test);
        echo "</pre>";
    }

    public function readUsers(): void
    {
        $data = $this->userRepo->findAllUsers();

        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        echo "<hr>";
    }

    public function readUserWhereUsernameLike($search): void
    {
        $data = $this->userRepo->findUserWhereUsernameLike($search);

        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }
}
