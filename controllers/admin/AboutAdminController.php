<?php
require_once __DIR__ . "/BaseAdminController.php";
require_once __DIR__ . "/../../viewModels/AboutAdminViewModel.php";
require_once __DIR__ . "/../../repositories/AboutRepository.php";

class AboutAdminController extends BaseAdminController {

    public function aboutInfo() {
        $viewModel = new AboutAdminViewModel(__DIR__ . "/../../views/admin.php");

        $aboutRepository = new AboutRepository();
        $about = $aboutRepository->getAboutInfo();
        if ($about) {
            $viewModel->setAbouts([$about]);
        } else {
            $viewModel->setAbouts([]);
        }

        return $viewModel;
    }
}