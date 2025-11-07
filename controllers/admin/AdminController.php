<?php
require_once __DIR__ . "/BaseAdminController.php";
require_once __DIR__ . "/../../viewModels/BasicViewModel.php";

class AdminController extends BaseAdminController {

    public function adminFrontpage() {
        $viewModel = new BasicViewModel(__DIR__ . "/../../views/admin.php");
        return $viewModel;
    }

}