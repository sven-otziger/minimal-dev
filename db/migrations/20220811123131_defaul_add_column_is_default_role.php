<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class DefaulAddColumnIsDefaultRole extends AbstractMigration
{
    public function change(): void
    {
        $this->table('role')->addColumn('is_default_role', 'boolean',
            ['default' => 0, 'null' => false,'after' => 'selectable_at_signup'])->update();
    }
}
