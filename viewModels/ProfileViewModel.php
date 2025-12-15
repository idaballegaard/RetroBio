<?php
require_once __DIR__ . "/BasicViewModel.php";
class ProfileViewModel extends BasicViewModel {
    private User $user;

    /** @var Order[] */
    private array $orders;

    private array $movies;
    public function getUser(): User {
        return $this->user;
    }

    public function setUser(User $user): void {
        $this->user = $user;
    }

    public function getOrders(): array {
        return $this->orders;
    }

    public function setOrders(array $orders): void {
        $this->orders = $orders;
    }

    public function setMovies(array $movies) {
        $this->movies = $movies;
    }

    public function getMovies(): array {
        return $this->movies;
    }
}