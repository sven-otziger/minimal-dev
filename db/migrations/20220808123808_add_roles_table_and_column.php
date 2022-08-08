<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddRolesTableAndColumn extends AbstractMigration
{
    public function change(): void
    {
        $user = $this->table('user');
        $user
            ->addColumn('role', 'integer', ['after' => 'username', 'default' => null, 'null' => true])
            ->update();

        $role = $this->table('role');
        $role
            ->addColumn('description', 'string', ['limit' => 32, 'null' => false])
            ->addColumn('r_other_users', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('u_other_users', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('d_other_users', 'boolean', ['default' => false, 'null' => false])

            ->addColumn('c_show', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('r_show', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('u_show', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('d_show', 'boolean', ['default' => false, 'null' => false])

            ->addColumn('c_review', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('r_review', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('u_review', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('d_review', 'boolean', ['default' => false, 'null' => false])

            ->addTimestamps()
            ->addColumn('created_by', 'integer', ['null' => false])
            ->addColumn('updated_by', 'integer', ['null' => true])

            ->create();
    }
}
