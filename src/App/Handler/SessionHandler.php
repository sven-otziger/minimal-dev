<?php

namespace Handler;

use Enum\LoginMessage;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Handler\TwigHandler;

class SessionHandler
{
    private static ?SessionHandler $sessionHandler = null;
    private static TwigHandler $twigHandler;

    public function __construct()
    {
        self::$twigHandler  = TwigHandler::getTwigHandler();
    }

    public static function getSessionHandler(): SessionHandler
    {
        if (self::$sessionHandler === null) {
            self::$sessionHandler = new SessionHandler();
        }
        return self::$sessionHandler;
    }

    public static function createSession(int $id): void
    {
        $_SESSION['id'] = $id;
        $_SESSION['timestamp'] = time();
    }

    public static function destroySession(): void
    {
        $_SESSION['id'] = null;
        $_SESSION['timestamp'] = null;
        session_destroy();
    }

    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['id']);
    }

    public static function isSessionExpired(): bool
    {
        return time() - $_SESSION['timestamp'] > 5; // 5min
    }

    public static function handleSession(): void
    {
        if (self::isLoggedIn() === null) {
            try {
                self::$twigHandler::renderTwigTemplate('login.html.twig', ['message' => LoginMessage::NotLoggedIn->value]);
            } catch (LoaderError|RuntimeError|SyntaxError $e) {
                echo $e->getTraceAsString();
            }

//            echo $this->twig->render('login.html.twig', ['message' => $loginMessage->value]);
//            echo TwigHandler::getTwigHandler()::renderTwigTemplate('login.html.twig', ['message' => LoginMessage::NotLoggedIn->value]);
//            header('Location: ../../login-form');
            exit();
        } else if (self::isSessionExpired()) {
            self::destroySession();
            try {
                self::$twigHandler::renderTwigTemplate('login.html.twig', ['message' => LoginMessage::Inactivity->value]);
            } catch (LoaderError|RuntimeError|SyntaxError $e) {
                echo $e->getTraceAsString();
            }
//            echo TwigHandler::getTwigHandler()::renderTwigTemplate('login.html.twig', ['message' => LoginMessage::NotLoggedIn->value]);
//            header('Location: ../../login-form');
            exit();
        } else {
            $_SESSION['timestamp'] = time();
            session_regenerate_id();
        }
    }

    public static function getId(): int
    {
        return $_SESSION['id'];
    }

}
