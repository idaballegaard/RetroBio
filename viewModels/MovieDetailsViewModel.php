<?php
require_once __DIR__ . "/BasicViewModel.php";
require_once __DIR__ . "/../models/Movie.php";

class MovieDetailsViewModel extends BasicViewModel {

    /** @var Movie[] Liste over alle film */
    private array $allMovies = [];

    /** @var ?Movie Den valgte film (kan være null, hvis ingen valgt) */
    private ?Movie $selectedMovie = null;

    // Setters
    public function setAllMovies(array $movies): void {
        $this->allMovies = $movies;
    }

    public function setSelectedMovie(?Movie $movie): void {
        $this->selectedMovie = $movie;
    }

    // Getters
    public function getAllMovies(): array {
        return $this->allMovies;
    }

    public function getSelectedMovie(): ?Movie {
        return $this->selectedMovie;
    }
}