<?php
require_once __DIR__ . "/BaseController.php";
require_once __DIR__ . "/../repositories/MovieRepository.php";
require_once __DIR__ . "/../repositories/ShowingRepository.php";
require_once __DIR__ . "/../viewmodels/FrontpageViewModel.php";
class HomeController extends BaseController {

    public function frontpage() : FrontpageViewModel {
        $showingRepository = new ShowingRepository();
    
        $viewModel = new FrontpageViewModel(__DIR__ . "/../views/index.php");
        $viewModel->setShowings($showingRepository->getShowingsThisWeek());
        return $viewModel;

        // News integration
        $newsRepository = new NewsRepository();
        $latestNews = $newsRepository->getLatestNews(5);
        $viewModel->setLatestNews($latestNews);
        return $viewModel;
    }

}