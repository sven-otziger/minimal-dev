<?php


use Controller\LoginController;
use PHPUnit\Framework\TestCase;
use Repository\LoginRepository;
use Repository\UserRepository;
use Service\DatabaseService;

class LoginControllerTest extends TestCase
{
    private \Handler\SessionHandler $sessionHandler;
    private LoginRepository $loginRepo;
    private UserRepository $userRepo;
    private DatabaseService $dbSerivce;
    private LoginController $loginController;
    private array $userData;


    protected function setUp(): void
    {
        parent::setUp();
        $this->sessionHandler = \Handler\SessionHandler::getSessionHandler();
        $this->loginRepo = new LoginRepository();
        $this->userRepo = new UserRepository();
        $this->dbSerivce = DatabaseService::getInstance();
        $parameters = [
            '_controller' => 'Controller\LoginController',
            '_route' => 'renderLoginForm',
        ];
        $arguments = [];
        $this->loginController = new LoginController($parameters, $arguments);
        $adminRoleId = $this->dbSerivce->execute(
            'SELECT id FROM role WHERE description = :description',
            ['description' => 'admin']
        );
        $userData = [
            'username' => 'myTestUser',
            'password' => 'myTestPassword',
            'age' => '22',
            'street' => 'Burgstrasse',
            'house_number' => '20',
            'zip_code' => '3600',
            'city' => 'Thun',
            'roleId' => $adminRoleId,
        ];
        $this->userRepo->createUser($userData['username'],
            $userData['password'],
            $userData['age'],
            $userData['street'],
            $userData['house_number'],
            $userData['zip_code'],
            $userData['city'],
            $userData['roleId'],
        );
        $this->userData = $userData;
    }

    /**
     * @test
     *
     */
    public function correct_login(): void
    {
        $payload = [
            'username' => $this->userData['username'],
            'password' => $this->userData['password'],
        ];
        $this->loginController->loggingIn($payload);
        $this->assertTrue(isset($_SESSION['id']));
    }

    /**
     * @test
     */
    public function failed_login(array $payload): void
    {
        $this->loginController->loggingIn($payload);
        $this->assertFalse(isset($_SESSION['id']));
    }

    /**
     *  @dataProvider failed_login
     */
    public function provideFalseLoginData(): array
    {
        return [
            // inexistent username
            [
                'username' => 'thisUserDoesNotExist',
                'password' => 'thisPasswordIsNotBeingChecked',
            ],
            // wrong password
            [
                'username' => $this->userData['username'],
                'password' => 'aWrongPassword',
            ]
        ];
    }

    /**
     * @test
     */
    public function successful_logout()
    {
        $this->correct_login();
        $this->loginController->logout();
        $this->assertFalse(isset($_SESSION['id']));
    }

    /**
     * @test
     */
    public function testRenderLoginForm()
    {
        $this->loginController->renderLoginForm();
        // ?
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $userId = $this->dbSerivce->execute(
            'SELECT id FROM user WHERE username = :username',
            ['username' => 'myTestUser']
        );
        $this->userRepo->deleteUser($userId[0]);

        if ($this->sessionHandler->isLoggedIn()) {
            $this->sessionHandler->destroySession();
        }
    }
}
