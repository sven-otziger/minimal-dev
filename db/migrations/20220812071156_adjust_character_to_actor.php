<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AdjustCharacterToActor extends AbstractMigration
{
    public function up(): void
    {
        $this->table('movie')
            ->renameColumn('main_character', 'main_actor')
            ->update();

        $this->table('tv_series')
            ->renameColumn('main_character', 'main_actor')
            ->update();

        $this->table('character')
            ->rename('actor')
            ->removeColumn('name')
            ->update();

        $this->table('actor')
            ->renameColumn('played_by', 'name')
            ->update();
    }

    public function down(): void
    {
        $this->table('movie')
            ->renameColumn('main_actor', 'main_character')
            ->update();

        $this->table('tv_series')
            ->renameColumn('main_actor', 'main_character')
            ->update();

        $this->table('actor')
            ->rename('character')
            ->renameColumn('name', 'played_by')
            ->update();

        $this->table('character')
            ->addColumn('name', 'string', ['null' => false])
            ->update();
    }
}
