<?php

namespace Controller;

use Repository\MovieRepository;

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

        $username = $this->sessionHandler->getUsername();
        $permissions = $this->permissionHandler->getPermissions($this->sessionHandler->getId());

        $this->twigHandler->renderTwigTemplate('movie/show-movie.html.twig',
            [
                'movie' => $movie,
                'username' => $username,
                'permissions' => $permissions
            ]);
    }

    public function showAllMovies(array $payload = null): void
    {
        $movies = $this->movieRepo->getAllMovies();
        $username = $this->sessionHandler->getUsername();

        $this->twigHandler->renderTwigTemplate('movie/show-all-movies.html.twig',
            [
                'movies' => $movies,
                'username' => $username
            ]);
    }

    public function renderEditTemplate(array $payload): void
    {
        $username = $this->sessionHandler->getUsername();
        $movie = $this->movieRepo->getMovie($payload['id']);
        $permissions = $this->permissionHandler->getPermissions($this->sessionHandler->getId());

        $this->twigHandler->renderTwigTemplate('movie/update-movie.html.twig',
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
}
