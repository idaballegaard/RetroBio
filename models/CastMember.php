<?php
class CastMember {
    private int $castMemberID = 0;

    private string $name;

    public function getCastMemberID() : int {
        return $this->castMemberID;
    }
    public function setCastMemberID(int $castMemberID) : void {
        $this->castMemberID = $castMemberID;
    }

    public function getName() : ?string {
        return $this->name;
    }

    public function setName(?string $name) : void {
        $this->name = $name;
    }

    public function __toString() {
        return $this->name;
    }
}