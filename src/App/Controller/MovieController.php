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
        $movie->length.=' min.';
        $movie->rating .= '/5';

        $username = $this->sessionHandler->getUsername();
        $permissions = $this->permissionHandler->getPermissions($this->sessionHandler->getId());

        $this->twigHandler->renderTwigTemplate('show-movie.html.twig',
            [
                'movie' => $movie,
                'username' => $username,
                'permissions' => $permissions
            ]);
    }

    public function showAllMovies(): void
    {
        $movies = $this->movieRepo->getAllMovies();
        $username = $this->sessionHandler->getUsername();

        $this->twigHandler->renderTwigTemplate('show-all-movies.html.twig',
            [
                'movies' => $movies,
                'username' => $username
            ]);
    }

    public function renderEditTemplate(): void
    {


    }
}
