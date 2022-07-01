<?php

namespace Repository;

use Service\DatabaseService;

class LoginRepository
{
    public function getUserIdByName(string $username): ?int
    {
        $dataArray = DatabaseService::getInstance()->execute(
            "SELECT id FROM user WHERE username = :username", ['username' => $username]);

        if (empty($dataArray)) {
            return null;
        } else {
            return $dataArray[0]->id;
        }
    }

    public function getUsernameById(int $id): ?string
    {
        $dataArray = DatabaseService::getInstance()->execute(
            "SELECT username FROM user WHERE id = :id", ['id' => $id]
        );

        if (empty($dataArray)) {
            return null;
        } else {
            return $dataArray[0]->username;
        }
    }

    public function getPasswordById(int $id): ?string
    {
        $dataArray = DatabaseService::getInstance()->execute(
            "SELECT password FROM user WHERE id = :id", ['id' => $id]
        );

        if (empty($dataArray)) {
            return null;
        } else {
            return $dataArray[0]->password;
        }
    }

}