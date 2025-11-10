<?php
require_once __DIR__ . "/BaseController.php";
require_once __DIR__ . "/../repositories/MovieRepository.php";
require_once __DIR__ . "/../viewModels/MovieDetailsViewModel.php";

class MovieController extends BaseController {

    public function showMovieDetails(?int $movieID = null): MovieDetailsViewModel {
        $movieRepository = new MovieRepository();

        // Henter alle film til dropdown
        $allMovies = $movieRepository->getAllMovies();

        // Henter den valgte film (hvis brugeren har valgt en)
        $selectedMovie = null;
        if ($movieID) {
            $selectedMovie = $movieRepository->getMovieById($movieID);
        }

        // Pakker data i ViewModel
        $viewModel = new MovieDetailsViewModel(__DIR__ . "/../views/movie-details.php");
        $viewModel->setAllMovies($allMovies);
        $viewModel->setSelectedMovie($selectedMovie);

        return $viewModel;
    }
}