<?php

namespace Controller;

use Exception\InvalidPasswordException;
use Exception\PasswordException;
use Exception\ShortPasswordException;
use Service\DatabaseService;

class UserController
{
	private string $regexPassword = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])/";

	public function readUsers()
	{
		$dbService = new DatabaseService();
		$data = $dbService->execute("SELECT * FROM user", []);
		echo "<pre>";
		var_dump($data);
		echo "</pre>";
	}

	public function readUser($id)
	{
		$dbService = new DatabaseService();
		$data = $dbService->execute("SELECT * FROM user WHERE id = :id", ["id" => $id]);
		echo "<pre>";
		var_dump($data);
		echo "</pre>";
	}

	public function createUser($username, $password)
	{
		try {
			if (strlen($password) < 8) {
				throw new ShortPasswordException();
			} else if (!preg_match($this->regexPassword, $password)) {
				throw new InvalidPasswordException();
			}
			$dbService = new DatabaseService();
			$data = $dbService->execute("INSERT INTO user (username, password) VALUES (:username, :password)",
				["username" => $username, "password" => $password]);
//		display changes:
			$lastId = $dbService->getConnection()->lastInsertId();
			$this->readUser($lastId);
		} catch (PasswordException $e) {
			echo $e->getMessage();
		}
	}

	public function updateUser($id, $username, $password)
	{
		try {
			if (strlen($password) < 8) {
				throw new ShortPasswordException();
			} else if (!preg_match($this->regexPassword, $password)) {
				throw new InvalidPasswordException();
			}
			$dbService = new DatabaseService();
			$data = $dbService->execute("UPDATE user SET username = :username, password = :password WHERE id = :id",
				["id" => $id, "username" => $username, "password" => $password]);
//		display changes:
			$this->readUser($id);
		}catch (PasswordException $e){
			echo $e->getMessage();
		}

	}

	public function deleteUser($id)
	{
		$dbService = new DatabaseService();
		$data = $dbService->execute("DELETE FROM user WHERE id = :id", ["id" => $id]);
	}

}