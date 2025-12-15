<?php
require_once __DIR__ . "/BasicViewModel.php";
class FrontpageViewModel extends BasicViewModel {
    // @var Showing[]
    private array $showings = [];

    // @var Movie[]
    private array $movies = [];

    // @var News[]
    private array $news = [];

    // @var About|null
    private ?array $about = null;

    /**
     * @return Showing[]
     */
    public function getShowings(): array {
        return $this->showings;
    }

    /**
     * @param Showing[] $movies
     */
    public function setShowings(array $movies): void {
        $this->showings = $movies;
    }

    /**
     * @return News[]
     */
    public function getNews(): array {
        return $this->news;
    }

    /**
     * @param News[] $news
     */
    public function setNews(array $news): void {
        $this->news = $news;
    }

    /**
     * @return array
     */
    public function getAbout(): ?array {
        return $this->about;
    }

    /**
     * @param array $about
     */
    public function setAbout(array $about): void {
        $this->about = $about;
    }

    /** @return Movie[] */
    public function getMovies(): array {
        return $this->movies;
    }

    /** @var Movie[] $movies */
    public function setMovies(array $movies): void {
        $this->movies = $movies;
    }
}