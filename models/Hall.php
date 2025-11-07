<?php
class Hall {
    private int $hallID;
    private string $name;
    private int $number;

    public function getHallID(): int {
        return $this->hallID;
    }

    public function setHallID(int $hallID): void {
        $this->hallID = $hallID;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getNumber(): int {
        return $this->number;
    }
    
    public function setNumber(int $number): void {
        $this->number = $number;
    }

    public function __toString(): string {
        return $this->name;
    }
}