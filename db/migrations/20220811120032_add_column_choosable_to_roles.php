<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddColumnChoosableToRoles extends AbstractMigration
{
    public function change(): void
    {
        $this->table('role')
            ->addColumn('selectable_at_signup', 'boolean',
                ['default' => 0, 'null' => false,'after' => 'description'])
            ->update();
    }
}
