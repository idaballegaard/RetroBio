<?php
require_once __DIR__ . "/BasicViewModel.php";

class ContactViewModel extends BasicViewModel {

    private bool $mailSent = false;

    public function getMailSent(): bool {
        return $this->mailSent;
    }

    public function setMailSent(bool $mailSent): void {
        $this->mailSent = $mailSent;
    }
}