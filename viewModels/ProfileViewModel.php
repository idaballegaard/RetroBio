<?php
require_once __DIR__ . "/BasicViewModel.php";
class ProfileViewModel extends BasicViewModel {
    private User $user;

    public function getUser(): User {
        return $this->user;
    }

    public function setUser(User $user): void {
        $this->user = $user;
    }
}