<?php

namespace Repository;


use Enum\Attribute;
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

    public function getAttributeById(Attribute $attribute, int $id): ?string
    {
        $sql = match ($attribute) {
            Attribute::Username => "SELECT username FROM user WHERE id = :id",
            Attribute::Password => "SELECT password FROM user WHERE id = :id",
            Attribute::IsDeleted => "SELECT deleted FROM user WHERE id = :id"
        };
        $result = DatabaseService::getInstance()->execute(
            $sql,
            ['id' => $id]
        );
        if (empty($result)) {
            return null;
        } else {
            return match ($attribute) {
                Attribute::Username => $result[0]->username,
                Attribute::Password => $result[0]->password,
                Attribute::IsDeleted => $result[0]->deleted
            };
        }
    }

}
