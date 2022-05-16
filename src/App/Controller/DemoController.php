<?php

namespace Controller;

use Service\DatabaseService;

class DemoController
{
	public function route()
	{
		require __DIR__ . '/../html/demo.html';
	}

    public function getUser($id) {
        $stmt = DatabaseService::getInstance()->getConnection()->prepare("SELECT * FROM user WHERE id LIKE :id");
        $stmt->execute(['id' => $id]);

        var_dump($stmt->fetchAll());
    }

    public function getUsers() {
        $stmt = DatabaseService::getInstance()->getConnection()->query("SELECT * FROM user");

        var_dump($stmt->fetchAll());
    }
}
