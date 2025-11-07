<?php
require_once __DIR__ . "/BasicViewModel.php";

class AboutAdminViewModel extends BasicViewModel {

    // @var About[]
    private array $abouts = [];

    /**
     * @return About[]
     */
    public function getAbouts(): array {
        return $this->abouts;
    }

    /**
     * @param About[] $abouts
     */
    public function setAbouts(array $abouts): void {
        $this->abouts = $abouts;
    }

}
