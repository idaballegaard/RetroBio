<?php
require_once __DIR__ . "/BasicViewModel.php";

class MoviesAdminViewModel extends BasicViewModel {

    // @var Movie[]
    private array $movies = [];

    /**
     * @return Movie[]
     */
    public function getMovies(): array {
        return $this->movies;
    }

    /**
     * @param Movie[] $movies
     */
    public function setMovies(array $movies): void {
        $this->movies = $movies;
    }

}