<?php
class News {
    private int $newsID;
    private string $title;
    private string $description;
    private DateTime $releaseDate;

    public function getNewsID(): int {
        return $this->newsID;
    }

    public function setNewsID(int $newsID): void {
        $this->newsID = $newsID;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function getReleaseDate(): DateTime {
        return $this->releaseDate;
    }

    public function setReleaseDate(DateTime $releaseDate): void {
        $this->releaseDate = $releaseDate;
    }
}