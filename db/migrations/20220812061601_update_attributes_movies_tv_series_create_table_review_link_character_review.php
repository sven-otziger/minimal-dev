<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateAttributesMoviesTvSeriesCreateTableReviewLinkCharacterReview extends AbstractMigration
{
    public function change(): void
    {
        $movie = $this->table('movie');
        $movie->addColumn('main_character', 'integer', ['after' => 'director', 'null' => false])
            ->addColumn('description', 'text', ['after' => 'title', 'null' => false])
            ->update();
        $movie->addForeignKey('main_character', 'character', 'id')->update();

        $tvSeries = $this->table('tv_series');
        $tvSeries->addColumn('description', 'text', ['after' => 'title', 'null' => false])
            ->addColumn('rating', 'integer', ['after' => 'seasons', 'null' => false])
            ->update();

        $review = $this->table('review');
        $review->addColumn('title', 'string', ['null' => false])
            ->addColumn('author', 'integer', ['null' => false])
            ->addColumn('content', 'text', ['null' => false])
            ->addColumn('movie_affected', 'integer', ['default' => null])
            ->addColumn('tv_series_affected', 'integer', ['default' => null])
            ->create();
        $review->addForeignKey('author', 'user', 'id')
            ->addForeignKey('movie_affected', 'movie', 'id')
            ->addForeignKey('tv_series_affected', 'tv_series', 'id')
            ->update();
    }
}
