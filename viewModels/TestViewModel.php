<?php
require_once __DIR__ . "/../viewModels/BasicViewModel.php";
class TestViewModel extends BasicViewModel {
    private $message;

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message): void {
        $this->message = $message;
    }
}