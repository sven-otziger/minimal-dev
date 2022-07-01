<?php

namespace Controller;

use Exception\DuplicateUserException;
use Exception\InexistentUserException;
use Exception\InvalidPasswordException;
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

    public function __construct(array $parameters, array $arguments)
    {
        $this->userRepo = new UserRepository();
        parent::__construct($parameters, $arguments);
    }

	public function displayProfile(): void
	{
        $this->sessionHandler::handleSession();

        $activeUser = $this->sessionHandler::getId();
        $data = $this->userRepo->findUserWithID($activeUser);

        try {
            echo $this->twig->render('show-users.html.twig', ['userList' => $data]);
        } catch (Error $e) {
            echo $e->getTraceasString();
        }
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

	public function readUser(int $id): void
	{
		try {
			// check if object exists
			if (!$this->checkUserExistence($id)) {
				throw new InexistentUserException();
			}
			$data = $this->userRepo->findUserWithID($id);

			echo "<pre>";
			var_dump($data);
			echo "</pre>";
		} catch (UserException $e) {
			echo $e->getMessage();
		}
	}

	public function createUserForm(): void
	{
		require_once __DIR__ . "/../views/create-user-form.html";
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

			// create user
			$this->userRepo->createUser($username, $password, $age, $street, $number, $zip, $city);

			// display the new user:
			$lastId = DatabaseService::getInstance()->getConnection()->lastInsertId();
			header('Location: display/' . $lastId);

		} catch (UserException $e) {
			echo $e->getMessage();
		}
	}

	public function updateUser(int $id, string $username, string $password): void
	{
		try {
			// check if object exists
			if (!$this->checkUserExistence($id)) {
				throw new InexistentUserException();
			}
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

			// create user
			$this->userRepo->updateUser($id, $username, $password);
//		display changes:
			$data = $this->userRepo->findUserWithID($id);

			echo "<pre>";
			var_dump($data);
			echo "</pre>";
		} catch (UserException $e) {
			echo $e->getMessage();
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
		$objectToEdit = $this->userRepo->findUserWithID($id);

		if (count($objectToEdit) === 0) {
			return false;
		}
		return true;
	}
}
