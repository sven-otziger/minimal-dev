<?php

namespace Repository;


use Enum\RequiredAttribute;
use Service\DatabaseService;

class LoginRepository extends Repository
{
    public function getUserIdByName(string $username): ?int
    {
        $dataArray = $this->dbService->execute(
            "SELECT id FROM user WHERE username = :username", ['username' => $username]);

        if (empty($dataArray)) {
            return null;
        } else {
            return $dataArray[0]->id;
        }
    }

    public function getPasswordById(int $id): ?string
    {
        $dataArray = $this->dbService->execute(
            "SELECT password FROM user WHERE id = :id", ['id' => $id]
        );

        if (empty($dataArray)) {
            return null;
        } else {
            return $dataArray[0]->password;
        }
    }

    public function getAttributeById(RequiredAttribute $requiredAttribute, int $id): ?string
    {
        $result = $this->dbService->execute($requiredAttribute->value, ['id' => $id]);
        if (empty($result)) {
            return null;
        } else {
            return match ($requiredAttribute) {
                RequiredAttribute::Username => $result[0]->username,
                RequiredAttribute::Password => $result[0]->password,
                RequiredAttribute::IsDeleted => $result[0]->deleted
            };
        }
    }

}
