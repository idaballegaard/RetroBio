<?php
require_once __DIR__ . "/BaseController.php";
require_once __DIR__ . "/../viewModels/TestViewModel.php";
class TestController extends BaseController {
    public function showFrontpage() {
        $viewModel = new TestViewModel(__DIR__ . "/../views/test.php");
        $viewModel->setMessage("Hello from the TestController!");
        return $viewModel;
    }
}