<?php

namespace Repository;

use Service\DatabaseService;
use Enum\User;
use Symfony\Component\VarDumper\Cloner\Data;

class UserRepository extends Repository
{
    /*
    SELECT * FROM user
    SELECT * FROM user WHERE id = :id"
    INSERT INTO user (username, password) VALUES (:username, :password)
    UPDATE user SET username = :username, password = :password WHERE id = :id
    DELETE FROM user WHERE id = :id
    SELECT * FROM user WHERE username LIKE :search

    */
    public function getUsernameById($id): ?string
    {
        $data = $this->dbService->execute("SELECT username FROM user WHERE id = :id", ['id' => $id]);
        return (count($data) === 1) ? $data[0]->username : null;
    }


    public function findAllUsers(): array
    {
        return $this->dbService->execute("SELECT * FROM user", []);
    }

    public function getAllUsersToDisplay(bool $showDisabledUsers): array
    {
        return $this->dbService->execute("
            SELECT user.id, username, r.description, city, age
            FROM user
            INNER JOIN role r on user.role = r.id
            WHERE deleted = :showDisabledUsers
            ORDER BY username;", ['showDisabledUsers' => $showDisabledUsers]);
    }

    public function getUserById(int $id): ?\stdClass
    {
        $data = $this->dbService->execute("SELECT * FROM user WHERE id = :id", ["id" => $id]);
        return count($data) === 1 ? $data[0] : null;
    }

    public function createUser(string $username, string $password, int $age, string $street, string $number, string $zip, string $city, int $roleId): void
    {
        $this->dbService->execute("INSERT INTO user (username, password, age, street, house_number, zip_code, city, deleted, role) 
			VALUES (:username, :password, :age, :street, :house_number, :zip_code, :city, false, :roleId)",
            [
                'username' => $username,
                'password' => $password,
                'age' => $age,
                'street' => $street,
                'house_number' => $number,
                'zip_code' => $zip,
                'city' => $city,
                'roleId' => $roleId
            ]);
    }

    public function updateUser(int $id, string $username, string $password): void
    {
        $this->dbService->execute("UPDATE user SET username = :username, password = :password WHERE id = :id",
            ["id" => $id, "username" => $username, "password" => $password]);
    }

    public function updateAttributeById(int $id, User $attribute, string $value): void
    {
        $this->dbService->execute("UPDATE user SET $attribute->value = :value WHERE id = :id",
            ["id" => $id, "value" => $value]);
    }

    public function deleteUser(int $id): void
    {
        $this->dbService->execute("UPDATE user SET deleted = 1 WHERE id = :id", ["id" => $id]);

    }

    public function getRoles(): array
    {
        return $this->dbService->execute("SELECT id, description FROM role WHERE selectable_at_signup ORDER BY is_default_role DESC ;", []);
    }

//    not in main application
    public function findUserWhereUsernameLike(string $search): array
    {
        return $this->dbService->execute("SELECT * FROM user WHERE username LIKE :search", ["search" => '%' . $search . '%']);
    }
}