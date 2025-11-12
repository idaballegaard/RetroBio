<?php
class MovieDetails {
    private int $movieID;
    private string $title;
    private string $description;
    private int $releaseYear;
    private int $length;
    private string $language;
    private string $ageLimit;
    private float $ranking;
    private string $director;
    private string $company;
    private string $genres;
    private string $actors;

    public function getMovieID(): int {
        return $this->movieID;
    }

    public function setMovieID(int $movieID): void {
        $this->movieID = $movieID;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function getReleaseYear(): int {
        return $this->releaseYear;
    }

    public function setReleaseYear(int $releaseYear): void {
        $this->releaseYear = $releaseYear;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function getLength(): int {
        return $this->length;
    }

    public function setLength(int $length): void {
        $this->length = $length;
    }

    public function getLanguage(): string {
        return $this->language;
    }

    public function setLanguage(string $language): void {
        $this->language = $language;
    }

    public function getAgeLimit(): string {
        return $this->ageLimit;
    }
    
    public function setAgeLimit(string $ageLimit): void {
        $this->ageLimit = $ageLimit;
    }

    public function getRanking(): float {
        return $this->ranking;
    }

    public function setRanking(float $ranking): void {
        $this->ranking = $ranking;
    }

    public function getDirector(): string {
        return $this->director;
    }

    public function setDirector(string $director): void {
        $this->director = $director;
    }

    public function getCompany(): string {
        return $this->company;
    }

    public function setCompany(string $company): void {
        $this->company = $company;
    }

    public function getGenres(): string {
        return $this->genres;
    }

    public function setGenres(string $genres): void {
        $this->genres = $genres;
    }

    public function getActors(): string {
        return $this->actors;
    }

    public function setActors(string $actors): void {
        $this->actors = $actors;
    }
}