<?php

namespace Controller;

use Enum\User;

use Exception\DuplicateUserException;
use Exception\InexistentUserException;
use Exception\InvalidPasswordException;
use Exception\PasswordException;
use Exception\UserException;
use Exception\ShortPasswordException;
use Repository\UserRepository;
use Service\DatabaseService;
use Test\ORM;
use Twig\Error\Error;


class UserController extends Controller
{
	private string $regexPassword = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?()&])/";
	private UserRepository $userRepo;
    private string $UPDATE_TEMPLATE = 'update-user.html.twig';

    public function __construct(array $parameters, array $arguments)
    {
        $this->userRepo = new UserRepository();
        parent::__construct($parameters, $arguments);
    }

	public function displayProfile(): void
	{
        $this->sessionHandler::handleSession();

        $activeUser = $this->sessionHandler::getId();
        $userData = $this->userRepo->getUserById($activeUser);

        $this->twigHandler::renderTwigTemplate('show-user.html.twig', ['user' => $userData]);
	}

	public function orm(): void
	{
		$test = new ORM(3);

		echo "<pre>ORM Object: ";
		var_dump($test);
		echo "</pre>";
	}

	public function readUsers(): void
	{
		$data = $this->userRepo->findAllUsers();

		echo "<pre>";
		var_dump($data);
		echo "</pre>";
		echo "<hr>";
	}


	public function renderSignupForm(string $messsage = null): void
    {
        try {
            $this->twigHandler::renderTwigTemplate('create-user-form.html.twig', ['message' => $messsage]);
        } catch (Error $e) {
            echo $e->getTraceAsString();
        }
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
			$this->userRepo->createUser($username, $hashedPassword, $age, $street, $number, $zip, $city);

			// display the new user:
			$lastId = DatabaseService::getInstance()->getConnection()->lastInsertId();
            $this->sessionHandler::createSession($lastId);
			header('Location: home');

		} catch (UserException|PasswordException $e) {
			$this->renderSignupForm($e->getMessage());
		}
	}

    public function renderUpdateForm(array $payload): void
    {
        $this->sessionHandler::handleSession();
        $this->twigHandler::renderTwigTemplate($this->UPDATE_TEMPLATE, ['user' => $payload]);
    }

	public function updateUser(array $payload): void
	{
        $this->sessionHandler::handleSession();

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
                $this->userRepo->updateAttributeById($id, User::password, $payload['password']);
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
            header('Location: profile');
        } catch
        (DuplicateUserException $e) {
            $message =  $e->getMessage();
            $payload['username'] = $userFromDb->username;
            $this->twigHandler::renderTwigTemplate($this->UPDATE_TEMPLATE, ['user' => $payload, 'message' => $message]);

        }catch (PasswordException $e){
            $message = $e->getMessage();
            $payload['password'] = $userFromDb->password;
            $this->twigHandler::renderTwigTemplate($this->UPDATE_TEMPLATE, ['user' => $payload, 'message' => $message]);
        }
	}

	public function deleteUser(array $payload): void
	{
        $id = $payload['id'];
        $username = $payload['username'];

		try {
			if (!$this->checkUserExistence($id)) {
				throw new InexistentUserException();
			}
			$this->userRepo->deleteUser($id);
			echo "The user with the username \"{$username}\" has been deleted.";
		} catch (UserException $e) {
			echo $e->getMessage();
		}
	}

	public function readUserWhereUsernameLike($search): void
	{
		$data = $this->userRepo->findUserWhereUsernameLike($search);

		echo "<pre>";
		var_dump($data);
		echo "</pre>";
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
