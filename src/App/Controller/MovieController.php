<?php

namespace Controller;

use Repository\MovieRepository;
use Service\DatabaseService;

class MovieController extends Controller
{
    private MovieRepository $movieRepo;

    public function __construct(array $parameters, array $arguments)
    {
        $this->movieRepo = new MovieRepository();
        parent::__construct($parameters, $arguments);
    }

    public function showMovie(int $id): void
    {
        $movie = $this->movieRepo->getMovie($id);
        $movie->length .= ' min.';
        $movie->rating .= '/5';

        $username = $this->sessionService->getUsername();
        $permissions = $this->permissionService->getPermissions($this->sessionService->getId());

        $this->twigService->renderTwigTemplate('movie/show-movie.html.twig',
            [
                'movie' => $movie,
                'username' => $username,
                'permissions' => $permissions
            ]);
    }

    public function showAllMovies(array $payload = null): void
    {
        $movies = $this->movieRepo->getAllMovies();
        $username = $this->sessionService->getUsername();

        $this->twigService->renderTwigTemplate('movie/show-all-movies.html.twig',
            [
                'movies' => $movies,
                'username' => $username
            ]);
    }

    public function renderCreateTemplate(array $payload = null): void
    {
        $origin = 'home';
        if (isset($payload['origin'])) {
            $origin = $payload['origin'];
        }
        $username = $this->sessionService->getUsername();
        $permissions = $this->permissionService->getPermissions($this->sessionService->getId());

        $directors = $this->movieRepo->getDirectors();
        $actors = $this->movieRepo->getActors();


        $this->twigService->renderTwigTemplate('movie/create-movie.html.twig',
            [
                'username' => $username,
                'permissions' => $permissions,
                'origin' => $origin,
                'directors' => $directors,
                'actors' => $actors
            ]);

    }

    public function createMovie(array $payload): void
    {
        $title = $payload['title'];
        $description = $payload['description'];
        $length = $payload['length'];
        $rating = $payload['rating'];
        $actor = $payload['actor'];
        $director = $payload['director'];

        $this->movieRepo->createMovie($title, $description, $director, $actor, $length, $rating);
        $lastId = DatabaseService::getInstance()->getConnection()->lastInsertId();
        $this->showMovie($lastId);
    }

    public function renderEditTemplate(array $payload): void
    {
        $username = $this->sessionService->getUsername();
        $movie = $this->movieRepo->getMovie($payload['id']);
        $permissions = $this->permissionService->getPermissions($this->sessionService->getId());

        $this->twigService->renderTwigTemplate('movie/update-movie.html.twig',
            [
                'username' => $username,
                'movie' => $movie,
                'permissions' => $permissions
            ]);
    }

    public function updateMovie($payload): void
    {
        $id = intval($payload['id']);
        $title = $payload['title'];
        $description = $payload['description'];
        $length = $payload['length'];
        $rating = $payload['rating'];

        $movieFromDb = $this->movieRepo->getMovie($id);

        if ($title !== $movieFromDb->title) {
            $this->movieRepo->updateTitle($title, $id);
        }

        if ($description !== $movieFromDb->description) {
            $this->movieRepo->updateDescription($description, $id);
        }

        if ($length !== $movieFromDb->length) {
            $this->movieRepo->updateLength($length, $id);
        }

        if ($rating !== $movieFromDb->rating) {
            $this->movieRepo->updateRating($rating, $id);
        }

        $this->showMovie($id);
    }

    public function deleteMovie(array $payload): void
    {
        $id = intval($payload['id']);
        $this->movieRepo->deleteMovie($id);
        $this->showAllMovies();
    }

    public function getActors()
    {
        echo json_encode($this->movieRepo->getActors());
    }

    public function getDirectors()
    {
        echo json_encode($this->movieRepo->getDirectors());
    }
}
