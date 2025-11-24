<?php
require_once __DIR__ . "/BasicViewModel.php";

class BookingViewModel extends BasicViewModel {
    
    // @var Showing|null
    private $showing = null;

    // @var Seat[]|null
    private $seats = null;

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

    public function getSeatMap() {

        /*
            const rows = [
      { id:1, seats:12 },
      { id:2, seats:12 },
      { id:3, seats:12 },
      { id:4, seats:12 },
      { id:5, seats:12 },
    ];
        */
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
}