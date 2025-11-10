<?php
require_once __DIR__ . "/BaseController.php";
require_once __DIR__ . "/../repositories/MovieRepository.php";
require_once __DIR__ . "/../viewModels/MovieDetailsViewModel.php";

class MovieController extends BaseController {

    public function showMovieDetails(?int $movieID = null): MovieDetailsViewModel {
        $movieRepository = new MovieRepository();

        $allMovies = $movieRepository->getAllMovies();

        $selectedMovie = null;
        if ($movieID) {
            $selectedMovie = $movieRepository->getMovieById($movieID);
        }

        $viewModel = new MovieDetailsViewModel(__DIR__ . "/../views/movie-details.php");
        $viewModel->setAllMovies($allMovies);
        $viewModel->setSelectedMovie($selectedMovie);

        return $viewModel;
    }
}