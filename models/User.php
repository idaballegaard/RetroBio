<?php
class User {
    private int $userID;
    private string $firstName;
    private string $lastName;
    private string $username;
    private string $email;
    private string $hashedPassword;
    private string $phone;
    private string $country;
    private string $street;
    private string $streetNumber;
    private string $postalCode;
    private string $city;
    private bool $isAdmin;

    public function getUserID() : int {
        return $this->userID;
    }
    public function setUserID(int $userID) : void {
        $this->userID = $userID;
    }
    public function getFirstName() : string {
        return $this->firstName;
    }
    public function setFirstName(string $firstName) : void {
        $this->firstName = $firstName;
    }
    public function getLastName() : string {
        return $this->lastName;
    }
    public function setLastName(string $lastName) : void {
        $this->lastName = $lastName;
    }
    public function getUsername() : string {
        return $this->username;
    }
    public function setUsername(string $username) : void {
        $this->username = $username;
    }
    public function getEmail() : string {
        return $this->email;
    }
    public function setEmail(string $email) : void {
        $this->email = $email;
    }
    public function getHashedPassword() : string {
        return $this->hashedPassword;
    }
    public function setHashedPassword(string $hashedPassword) : void {
        $this->hashedPassword = $hashedPassword;
    }
    public function getPhone() : string {
        return $this->phone;
    }
    public function setPhone(string $phone) : void {
        $this->phone = $phone;
    }

    public function getCountry() : string {
        return $this->country;
    }
    public function setCountry(string $country) : void {
        $this->country = $country;
    }

    public function getStreet() : string {
        return $this->street;
    }
    public function setStreet(string $street) : void {
        $this->street = $street;
    }

    public function getStreetNumber() : string {
        return $this->streetNumber;
    }
    public function setStreetNumber(string $streetNumber) : void {
        $this->streetNumber = $streetNumber;
    }

    public function getPostalCode() : string {
        return $this->postalCode;
    }
    public function setPostalCode(string $postalCode) : void {
        $this->postalCode = $postalCode;
    }

    public function getCity() : string {
        return $this->city;
    }
    public function setCity(string $city) : void {
        $this->city = $city;
    }

    public function getIsAdmin() : bool {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin) : void {
        $this->isAdmin = $isAdmin;
    }

    public function __toString(): string {
        return $this->firstName . ' ' . $this->lastName;
    }
}