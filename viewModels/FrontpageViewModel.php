<?php
require_once __DIR__ . "/BasicViewModel.php";
class FrontpageViewModel extends BasicViewModel {
    // @var Showing[]
    private array $showings = [];

    // @var News[]
    private array $news = [];

    // @var About|null
    private ?About $about = null;

    /**
     * @return Movie[]
     */
    public function getShowings(): array {
        return $this->showings;
    }

    /**
     * @param Movie[] $movies
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
     * @return About[]
     */
    public function getAbout(): ?About {
        return $this->about;
    }

    /**
     * @param About $about
     */
    public function setAbout(About $about): void {
        $this->about = $about;
    }
}