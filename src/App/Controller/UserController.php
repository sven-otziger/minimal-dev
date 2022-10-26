<?php

namespace Controller;

use Enum\User;
use Enum\Account;
use Exception\DuplicateUserException;
use Exception\InexistentUserException;
use Exception\InvalidPasswordException;
use Exception\PasswordException;
use Exception\UserException;
use Exception\ShortPasswordException;
use Repository\UserRepository;
use Service\PermissionService;
use Service\DatabaseService;

class UserController extends Controller
{
    private UserRepository $userRepo;
    protected PermissionService $permissionService;
    private string $regexPassword = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?()&])/";
    private string $UPDATE_TEMPLATE = 'user/update-user.html.twig';

    public function __construct(array $parameters, array $arguments)
    {
        $this->userRepo = new UserRepository();
        parent::__construct($parameters, $arguments);
    }

    public function displayProfile(): void
    {
        $activeUserId = $this->sessionService->getId();
        $userData = $this->userRepo->getUserById($activeUserId);

        $this->twigService->renderTwigTemplate('user/show-user.html.twig',
            [
                'user' => $userData,
                'isForeignProfile' => false,
            ]);
    }

    public function displayAllProfiles(string $message = null, $payload = null): void
    {
        $permissions = $this->permissionService->getPermissions($this->sessionService->getId());
        $showDisabledUsers = false;
        if (isset($payload) && $payload['statusCb'] === 'true') {
            $showDisabledUsers = true;
        }
        $users = $this->userRepo->getAllUsersToDisplay($showDisabledUsers);


        $data = [
            'users' => $users,
            'currentUser' => $this->sessionService->getUsername(),
            'permissions' => $permissions,
            'message' => $message
        ];
        if (isset($payload)) {
            $data['statusCb'] = $payload['statusCb'] === 'true';
        }

        $this->twigService->renderTwigTemplate('user/show-all-users.html.twig', $data);
    }

    public function displayForeignProfile(int $id): void
    {
        $userData = $this->userRepo->getUserById($id);
        $currentUser = $this->sessionService->getUsername();
        $permissions = $this->permissionService->getPermissions($this->sessionService->getId());

        $this->twigService->renderTwigTemplate('user/show-user.html.twig',
            [
                'user' => $userData,
                'currentUser' => $currentUser,
                'isForeignProfile' => true,
                'permissions' => $permissions
            ]);
    }

    public function renderSignupForm(string $messsage = null): void
    {
        $roles = $this->userRepo->getRoles();

        $this->twigService->renderTwigTemplate('user/create-user-form.html.twig',
            ['message' => $messsage, 'roles' => $roles]);
    }

    public function createUser(array $payload): void
    {
        $username = $payload['username'];
        $password = $payload['password'];
        $age = $payload['age'];
        $street = $payload['street'];
        $number = $payload['number'];
        $zip = $payload['zip'];
        $city = $payload['city'];
        $roleId = $payload['role'];

        try {
            // check username
            if ($this->checkOnDuplicatedUsername($username)) {
                throw new DuplicateUserException();
            }

            // check password
            if (strlen($password) < 8) {
                throw new ShortPasswordException();
            } else if (!preg_match($this->regexPassword, $password)) {
                throw new InvalidPasswordException();
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // create user
            $this->userRepo->createUser($username, $hashedPassword, $age, $street, $number, $zip, $city, $roleId);

            // display the new user:
            $lastId = DatabaseService::getInstance()->getConnection()->lastInsertId();
            $this->sessionService->createSession($lastId, $username);
            header('Location: home');

        } catch (UserException|PasswordException $e) {
            $this->renderSignupForm($e->getMessage());
        }
    }

    public function renderUpdateForm(array $payload): void
    {

        $currentUser = $this->sessionService->getUsername();
        $isForeignProfile = $this->sessionService->getId() !== intval($payload['id']);
        $permissions = $this->permissionService->getPermissions($this->sessionService->getId());

        $data =
            [
                'user' => $payload,
                'currentUser' => $currentUser,
                'isForeignProfile' => $isForeignProfile,
                'permissions' => $permissions
            ];

//        echo "<pre>";
//        var_dump($data);
//        echo "</pre>";
//        die();

        $this->twigService->renderTwigTemplate($this->UPDATE_TEMPLATE,
            $data);
    }

    public function updateUser(array $payload): void
    {
        $isForeignProfile = $this->sessionService->getId() !== intval($payload['id']);
        $id = $payload['id'];

        $userFromDb = $this->userRepo->getUserById($id);

        try {
            if ($userFromDb->username !== $payload['username']) {
                if ($this->checkOnDuplicatedUsername($payload['username'])) {
                    throw new DuplicateUserException();
                }
                $this->userRepo->updateAttributeById($id, User::username, $payload['username']);
            }

            if ($userFromDb->password !== $payload['password']) {
                if (strlen($payload['password']) < 8) {
                    throw new ShortPasswordException();
                } else if (!preg_match($this->regexPassword, $payload['password'])) {
                    throw new InvalidPasswordException();
                }
                $hashedPassword = password_hash($payload['password'], PASSWORD_BCRYPT);
                $this->userRepo->updateAttributeById($id, User::password, $hashedPassword);
            }

            if ($userFromDb->age !== $payload['age']) {
                $this->userRepo->updateAttributeById($id, User::age, $payload['age']);
            }
            if ($userFromDb->street !== $payload['street']) {
                $this->userRepo->updateAttributeById($id, User::street, $payload['street']);
            }
            if ($userFromDb->house_number !== $payload['house_number']) {
                $this->userRepo->updateAttributeById($id, User::houseNumber, $payload['house_number']);
            }
            if ($userFromDb->city !== $payload['city']) {
                $this->userRepo->updateAttributeById($id, User::city, $payload['city']);
            }
            if ($userFromDb->zip_code !== $payload['zip_code']) {
                $this->userRepo->updateAttributeById($id, User::zip, $payload['zip_code']);
            }
            $isForeignProfile ? header('Location: profile/' . $id) : header('Location: profile');
        } catch
        (DuplicateUserException $e) {
            $payload['username'] = $userFromDb->username;
            $this->twigService->renderTwigTemplate($this->UPDATE_TEMPLATE, ['user' => $payload, 'message' => $e->getMessage()]);

        } catch (PasswordException $e) {
            $payload['password'] = $userFromDb->password;
            $this->twigService->renderTwigTemplate($this->UPDATE_TEMPLATE, ['user' => $payload, 'message' => $e->getMessage()]);
        }
    }

    public function deleteUser(array $payload): void
    {
        $id = $payload['id'];
        $isForeignProfile = $this->sessionService->getId() !== intval($payload['id']);

        try {
            if (!$this->checkUserExistence($id)) {
                throw new InexistentUserException();
            }
            $this->userRepo->deleteUser($id);
            if ($isForeignProfile) {
                $this->displayAllProfiles(Account::DeletedForeign->value);
            } else {
                $this->twigService->renderTwigTemplate('login.html.twig', ['message' => Account::Deleted->value]);
            }
        } catch (UserException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param String $username
     * @return bool true if the username from the URL matches with an existing one
     **/
    private function checkOnDuplicatedUsername(string $username): bool
    {
        $dataUsers = $this->userRepo->findAllUsers();

        foreach ($dataUsers as $user) {
            if ($username == $user->username) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param int $id
     * @return bool true if the user does exist
     */
    private function checkUserExistence(int $id): bool
    {
        $objectToEdit = $this->userRepo->getUserById($id);
        return $objectToEdit !== null;
    }
}
