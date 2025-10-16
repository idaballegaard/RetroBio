<?php
require_once __DIR__ . "/CastMember.php";
class Movie {
    private int $movieID;
    private string $title;
    private string $description;
    private int $lenght;
    private string $language;
    private string $genre;
    private string $ageLimit;
    private string $ranking;
    private string $releaseYear;
    private CastMember $director;
    // @var CastMember[]
    private array $actors = [];
    
    public function __construct() {
        $this->director = new CastMember();
    }
    
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

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function getLenght(): int {
        return $this->lenght;
    }

    public function setLenght(int $lenght): void {
        $this->lenght = $lenght;
    }

    public function getLanguage(): string {
        return $this->language;
    }

    public function setLanguage(string $language): void {
        $this->language = $language;
    }

    public function getGenre(): string {
        return $this->genre;
    }

    public function setGenre(string $genre): void {
        $this->genre = $genre;
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

    public function getReleaseYear(): string {
        return $this->releaseYear;
    }

    public function setReleaseYear(string $releaseYear): void {
        $this->releaseYear = $releaseYear;
    }

    public function getDirector(): CastMember {
        return $this->director;
    }

    public function setDirector(CastMember $director): void {
        $this->director = $director;
    }

    // @return CastMember[]
    public function getActors(): array {
        return $this->actors;
    }

    // @param CastMember[] $actors
    public function setActors(array $actors): void {
        $this->actors = $actors;
    }

    public function addActor(CastMember $actor): void {
        $this->actors[] = $actor;
    }
}
