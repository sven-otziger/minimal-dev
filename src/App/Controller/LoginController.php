<?php

namespace Controller;

use Enum\Attribute;
use Enum\LoginMessage;
use Repository\LoginRepository;
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
        $this->renderLoginForm(LoginMessage::None);
    }

    public function login(array $payload): void
    {
        $username = $payload['username'];
        $password = $payload['password'];

        $id = $this->loginRepo->getUserIdByName($username);

//        user does not exist
        if (is_null($id)) {
            $this->renderLoginForm(LoginMessage::LoginFailed);
            return;
        }

        $dbUsername = $this->loginRepo->getAttributeById(Attribute::Username, $id);
        $dbPassword = $this->loginRepo->getAttributeById(Attribute::Password, $id);
        $userIsDeleted = $this->loginRepo->getAttributeById(Attribute::IsDeleted, $id);

        if ($username === $dbUsername && password_verify($password, $dbPassword) && !$userIsDeleted) {

            $this->sessionHandler::createSession($id);

            header('Location: profile');
        } else {
//            password does not match username or user is "deleted"
            $this->renderLoginForm(LoginMessage::LoginFailed);
        }
    }

    private function renderLoginForm(LoginMessage $loginMessage): void
    {
        try {
            echo $this->twig->render('login.html.twig', ['message' => $loginMessage->value]);
        } catch (Error $e) {
            echo $e->getTraceAsString();
        }
    }

    public function logout(array $payload): void
    {
        $this->sessionHandler::destroySession();
        $this->renderLoginForm(LoginMessage::Logout);
    }
}