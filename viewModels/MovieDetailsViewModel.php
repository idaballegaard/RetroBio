<?php
require_once __DIR__ . "/BasicViewModel.php";
require_once __DIR__ . "/../models/Movie.php";

class MovieDetailsViewModel extends BasicViewModel {
    private Movie $movie;
    private string $company;
    private array $genres = [];
    private array $cast = [];
    private array $showings = [];

    // Setters
    public function setMovie(Movie $movie): void { $this->movie = $movie; }
    public function setCompany(string $company): void { $this->company = $company; }
    public function setGenres(array $genres): void { $this->genres = $genres; }
    public function setCast(array $cast): void { $this->cast = $cast; }
    public function setShowings(array $showings): void { $this->showings = $showings; }

    // Getters
    public function getMovie(): Movie { return $this->movie; }
    public function getCompany(): string { return $this->company; }
    public function getGenres(): array { return $this->genres; }
    public function getCast(): array { return $this->cast; }
    public function getShowings(): array { return $this->showings; }
}