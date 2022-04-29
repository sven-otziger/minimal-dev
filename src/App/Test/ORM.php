<?php

namespace Test;

use Service\DatabaseService;

class ORM
{
	public function __construct(int $id)
	{
		$columns = DatabaseService::getInstance()->execute("SHOW COLUMNS FROM user", []);
		$data = DatabaseService::getInstance()->execute("SELECT * FROM user WHERE id = :id", ["id" => $id]);

		for ($i = 0; $i < count($columns); $i++) {
			$key = $columns[$i]->Field;
			$value = $data[0]->$key;
			$this->$key=$value;
		}

	}

}