<?php
require_once __DIR__ . "/BasicViewModel.php";

class BookingViewModel extends BasicViewModel {
    
    // @var Showing|null
    private $showing = null;

    // @var Seat[]|null
    private $seats = null;

    // @var Seat[]|null
    private $soldSeats = null;

    public function __construct($viewPath) {
        parent::__construct($viewPath);
    }

    public function getShowing() {
        return $this->showing;
    }

    public function setShowing($showing): void {
        $this->showing = $showing;
    }

    public function getSeats() {
        return $this->seats;
    }

    public function setSeats($seats): void {
        $this->seats = $seats;
    }

    public function getSoldSeats() {
        return $this->soldSeats;
    }

    public function setSoldSeats($soldSeats): void {
        $this->soldSeats = $soldSeats;
    }

    public function getSeatMap() {
        // Transform seats into the desired format with row id and seat count
        $rows = [];
        if ($this->seats !== null) {
            $seatCounts = [];
            foreach ($this->seats as $seat) {
                $rowNumber = $seat->getRowNumber();
                if (!isset($seatCounts[$rowNumber])) {
                    $seatCounts[$rowNumber] = 0;
                }
                $seatCounts[$rowNumber]++;
            }
            
            foreach ($seatCounts as $rowNumber => $count) {
                $rows[] = [
                    'id' => $rowNumber,
                    'seats' => $count
                ];
            }
        }
        return $rows;
    }

    public function getSoldSeatMap() {
        $soldSeatIds = [];
        if ($this->soldSeats !== null) {
            foreach ($this->soldSeats as $seat) {
                $soldSeatIds[] = $seat->__toString();
            }
        }
        return $soldSeatIds;
    }
}