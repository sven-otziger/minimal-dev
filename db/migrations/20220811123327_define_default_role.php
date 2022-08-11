<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class DefineDefaultRole extends AbstractMigration
{
    public function up(): void
    {
        $this->execute("UPDATE role SET is_default_role = 1 WHERE description = 'visitor'");
    }

    public function down(): void
    {
        $this->execute("UPDATE role SET is_default_role = 0 WHERE description = 'visitor'");
    }
}
