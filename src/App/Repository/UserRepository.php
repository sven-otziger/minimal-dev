<?php

namespace Repository;

use Service\DatabaseService;

class UserRepository
{
	/*
	SELECT * FROM user
	SELECT * FROM user WHERE id = :id"
	INSERT INTO user (username, password) VALUES (:username, :password)
	UPDATE user SET username = :username, password = :password WHERE id = :id
	DELETE FROM user WHERE id = :id
	SELECT * FROM user WHERE username LIKE :search

	*/

	public function findAllUsers(): array
	{
		return DatabaseService::getInstance()->execute("SELECT * FROM user", []);
	}

	public function findUserWithID(int $id): array
	{
		return DatabaseService::getInstance()->execute("SELECT * FROM user WHERE id = :id", ["id" => $id]);
	}

	public function createUser(string $username, string $password)
	{
		DatabaseService::getInstance()->execute("INSERT INTO user (username, password) VALUES (:username, :password)",
			["username" => $username, "password" => $password]);
	}

	public function updateUser(int $id, string $username, string $password): void
	{
		DatabaseService::getInstance()->execute("UPDATE user SET username = :username, password = :password WHERE id = :id",
			["id" => $id, "username" => $username, "password" => $password]);
	}

	public function deleteUser(int $id)
	{
		DatabaseService::getInstance()->execute("DELETE FROM user WHERE id = :id", ["id" => $id]);

	}

	public function findUserWhereUsernameLike(string $search): array
	{
		return DatabaseService::getInstance()->execute("SELECT * FROM user WHERE username LIKE :search", ["search" => '%' . $search . '%']);
	}
}