<?php
class CastMember {
    private int $castMemberID;
    private ?string $firstName;
    private ?string $lastName;

    public function getCastMemberID() : int {
        return $this->castMemberID;
    }
    public function setCastMemberID(int $castMemberID) : void {
        $this->castMemberID = $castMemberID;
    }
    public function getFirstName() : ?string {
        return $this->firstName;
    }
    public function setFirstName(?string $firstName) : void {
        $this->firstName = $firstName;
    }
    public function getLastName() : ?string {
        return $this->lastName;
    }
    public function setLastName(?string $lastName) : void {
        $this->lastName = $lastName;
    }

    public function __toString() {
        return $this->firstName . " " . $this->lastName;
    }
}