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

    public function getDirectors(): ?array
    {
        return $this->dbService->execute("SELECT id, name FROM director", []);
    }

    public function getActors(): ?array
    {
        return $this->dbService->execute("SELECT id, name FROM actor", []);
    }

    public function createMovie(string $title, string $description, int $directorId, int $actorId, int $length, float $rating): void
    {
        $query = "
            INSERT INTO movie (title, description, director, main_actor, length, rating)
            VALUES (:title, :description, :director, :main_actor, :length, :rating)";
        $this->dbService->execute($query,
        [
            'title' => $title,
            'description' => $description,
            'director' => $directorId,
            'main_actor' => $actorId,
            'length' => $length,
            'rating' => $rating
        ]);
    }

    public function updateTitle(string $title, int $id): void
    {
        $this->dbService->execute("UPDATE movie SET title = :title WHERE id = :id", ['title' => $title, 'id' => $id]);
    }

    public function updateDescription(string $description, int $id): void
    {
        $this->dbService->execute("UPDATE movie SET description = :description WHERE id = :id", ['description' => $description, 'id' => $id]);
    }

    public function updateLength(int $length, int $id): void
    {
        $this->dbService->execute("UPDATE movie SET length = :length WHERE id = :id", ['length' => $length, 'id' => $id]);
    }

    public function updateRating(string $rating, int $id): void
    {
        $this->dbService->execute("UPDATE movie SET rating = :rating WHERE id = :id", ['rating' => $rating, 'id' => $id]);
    }

    public function deleteMovie(int $id)
    {
        $this->dbService->execute("DELETE FROM movie WHERE id = :id", ['id' => $id]);
    }


}
