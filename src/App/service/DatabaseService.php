<?php

namespace Service;

class DatabaseService
{
	private \PDO $connection;

	public function __construct()
	{
		try {
			$this->connection = new \PDO(
				'mysql:host=mariadb;dbname=' . $_ENV['MARIADB_DATABASE'],
				$_ENV['MARIADB_USER'],
				$_ENV['MARIADB_PASSWORD']);
		} catch (\PDOException $e) {
			print($e->getTraceAsString());
		}
	}

	public function getConnection()
	{
		return $this->connection;
	}

	public function execute(string $query, array $parameters): array
	{
		$statement = $this->connection->prepare($query);
		$statement->execute($parameters);
		$result = [];
		while($row = $statement->fetchObject()) {
			$result[] = $row;
		}
		return $result;
	}

	/* controller mit ganzer Entität
		- create user
		- delete user
		- update user
		- read user

	Error Handling
		- Exception: Password & Username
		- Sub-Exceptions

	OR Mapping, DTO
		- Data Transfer Object erstellen
		- DTO in Tabelle speichern
	*/


}

