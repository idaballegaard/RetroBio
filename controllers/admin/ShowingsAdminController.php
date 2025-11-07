<?php
require_once __DIR__ . "/BaseAdminController.php";
require_once __DIR__ . "/../../viewModels/ShowingsAdminViewModel.php";
require_once __DIR__ . "/../../repositories/ShowingRepository.php";

class ShowingsAdminController extends BaseAdminController {

    public function showingsList() {
        $viewModel = new ShowingsAdminViewModel(__DIR__ . "/../../views/admin.php");

        $showingRepository = new ShowingRepository();
        $showings = $showingRepository->getAllShowings();
        $viewModel->setShowings($showings);

        return $viewModel;
    }

}