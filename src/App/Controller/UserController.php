<?php

namespace Controller;

use Exception\DuplicateUserException;
use Exception\InvalidPasswordException;
use Exception\UserException;
use Exception\ShortPasswordException;
use Service\DatabaseService;

class UserController extends AbstractController
{
	private string $regexPassword = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?()&])/";

	public function __construct(array $parameters, array $arguments)
	{
		parent::__construct();
		// function call
		call_user_func_array(array($this, $parameters['_route']),$arguments);

	}

	function readUsers(): void
	{
		$data = $this->dbService->execute("SELECT * FROM user", []);
		echo "<pre>";
		var_dump($data);
		echo "</pre>";
	}

	public function readUser($id): void
	{
		$data = $this->dbService->execute("SELECT * FROM user WHERE id = :id", ["id" => $id]);
		echo "<pre>";
		var_dump($data);
		echo "</pre>";
	}

	public function createUser($username, $password): void
	{
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
			$data = $this->dbService->execute("INSERT INTO user (username, password) VALUES (:username, :password)",
				["username" => $username, "password" => $password]);

			// display changes:
			$lastId = $this->dbService->getConnection()->lastInsertId();
			$this->readUser($lastId);
		} catch (UserException $e) {
			echo $e->getMessage();
		}
	}

	public function updateUser($id, $username, $password): void
	{
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
			$data = $this->dbService->execute("UPDATE user SET username = :username, password = :password WHERE id = :id",
				["id" => $id, "username" => $username, "password" => $password]);
//		display changes:
			$this->readUser($id);
		} catch (UserException $e) {
			echo $e->getMessage();
		}

	}

	public function deleteUser($id): void
	{
		$data = $this->dbService->execute("DELETE FROM user WHERE id = :id", ["id" => $id]);
	}

	/**
	 * @return true if the username from the URL matches with an existing one
	 **/
	private function checkOnDuplicatedUsername($username): bool
	{
		$dataUsers = $this->dbService->execute("SELECT * FROM user", []);

		foreach ($dataUsers as $user) {
			if ($username == $user->username) {
				return true;
			}
		}
		return false;
	}
}