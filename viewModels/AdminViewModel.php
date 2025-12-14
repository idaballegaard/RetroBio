<?php
require_once __DIR__ . "/BasicViewModel.php";

class AdminViewModel extends BasicViewModel
{
    // @var Showing[]
    private array $showings = [];
    // @var News[]
    private array $news = [];
    // @var Movie[]
    private array $movies = [];
    private ?array $about = null;
    // @var Hall[]
    private array $halls = [];

    /** @var Order[] */
    private array $orders = [];

    /** @var User[] */
    private array $orderUsers = [];

    /** @var Movie[] */
    private array $orderMovies = [];

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

    public function setAbout(?array $about): void
    {
        $this->about = $about;
    }

    public function getAbout(): ?array
    {
        return $this->about;
    }
    
    public function setHalls(array $halls): void
    {
        $this->halls = $halls;
    }

    public function getHalls(): array
    {
        return $this->halls;
    }

    public function setOrders(array $orders): void
    {
        $this->orders = $orders;
    }

    public function getOrders(): array
    {
        return $this->orders;
    }

    public function setOrderUsers(array $orderUsers): void
    {
        $this->orderUsers = $orderUsers;
    }

    public function getOrderUsers(): array
    {
        return $this->orderUsers;
    }

    public function setOrderMovies(array $orderMovies): void
    {
        $this->orderMovies = $orderMovies;
    }

    public function getOrderMovies(): array
    {
        return $this->orderMovies;
    }
}