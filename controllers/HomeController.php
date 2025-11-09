<?php
require_once __DIR__ . "/BaseController.php";
require_once __DIR__ . "/../repositories/MovieRepository.php";
require_once __DIR__ . "/../repositories/ShowingRepository.php";
require_once __DIR__ . "/../repositories/NewsRepository.php";
require_once __DIR__ . "/../repositories/AboutRepository.php";
require_once __DIR__ . "/../viewModels/FrontpageViewModel.php";

class HomeController extends BaseController {

    public function frontpage(): FrontpageViewModel {
        // Opret ViewModel
        $viewModel = new FrontpageViewModel(__DIR__ . "/../views/index.php");

        // Showings
        $showingRepository = new ShowingRepository();
        $viewModel->setShowings($showingRepository->getShowingsThisWeek());

        // News
        $newsRepository = new NewsRepository();
        $latestNews = $newsRepository->getLatestNews(5);
        $viewModel->setNews($latestNews);

        // About
        $aboutRepository = new AboutRepository();
        $aboutInfo = $aboutRepository->getAboutInfo();
        $viewModel->setAbout($aboutInfo);

        return $viewModel;
    }

}