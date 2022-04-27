<?php

namespace Controller;

use Service\DatabaseService;

class AbstractController
{
	protected DatabaseService $dbService;

	public function __construct()
	{
		$this->dbService = new DatabaseService();
	}
}