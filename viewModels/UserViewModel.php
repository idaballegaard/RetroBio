<?php
require_once __DIR__ . "/BasicViewModel.php";
require_once __DIR__ . "/../models/User.php";

class UserProfileViewModel extends BasicViewModel {
    private User $user;
    private string $firstName;
    private string $lastName;
    private string $username;
    private string $email;
    private string $phone;
    private string $country;
    private string $city;
    private string $postalCode;
    private string $street;
    private string $streetNumber;

    // Setter
    public function setUser(User $user): void { $this->user = $user; }
    public function setFirstName(string $firstName): void { $this->firstName = $firstName; }
    public function setLastName(string $lastName): void { $this->lastName = $lastName; }
    public function setUsername(string $username): void { $this->username = $username; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setPhone(string $phone): void { $this->phone = $phone; }
    public function setCountry(string $country): void { $this->country = $country; }
    public function setCity(string $city): void { $this->city = $city; }
    public function setPostalCode(string $postalCode): void { $this->postalCode = $postalCode; }
    public function setStreet(string $street): void { $this->street = $street; }
    public function setStreetNumber(string $streetNumber): void { $this->streetNumber = $streetNumber; }

    // Getter
    public function getUser(): User { return $this->user; }
    public function getFirstName(): string { return $this->firstName; }
    public function getLastName(): string { return $this->lastName; }
    public function getUsername(): string { return $this->username; }
    public function getEmail(): string { return $this->email; }
    public function getPhone(): string { return $this->phone; }
    public function getCountry(): string { return $this->country; }
    public function getCity(): string { return $this->city; }
    public function getPostalCode(): string { return $this->postalCode; }
    public function getStreet(): string { return $this->street; }
    public function getStreetNumber(): string { return $this->streetNumber; }
}
