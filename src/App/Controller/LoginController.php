<?php

namespace Controller;

use Enum\RequiredAttribute;
use Enum\Message;
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

    public function renderLoginForm(Message $loginMessage = null): void
    {
        $loginMessage = $loginMessage?->value;
        try {
            $this->twigHandler->renderTwigTemplate('login.html.twig', ['message' => $loginMessage]);
        } catch (Error $e) {
            echo $e->getTraceAsString();
        }
    }

    public function loggingIn(array $payload): void
    {
        $username = $payload['username'];
        $password = $payload['password'];

        $id = $this->loginRepo->getUserIdByName($username);

//        user does not exist
        if (is_null($id)) {
            $this->renderLoginForm(Message::LoginFailed);
            return;
        }

        $dbUsername = $this->loginRepo->getAttributeById(RequiredAttribute::Username, $id);
        $dbPassword = $this->loginRepo->getAttributeById(RequiredAttribute::Password, $id);
        $userIsDeleted = $this->loginRepo->getAttributeById(RequiredAttribute::IsDeleted, $id);

        if ($username === $dbUsername && password_verify($password, $dbPassword) && !$userIsDeleted) {

            $this->sessionHandler->createSession($id, $username);

            header('Location: home');
        } else {
//            password does not match username or user is "deleted"
            $this->renderLoginForm(Message::LoginFailed);
        }
    }



    public function logout(): void
    {
        $this->sessionHandler->destroySession();
        $this->renderLoginForm(Message::Logout);
    }
}