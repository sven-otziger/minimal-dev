<?php

namespace Handler;

use Enum\LoginMessage;
use Repository\UserRepository;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class SessionHandler
{
    private static ?SessionHandler $sessionHandler = null;
    private TwigHandler $twigHandler;
    private UserRepository $userRepo;
    private string $LOGIN_TEMPLATE = 'login.html.twig';

    public function __construct()
    {
        $this->twigHandler = TwigHandler::getTwigHandler();
        $this->userRepo = new UserRepository();
    }

    public static function getSessionHandler(): SessionHandler
    {
        if (self::$sessionHandler === null) {
            self::$sessionHandler = new SessionHandler();
        }
        return self::$sessionHandler;
    }

    public function createSession(int $id, string $username): void
    {
        $_SESSION['id'] = $id;
        $_SESSION['timestamp'] = time();
        $_SESSION['username'] = $username;

//        echo "<pre>";
//        var_dump($_SESSION);
//        echo "</pre>";
//        die();
    }

    public function destroySession(): void
    {
        $_SESSION['id'] = null;
        $_SESSION['timestamp'] = null;
        $_SESSION['username'] = null;
        session_destroy();
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['id']);
    }

    public function isSessionExpired(): bool
    {
        return time() - $_SESSION['timestamp'] > 5 * 60; // 5min
    }

    public function handleSession(): void
    {
        if (!$this->isLoggedIn()) {
            try {
                $this->twigHandler->renderTwigTemplate($this->LOGIN_TEMPLATE, ['message' => LoginMessage::NotLoggedIn->value]);
            } catch (LoaderError|RuntimeError|SyntaxError $e) {
                echo $e->getTraceAsString();
            }

//            echo $this->twig->render('login.html.twig', ['message' => $loginMessage->value]);
//            echo TwigHandler::getTwigHandler()::renderTwigTemplate('login.html.twig', ['message' => LoginMessage::NotLoggedIn->value]);
//            header('Location: ../../login-form');
            exit();
        } else if ($this->isSessionExpired()) {
            $this->destroySession();
            try {
                $this->twigHandler->renderTwigTemplate($this->LOGIN_TEMPLATE, ['message' => LoginMessage::Inactivity->value]);
            } catch (LoaderError|RuntimeError|SyntaxError $e) {
                echo $e->getTraceAsString();
            }
            exit();
        } else {
            $_SESSION['timestamp'] = time();
            session_regenerate_id();
        }
    }

    public function getId(): int|bool
    {
        return $_SESSION['id'];
    }

    public function getUsername(): string|bool
    {
        return $_SESSION['username'];
    }

}
