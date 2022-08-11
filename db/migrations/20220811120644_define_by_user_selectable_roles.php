<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class DefineByUserSelectableRoles extends AbstractMigration
{
    public function up(): void
    {
        $this->execute("
           UPDATE role
           SET selectable_at_signup = 1
            WHERE description = 'critic'
               OR description = 'visitor'
        ");
    }

    public function down(): void
    {
        $this->execute("
           UPDATE role
           SET selectable_at_signup = 0
           WHERE description = 'critic'
              OR description = 'visitor'
        ");
    }
}
