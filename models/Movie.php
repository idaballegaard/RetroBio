<?php
require_once __DIR__ . "/CastMember.php";

class Movie {
    private int $movieID;
    private string $title;
    private string $description;
    private int $length;
    private string $language;
    private string $genre;
    private int $ageLimit;
    private float $ranking;
    private int $releaseYear;
    private CastMember $director;
    // @var CastMember[]
    private array $actors = [];
    // @var string[]
    private array $genres = [];
    
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

    public function getAgeLimit(): int {
        return $this->ageLimit;
    }

    public function setAgeLimit(int $ageLimit): void {
        $this->ageLimit = $ageLimit;
    }

    public function getRanking(): float {
        return $this->ranking;
    }

    public function setRanking(float $ranking): void {
        $this->ranking = $ranking;
    }

    public function getReleaseYear(): int {
        return $this->releaseYear;
    }

    public function setReleaseYear(int $releaseYear): void {
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

    // @return string[]
    public function getGenres(): array {
        return $this->genres;
    }

    public function setGenres(array $genres): void {
        $this->genres = $genres;
    }

    public function addGenre(string $genre): void {
        $this->genres[] = $genre;
    }
}
