<?php

namespace Repository;

use Service\DatabaseService;

class PermissionRepository extends Repository
{
    public function getPermissions(int $id): ?\stdClass
    {
        $query = "SELECT r_other_users, u_other_users, d_other_users, c_show, r_show, u_show, d_show, c_review, r_review, u_review, d_review
                    FROM user
                    INNER JOIN role ON role.id = user.role
                    WHERE user.id = :id                    
                    ";
        $dataArray = $this->dbService->execute($query, ['id' => $id]);

        if (empty($dataArray)) {
            return null;
        } else {
            return $dataArray[0];
        }
    }

}
