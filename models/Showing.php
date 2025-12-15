<?php
require_once __DIR__ . "/Hall.php";
require_once __DIR__ . "/Movie.php";

class Showing
{
  private int $showingID;
  private string $type;
  private DateTime $date;
  private float $price;
  private Movie $movie;
  private int $movieID;
  private Hall $hall;
  /** @var string[] */
  private array $reelTimes;
  private string $startTime;

  public function __construct()
  {
    $this->reelTimes = [];
    $this->hall = new Hall();
  }

  public function getShowingID(): int
  {
    return $this->showingID;
  }

  public function setShowingID(int $showingID): void
  {
    $this->showingID = $showingID;
  }

  public function getType(): string
  {
    return $this->type;
  }

  public function setType(string $type): void
  {
    $this->type = $type;
  }

  public function getDate(): DateTime
  {
    return $this->date;
  }

  public function setDate(DateTime $date): void
  {
    $this->date = $date;
  }

  public function getPrice(): float
  {
    return $this->price;
  }

  public function setPrice(float $price): void
  {
    $this->price = $price;
  }

  public function getMovie(): Movie
  {
    return $this->movie;
  }

  public function getHall(): Hall
  {
    return $this->hall;
  }

  public function setHall(Hall $hall): void
  {
    $this->hall = $hall;
  }

  public function getReelTimes(): array
  {
    return $this->reelTimes;
  }

  public function setStartTime(string $startTime): void
  {
    $this->startTime = $startTime;
  }

  public function getStartTime(): string
  {
    return $this->startTime;
  }

  public function getMovieID(): int
  {
    return $this->movieID;
  }

  public function setMovieID(int $movieID): void
  {
    $this->movieID = $movieID;
  }
}