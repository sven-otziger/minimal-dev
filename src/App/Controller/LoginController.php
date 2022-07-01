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
        $this->renderLoginForm(MessageType::None);
    }

    public function login(array $payload): void
    {
        $username = $payload['username'];
        $password = $payload['password'];

        $id = $this->loginRepo->getUserIdByName($username);

//        user does not exist
        if (is_null($id)) {
            $this->renderLoginForm(MessageType::LoginFailed);
            return;
        }

        $dbUsername = $this->loginRepo->getUsernameById($id);
        $dbPassword = $this->loginRepo->getPasswordById($id);

        if ($username === $dbUsername && $password === $dbPassword) {

            $this->sessionHandler::createSession($id);

            header('Location: profile');
        } else {
//            password does not match username
            $this->renderLoginForm(MessageType::LoginFailed);
        }
    }

    private function renderLoginForm(MessageType $type): void
    {
        $message = match ($type){
            MessageType::None => '',
            MessageType::LoginFailed => 'The username or password is incorrect.',
            MessageType::Logout => 'You have been logged out.'
        };

        try {
            echo $this->twig->render('login.html.twig', ['message' => $message]);
        } catch (Error $e) {
            echo $e->getTraceAsString();
        }
    }

    public function logout(array $payload): void
    {
        $this->sessionHandler::destroySession();
        $this->renderLoginForm(MessageType::Logout);
    }
}