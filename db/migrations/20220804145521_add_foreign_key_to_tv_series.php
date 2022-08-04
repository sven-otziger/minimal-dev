<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddForeignKeyToTvSeries extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('tv_series');
        $table->addForeignKey('main_character', 'character', 'id');
        $table->update();
    }
}
