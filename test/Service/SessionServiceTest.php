<?php

namespace Service;

use Enum\SessionStatus;
use PHPUnit\Framework\TestCase;
use Repository\UserRepository;

class SessionServiceTest extends TestCase
{
    private SessionService $sessionService;
    private UserRepository $userRepo;
    private string $username = 'MyStandardTestUsername';

    protected function setUp(): void
    {
        parent::setUp();
        $this->sessionService = SessionService::getSessionService();
        $this->dbService = DatabaseService::getInstance();
        $this->userRepo = new UserRepository();

        $this->userRepo->createUser(
            $this->username,
            'asdf',
            44,
            'Burgstrasse',
            '20',
            '3600',
            'Thun',
            6,
        );
    }

    public function testGetSessionService()
    {
        self::assertEquals(new SessionService(), SessionService::getSessionService());
    }

    public function testCreateSession()
    {
        session_start();
        $this->sessionService->createSession(33, 'MyMagicalTestUsername');
        self::assertSame(33, $_SESSION['id']);
        self::assertSame('MyMagicalTestUsername', $_SESSION['username']);
        self::assertIsInt($_SESSION['timestamp']);
        $this->sessionService->destroySession();
    }

    public function testDestroySession()
    {
        $this->sessionService->createSession(17, 'MyJoyfulTestUsername');
        $this->sessionService->destroySession();
        self::assertNull($_SESSION['id']);
        self::assertNull($_SESSION['username']);
        self::assertNull($_SESSION['timestamp']);
    }

    public function testIsLoggedInTrue()
    {
        $this->sessionService->createSession(55, 'MyUnbelievableTestUsername');
        self::assertTrue($this->sessionService->isLoggedIn());
        $this->sessionService->destroySession();
    }

    public function testIsLoggedInFalse()
    {
        self::assertFalse($this->sessionService->isLoggedIn());
    }

    public function testGetIdTruly()
    {
        $this->sessionService->createSession(77, 'MyShinyTestUsername');
        self::assertSame(77, $this->sessionService->getId());
        $this->sessionService->destroySession();
    }

    public function testGetIdFalsy()
    {
        self::assertFalse($this->sessionService->getId());
    }

    public function testGetUsernameTruly()
    {
        $this->sessionService->createSession(36, 'MyGloriousTestUsername');
        self::assertSame('MyGloriousTestUsername', $this->sessionService->getUsername());
        $this->sessionService->destroySession();
    }

    public function testGetUsernameFalsy()
    {
        self::assertFalse($this->sessionService->getUsername());
    }

    public function testIsSessionExpiredTrue()
    {
        $this->sessionService->createSession(12, 'MyWonderfulTestUsername');
        $_SESSION['timestamp'] -= 301;
        self::assertTrue($this->sessionService->isSessionExpired());
        $this->sessionService->destroySession();
    }

    public function testIsSessionExpiredFalse()
    {
        $this->sessionService->createSession(12, 'MyWonderfulTestUsername');
        self::assertFalse($this->sessionService->isSessionExpired());
        $this->sessionService->destroySession();
    }

    public function testGetSessionStatusNotLoggedIn()
    {
        self::assertSame(SessionStatus::NotLoggedIn, $this->sessionService->getSessionStatus());
    }
    public function testGetSessionStatusExpired()
    {
        $this->sessionService->createSession(7, 'MyMarvellousTestUsername');
        $_SESSION['timestamp'] -= 301;
        self::assertSame(SessionStatus::Expired, $this->sessionService->getSessionStatus());
    }
    public function testGetSessionStatusDiscontinued()
    {
        $this->sessionService->createSession(21, 'MyFamousTestUsername');
        self::assertSame(SessionStatus::Discontinued, $this->sessionService->getSessionStatus());
    }
    public function testGetSessionStatusLoggedIn()
    {
        $id = DatabaseService::getInstance()->execute(
            "SELECT id FROM user WHERE username = :username",
            ['username' => $this->username]
        )[0]->id;
        $this->sessionService->createSession($id, $this->username);
        self::assertEquals(SessionStatus::LoggedIn, $this->sessionService->getSessionStatus());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        DatabaseService::getInstance()->execute(
            "DELETE FROM user WHERE username = :username",
            ['username' => $this->username]
        );
    }
}
