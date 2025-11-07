<?php
require_once __DIR__ . "/BaseAdminController.php";
require_once __DIR__ . "/../../viewModels/MoviesAdminViewModel.php";
require_once __DIR__ . "/../../repositories/MoviesRepository.php";

class MoviesAdminController extends BaseAdminController {

    public function moviesList() {
        $viewModel = new MoviesAdminViewModel(__DIR__ . "/../../views/admin.php");

        $moviesRepository = new MovieRepository();
        $movies = $moviesRepository->getAllMovies();
        $viewModel->setMovies($movies);

        return $viewModel;
    }

}