<?php

namespace Controller;

use Enum\Login;
use Enum\RequiredAttribute;
use Repository\LoginRepository;

class LoginController extends Controller
{
    private LoginRepository $loginRepo;

    public function __construct(array $parameters, array $arguments)
    {
        $this->loginRepo = new LoginRepository();
        parent::__construct($parameters, $arguments);
    }

    public function renderLoginForm(Login $loginMessage = null): void
    {
        $loginMessage = $loginMessage?->value;
        $this->twigService->renderTwigTemplate('login.html.twig', ['message' => $loginMessage]);
    }

    public function loggingIn(array $payload): void
    {
        $username = $payload['username'];
        $password = $payload['password'];

        $id = $this->loginRepo->getUserIdByName($username);

//        user does not exist
        if (is_null($id)) {
            $this->renderLoginForm(Login::LoginFailed);
            return;
        }

        $dbUsername = $this->loginRepo->getAttributeById(RequiredAttribute::Username, $id);
        $dbPassword = $this->loginRepo->getAttributeById(RequiredAttribute::Password, $id);
        $userIsDeleted = $this->loginRepo->getAttributeById(RequiredAttribute::IsDeleted, $id);

        if ($username === $dbUsername && password_verify($password, $dbPassword) && !$userIsDeleted) {

            $this->sessionService->createSession($id, $username);

            header('Location: home');
        } else {
//            password does not match username or user is "deleted"
            $this->renderLoginForm(Login::LoginFailed);
        }
    }

    public function logout(): void
    {
        $this->sessionService->destroySession();
        $this->renderLoginForm(Login::Logout);
    }
}