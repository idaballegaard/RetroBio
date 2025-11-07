<?php
require_once __DIR__ . "/BasicViewModel.php";
require_once __DIR__ . "/../models/About.php";

class AdminViewModel extends BasicViewModel
{
    // @var Showing[]
    private array $showings = [];
    // @var News[]
    private array $news = [];
    // @var Movie[]
    private array $movies = [];
    private ?About $about = null;

    public function setShowings(array $showings): void
    {
        $this->showings = $showings;
    }

    public function setNews(array $news): void
    {
        $this->news = $news;
    }

    public function getShowings(): array
    {
        return $this->showings;
    }

    public function getNews(): array
    {
        return $this->news;
    }

    public function setMovies(array $movies): void
    {
        $this->movies = $movies;
    }

    public function getMovies(): array
    {
        return $this->movies;
    }

    public function setAbout(?About $about): void
    {
        $this->about = $about;
    }

    public function getAbout(): ?About
    {
        return $this->about;
    }
}