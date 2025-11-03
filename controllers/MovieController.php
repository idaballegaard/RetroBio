<?php
require_once __DIR__ . "/BaseController.php";
require_once __DIR__ . "/../repositories/MovieRepository.php";
require_once __DIR__ . "/../viewmodels/MovieDetailsViewModel.php";

class MovieController extends BaseController {
    public function showMovieDetails(int $movieID): MovieDetailsViewModel {
        $movieRepository = new MovieRepository();

        // Hent filmdata
        $movie = $movieRepository->getMovieById($movieID);
        $company = $movieRepository->getCompanyForMovie($movieID);
        $genres = $movieRepository->getGenresForMovie($movieID);
        $cast = $movieRepository->getCastForMovie($movieID);

        // Pak data i ViewModel
        $viewModel = new MovieDetailsViewModel(__DIR__ . "/../views/movie-details.php");
        $viewModel->setMovie($movie);
        $viewModel->setCompany($company);
        $viewModel->setGenres($genres);
        $viewModel->setCast($cast);

        return $viewModel;
    }
}