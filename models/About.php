<?php
class About {
    private int $aboutID;
    private string $title;
    private string $subtitle;
    private string $description;
    private string $address;
    private string $email;
    private string $phone;

    public function getAboutID(): int {
        return $this->aboutID;
    }

    public function setAboutID(int $aboutID): void {
        $this->aboutID = $aboutID;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function getSubtitle(): string {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): void {
        $this->subtitle = $subtitle;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function getAddress(): string {
        return $this->address;
    }

    public function setAddress(string $address): void {
        $this->address = $address;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getPhone(): string {
        return $this->phone;
    }

    public function setPhone(string $phone): void {
        $this->phone = $phone;
    }
}