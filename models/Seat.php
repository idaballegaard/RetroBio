<?php
class Seat {
    private int $seatID;
    private int $rowNumber;
    private int $number;
    private int $hallID;

    public function getSeatID() : int {
        return $this->seatID;
    }
    public function setSeatID(int $seatID) : void {
        $this->seatID = $seatID;
    }
    public function getRowNumber() : int {
        return $this->rowNumber;
    }
    public function setRowNumber(int $rowNumber) : void {
        $this->rowNumber = $rowNumber;
    }
    public function getNumber() : int {
        return $this->number;
    }
    public function setNumber(int $number) : void {
        $this->number = $number;
    }
    public function getHallID() : int {
        return $this->hallID;
    }
    public function setHallID(int $hallID) : void {
        $this->hallID = $hallID;
    }
}