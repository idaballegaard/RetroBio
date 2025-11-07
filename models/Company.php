<?php
class Company {
    private int $companyID;
    private string $name;

    public function __construct(int $companyID = 0, string $name = '') {
        $this->companyID = $companyID;
        $this->name = $name;
    }

    public function getCompanyID(): int {
        return $this->companyID;
    }

    public function setCompanyID(int $companyID): void {
        $this->companyID = $companyID;
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
