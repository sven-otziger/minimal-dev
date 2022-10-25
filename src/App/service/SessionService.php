<?php

namespace Service;

use Enum\Message;
use Repository\UserRepository;
use Service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class SessionService
{
    private static ?SessionService $sessionService = null;
    private TwigService $twigService;
    private UserRepository $userRepo;
    private string $LOGIN_TEMPLATE = 'login.html.twig';

    public function __construct()
    {
        $this->twigService = TwigService::getTwigService();
        $this->userRepo = new UserRepository();
    }

    public static function getSessionService(): SessionService
    {
        if (self::$sessionService === null) {
            self::$sessionService = new SessionService();
        }
        return self::$sessionService;
    }

    public function createSession(int $id, string $username): void
    {
        $_SESSION['id'] = $id;
        $_SESSION['timestamp'] = time();
        $_SESSION['username'] = $username;
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
                $this->twigService->renderTwigTemplate($this->LOGIN_TEMPLATE, ['message' => Message::NotLoggedIn->value]);
            } catch (LoaderError|RuntimeError|SyntaxError $e) {
                echo $e->getTraceAsString();
            }
            exit();
        } else if ($this->isSessionExpired()) {
            $this->destroySession();
            try {
                $this->twigService->renderTwigTemplate($this->LOGIN_TEMPLATE, ['message' => Message::Inactivity->value]);
            } catch (LoaderError|RuntimeError|SyntaxError $e) {
                echo $e->getTraceAsString();
            }
            exit();
        } else {
            // logged in
            $isDeleted = $this->userRepo->getUserById($this->getId())->deleted;
            $userExists = $this->userRepo->getUsernameById($this->getId()) !== null;

            if (!$userExists || $isDeleted) {
                // special case: e.g. admin deletes user because of spam/attacks/...
                $this->destroySession();
                $this->twigService->renderTwigTemplate($this->LOGIN_TEMPLATE, ['message' => Message::Discontinued->value]);
                exit();
            } else {
                if (time() - $_SESSION['timestamp'] > 5) {
                    session_regenerate_id();
                    $_SESSION['timestamp'] = time();
                }
            }
        }
    }

    public function getId(): int|bool
    {
        return $_SESSION['id'] ?? false;
    }

    public function getUsername(): string|bool
    {
        return $_SESSION['username'] ?? false;
    }

}
