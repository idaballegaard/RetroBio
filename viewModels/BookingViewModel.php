<?php
require_once __DIR__ . "/BasicViewModel.php";

class BookingViewModel extends BasicViewModel {
    
    private Showing|null $showing = null;

    /** @var Seat[] */
    private array $seats = [];

    /** @var Seat[] */
    private array $soldSeats = [];

    private Movie $movie;

    public function __construct($viewPath) {
        parent::__construct($viewPath);
    }

    public function getShowing() : Showing {
        return $this->showing;
    }

    public function setShowing($showing): void {
        $this->showing = $showing;
    }

    public function setSeats($seats): void {
        $this->seats = $seats;
    }

    public function setSoldSeats($soldSeats): void {
        $this->soldSeats = $soldSeats;
    }

    /** @returns Seat[] */
    public function getSeatMap() : array {
        // Transform seats into the desired format with row id and seat count
        $rows = [];
        foreach($this->seats as $seat) {
            $rowNumber = $seat->getRowNumber();
            if (!isset($rows[$rowNumber])) {
                $rows[$rowNumber] = array();
            }
            $rows[$rowNumber][] = $seat;
        }
        return $rows;
    }

    /** @returns Seat[] */
    public function getSoldSeatMap() : array {
        $soldSeats = [];
        foreach ($this->soldSeats as $seat) {
            $soldSeats[$seat->getSeatID()] = $seat;
        }
        return $soldSeats;
    }

    public function getMovie() : Movie {
        return $this->movie;
    }

    public function setMovie(Movie $movie): void {
        $this->movie = $movie;
    }
}