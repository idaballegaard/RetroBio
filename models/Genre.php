<?php
class Genre {
    private int $genreID;
    private string $name;

    public function getGenreID(): int {
        return $this->genreID;
    }

    public function setGenreID(int $genreID): void {
        $this->genreID = $genreID;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function __toString(): string {
        return $this->name;
    }
}
