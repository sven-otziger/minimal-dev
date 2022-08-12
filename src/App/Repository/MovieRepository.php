<?php

namespace Repository;

class MovieRepository extends Repository
{
    public function getMovie(int $movieId): ?\stdClass
    {
        $query = "
SELECT movie.id, title, description, a.name as 'actor', d.name as 'director', length, rating
FROM movie
INNER JOIN actor a on movie.main_actor = a.id
INNER JOIN director d on movie.director = d.id
WHERE movie.id = :id
";
        $movie = $this->dbService->execute($query, ['id' => $movieId]);
        return empty($movie) ? null : $movie[0];
    }

    public function getAllMovies(): array
    {
        $query = "
            SELECT movie.id, title, a.name as 'actor', d.name as 'director', rating
            FROM movie
            INNER JOIN actor a on movie.main_actor = a.id
            INNER JOIN director d on movie.director = d.id
        ";
        return $this->dbService->execute($query, []);
    }
}
