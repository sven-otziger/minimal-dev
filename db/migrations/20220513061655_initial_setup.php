<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InitialSetup extends AbstractMigration
{
    public function up(): void
    {
        $userTable = $this->table('user', ['id' => true]);
        $userTable->addColumn('username', 'string', ['null' => false])
            ->addColumn('password', 'string', ['null' => false]);
        $userTable->insert(['username' => 'test.user', 'password' => 'test1234']);
        $userTable->create();
    }

    public function down(): void
    {
        $this->table('user')->drop()->update();
    }
}
