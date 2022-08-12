<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AdjustRatingDatatype extends AbstractMigration
{
    public function up(): void
    {
        $this->table('movie')->changeColumn('rating', 'float')->update();
        $this->table('tv_series')->changeColumn('rating', 'float')->update();
    }

    public function down(): void
    {
        $this->table('movie')->changeColumn('rating', 'integer')->update();
        $this->table('tv_series')->changeColumn('rating', 'integer')->update();
    }
}
