<?php

namespace Controller;

use Repository\LoginRepository;
use Session\SessionHandler;
use Twig\Error\Error;

class LoginController extends Controller
{
    private LoginRepository $loginRepo;

    public function __construct(array $parameters, array $arguments)
    {
        $this->loginRepo = new LoginRepository();
        parent::__construct($parameters, $arguments);
    }

    public function loginForm(): void
    {
        $this->renderLoginForm(false);
    }

    public function login(array $payload): void
    {
        $username = $payload['username'];
        $password = $payload['password'];

        $id = $this->loginRepo->getUserIdByName($username);

//        user does not exist
        if (is_null($id)) {
            $this->renderLoginForm(true);
            return;
        }

        $dbUsername = $this->loginRepo->getUsernameById($id);
        $dbPassword = $this->loginRepo->getPasswordById($id);

        if ($username === $dbUsername && $password === $dbPassword) {

            $this->sessionHandler::createSession($id);

            header('Location: profile');
        } else {
//            password does not match username
            $this->renderLoginForm(true);
        }
    }

    private function renderLoginForm(bool $withErrorMessage): void
    {
        $message = '';
        if ($withErrorMessage) {
            $message = 'The username or password is incorrect.';
        }

        try {
            echo $this->twig->render('login.html.twig', ['message' => $message]);
        } catch (Error $e) {
            echo $e->getTraceAsString();
        }
    }
}