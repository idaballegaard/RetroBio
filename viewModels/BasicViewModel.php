<?php
class BasicViewModel {
    private $viewPath = null;
    private $errorMessage = null;

    public function __construct($viewPath, $errorMessage = null) {
        $this->viewPath = $viewPath;
    }

    public function getViewPath() {
        return $this->viewPath;
    }
    public function hasFailed() {
        return $this->errorMessage !== null;
    }

    public function getErrorMessage() {
        return $this->errorMessage;
    }

    public function setErrorMessage($errorMessage): void {
        $this->errorMessage = $errorMessage;
    }

    public function presentView() {
        $viewModel = $this;
        require_once $this->viewPath;
    }
}