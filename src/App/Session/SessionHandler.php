<?php

namespace Session;

class SessionHandler
{
    private static ?SessionHandler $sessionHandler = null;

    public function __construct()
    {
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
        return time() - $_SESSION['timestamp'] > 60 * 60 * 5; // 5min
    }

    public static function handleSession(): void
    {
        if (!self::isLoggedIn()) {
            header('Location: ../../login-form');
            exit();
        } else if (self::isSessionExpired()) {
            self::destroySession();
            header('Location: ../../login-form');
            exit();
        } else {
            $_SESSION['timestamp'] = time();
        }
    }

    public static function getId(): int
    {
        return $_SESSION['id'];
    }

}
