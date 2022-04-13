<?php

namespace Controller;

use Service\DatabaseService;

class UserController
{
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
		$dbService = new DatabaseService();
		$data = $dbService->execute("INSERT INTO user (username, password) VALUES (:username, :password)",
			["username" => $username, "password" => $password]);
//		display changes:
		$lastId = $dbService->getConnection()->lastInsertId();
		$this->readUser($lastId);
	}

	public function updateUser($id, $username, $password)
	{
		$dbService = new DatabaseService();
		$data = $dbService->execute("UPDATE user SET username = :username, password = :password WHERE id = :id",
			["id" => $id, "username" => $username, "password" => $password]);
//		display changes:
		$this->readUser($id);
	}

	public function deleteUser($id)
	{
		$dbService = new DatabaseService();
		$data = $dbService->execute("DELETE FROM user WHERE id = :id", ["id" => $id]);
	}

}