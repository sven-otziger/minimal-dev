<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddTablesTvSeriesAndCharacter extends AbstractMigration
{
    public function up(): void
    {
        $tableCharacter = $this->table('character');
        $tableCharacter->addColumn('name', 'string')
            ->addColumn('played_by', 'string')
            ->create();

        $tableSeries = $this->table('tv_series');
        $tableSeries->addColumn('title', 'string')
            ->addColumn('seasons', 'integer')
            ->addColumn('main_character', 'integer')
            ->create();
    }

    public function down()
    {
        $tableCharacter = $this->table('character');
        $tableCharacter->drop()->update();
        $tableSeries = $this->table('tv_series');
        $tableSeries->drop()->update();
    }
}
