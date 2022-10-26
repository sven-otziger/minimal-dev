<?php

namespace Service;

use Enum\SessionStatus;
use Repository\UserRepository;

class SessionService
{
    private UserRepository $userRepo;
    private static ?SessionService $sessionService = null;

    public function __construct()
    {
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

    public function getSessionStatus(): SessionStatus
    {
        if (!$this->isLoggedIn()) {
            return SessionStatus::NotLoggedIn;
        } else if ($this->isSessionExpired()) {
            $this->destroySession();
            return SessionStatus::Expired;
        } else {
            // logged in
            $isDeleted = $this->userRepo->getUserById($this->getId())->deleted;
            $userExists = $this->userRepo->getUsernameById($this->getId()) !== null;

            if (!$userExists || $isDeleted) {
                // special case: e.g. admin deletes user because of spam/attacks/...
                $this->destroySession();
                return SessionStatus::Discontinued;
            } else {
                if (time() - $_SESSION['timestamp'] > 5) {
                    session_regenerate_id();
                    $_SESSION['timestamp'] = time();
                }
                return SessionStatus::LoggedIn;
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
