<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddForeignKeyRoleAndCreatedUpdatedBy extends AbstractMigration
{
    public function change(): void
    {
        $this->table('user')
            ->addForeignKey('role', 'role', 'id')
            ->update();

        $this->table('role')
            ->addForeignKey('created_by', 'user', 'id')
            ->addForeignKey('updated_by', 'user', 'id')
            ->update();


    }
}
