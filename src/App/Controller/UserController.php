<?php

namespace Controller;

use Cassandra\Date;
use Exception\DuplicateUserException;
use Exception\InexistentUserException;
use Exception\InvalidPasswordException;
use Exception\UserException;
use Exception\ShortPasswordException;
use Service\DatabaseService;

class UserController
{
	private string $regexPassword = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?()&])/";

	public function __construct(array $parameters, array $arguments)
	{
		// function call
		call_user_func_array(array($this, $parameters['_route']), $arguments);
	}

	function readUsers(): void
	{
		$data = DatabaseService::getInstance()->execute("SELECT * FROM user", []);

		echo "<pre>";
		var_dump($data);
		echo "</pre>";
	}

	public function readUser($id): void
	{
		try {
			// check if object exists
			if (!$this->checkUserExistence($id)) {
				throw new InexistentUserException();
			}
			$data = DatabaseService::getInstance()->execute("SELECT * FROM user WHERE id = :id", ["id" => $id]);

			echo "<pre>";
			var_dump($data);
			echo "</pre>";
		} catch (UserException $e) {
			echo $e->getMessage();
		}
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
			$data = DatabaseService::getInstance()->execute("INSERT INTO user (username, password) VALUES (:username, :password)",
				["username" => $username, "password" => $password]);

			// display changes:
			$lastId = DatabaseService::getInstance()->getConnection()->lastInsertId();
			$this->readUser($lastId);
		} catch (UserException $e) {
			echo $e->getMessage();
		}
	}

	public function updateUser($id, $username, $password): void
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
			DatabaseService::getInstance()->execute("UPDATE user SET username = :username, password = :password WHERE id = :id",
				["id" => $id, "username" => $username, "password" => $password]);
//		display changes:
			$this->readUser($id);
		} catch (UserException $e) {
			echo $e->getMessage();
		}

	}

	public function deleteUser($id): void
	{
		try {
			if (!$this->checkUserExistence($id)) {
				throw new InexistentUserException();
			}
			DatabaseService::getInstance()->execute("DELETE FROM user WHERE id = :id", ["id" => $id]);
			echo "The user with the id {$id} has been deleted";
		} catch (UserException $e) {
			echo $e->getMessage();
		}
	}

	public function readUserWhereUsernameLike($search)
	{
//		works
//		$data = DatabaseService::getInstance()->execute("SELECT * FROM user WHERE username LIKE '%er'", []);

//		user parameter from array --> dynamically
		$data = DatabaseService::getInstance()->execute("SELECT * FROM user WHERE username LIKE :search", ["search" => '%' . $search . '%']);

//		works
//		$data = DatabaseService::getInstance()->execute("SELECT * FROM user WHERE username = :name", ["name" => $name]);

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
		$dataUsers = DatabaseService::getInstance()->execute("SELECT * FROM user", []);

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
		$objectToEdit = DatabaseService::getInstance()->execute("SELECT * FROM user WHERE id = :id", ["id" => $id]);

		if (count($objectToEdit) === 0) {
			return false;
		}
		return true;
	}
}
