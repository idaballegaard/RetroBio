<?php
require_once __DIR__ . "/../models/Movie.php";
class Order {
    private int $orderId;
    private float $price;
    private string $date;
    private string $status;
    private int $numberOfTickets;
    private int $userId;
    private int $showingId;
    private Movie $movie;

    public function getOrderId(): int {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): void {
        $this->orderId = $orderId;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function setPrice(float $price): void {
        $this->price = $price;
    }

    public function getDate(): string {
        return $this->date;
    }

    public function setDate(string $date): void {
        $this->date = $date;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function getNumberOfTickets(): int {
        return $this->numberOfTickets;
    }

    public function setNumberOfTickets(int $numberOfTickets): void {
        $this->numberOfTickets = $numberOfTickets;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function setUserId(int $userId): void {
        $this->userId = $userId;
    }

    public function getShowingId(): int {
        return $this->showingId;
    }

    public function setShowingId(int $showingId): void {
        $this->showingId = $showingId;
    }

    public function getMovie(): Movie {
        return $this->movie;
    }
}