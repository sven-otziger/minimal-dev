<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddDirectorColumnAdjustRatingDatatype extends AbstractMigration
{
    private string $placeholderDirector = 'Placeholder Director';

    public function up(): void
    {
        $this->table('director')
            ->addColumn('name', 'string', ['null' => false, 'limit' => 64])
            ->create();

        $builder = $this->getQueryBuilder();
        $builder->insert(['name'])
            ->into('director')
            ->values(['name' => $this->placeholderDirector])
            ->execute();

        $movie = $this->table('movie');

        $movie->changeColumn('director', 'integer')
            ->update();

        $movie->addForeignKey('director', 'director', 'id')
            ->update();
    }

    public function down(): void
    {
        $this->table('director')
            ->drop()
            ->update();

        $builder = $this->getQueryBuilder();
        $builder->delete('director')
            ->where(['name' => $this->placeholderDirector])
            ->execute();

        $movie = $this->table('movie');

        $movie->changeColumn('director', 'string')
            ->update();

        $movie->dropForeignKey('director',)
            ->update();
    }
}
