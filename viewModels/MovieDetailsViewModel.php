<?php
require_once __DIR__ . "/BasicViewModel.php";
require_once __DIR__ . "/../models/Movie.php";

class MovieDetailsViewModel extends BasicViewModel {

    /** @var Movie[] Liste over alle film */
    private array $allMovies = [];

    /** @var ?Movie */
    private ?Movie $selectedMovie = null;

    /** @var Showing[] */
    private array $futureShowings = [];

    // Setters
    public function setAllMovies(array $movies): void {
        $this->allMovies = $movies;
    }

    public function setSelectedMovie(?Movie $movie): void {
        $this->selectedMovie = $movie;
    }

    public function setFutureShowings(array $showings): void {
        $this->futureShowings = $showings;
    }

    // Getters
    public function getAllMovies(): array {
        return $this->allMovies;
    }

    public function getSelectedMovie(): ?Movie {
        return $this->selectedMovie;
    }

    public function getFutureShowings(): array {
        return $this->futureShowings;
    }

    public function getFutureShowingDates(): array {
        $dates = [];
        foreach ($this->futureShowings as $showing) {
            $dateStr = $showing->getDate()->format('j. F Y');
            if (!in_array($dateStr, $dates)) {
                $dates[] = $dateStr;
            }
        }
        return $dates;
    }
}