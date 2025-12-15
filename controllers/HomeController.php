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
        $showings = $showingRepository->getShowingsThisWeek();

        // Showing map by movie ID
        $showingsByDateAndMovie = [];

        foreach ($showings as $showing) {
            $date = relativeDate($showing->getDate()); // use string date as array key
            $movieID = $showing->getMovieID();

            if (!isset($showingsByDateAndMovie[$date])) {
                $showingsByDateAndMovie[$date] = [];
            }

            if (!isset($showingsByDateAndMovie[$date][$movieID])) {
                $showingsByDateAndMovie[$date][$movieID] = [];
            }

            $showingsByDateAndMovie[$date][$movieID][] = $showing;
        }
        $viewModel->setShowings($showingsByDateAndMovie);

        // Movies
        $movieRepository = new MovieRepository();
        $movieIDs = array_values(array_unique(array_map(fn($showing) => $showing->getMovieID(), $showings)));
        $viewModel->setMovies($movieRepository->getMoviesByIDs($movieIDs));

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