<?php
require_once __DIR__ . "/BasicViewModel.php";

class ShowingsAdminViewModel extends BasicViewModel {

    // @var Showing[]
    private array $showings = [];

    /**
     * @return Showing[]
     */
    public function getShowings(): array {
        return $this->showings;
    }

    /**
     * @param Showing[] $showings
     */
    public function setShowings(array $showings): void {
        $this->showings = $showings;
    }

}