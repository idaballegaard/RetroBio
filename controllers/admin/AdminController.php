<?php
require_once __DIR__ . "/BaseAdminController.php";
require_once __DIR__ . "/../../viewModels/AdminViewModel.php";
require_once __DIR__ . "/../../repositories/MovieRepository.php";
require_once __DIR__ . "/../../repositories/ShowingRepository.php";
require_once __DIR__ . "/../../repositories/NewsRepository.php";
require_once __DIR__ . "/../../repositories/AboutRepository.php";
require_once __DIR__ . "/../../repositories/GenreRepository.php";
require_once __DIR__ . "/../../repositories/CastMemberRepository.php";
require_once __DIR__ . "/../../repositories/CompanyRepository.php";

class AdminController extends BaseAdminController {

    private GenreRepository $genreRepository;
    private MovieRepository $movieRepository;
    private CastMemberRepository $castMemberRepository;
    private CompanyRepository $companyRepository;

    public function __construct() {
        parent::__construct();
        $this->genreRepository = new GenreRepository();
        $this->movieRepository = new MovieRepository();
        $this->castMemberRepository = new CastMemberRepository();
        $this->companyRepository = new CompanyRepository();
    }

    public function adminFrontpage() {
        $viewModel = new AdminViewModel(__DIR__ . "/../../views/admin.php");

        $movieRepository = new MovieRepository();
        $showingRepository = new ShowingRepository();
        $newsRepository = new NewsRepository();
        $aboutRepository = new AboutRepository();

        $viewModel->setMovies($movieRepository->getAllMovies());
        $viewModel->setShowings($showingRepository->getAllShowings());
        $viewModel->setNews($newsRepository->getAllNews());
        $viewModel->setAbout($aboutRepository->getAboutInfo());

        return $viewModel;
    }

    public function saveMovie() {
        $id = $_POST["id"];
        $title = $_POST["title"];
        $genre = $_POST["genre"];
        $cast = $_POST["cast"];
        $description = $_POST["description"];
        $releaseYear = $_POST["releaseYear"];
        $length = $_POST["length"];
        $language = $_POST["language"];
        $ranking = $_POST["ranking"];
        $company = $_POST["company"];
        $director = $_POST["director"];
        $ageLimit = $_POST["ageLimit"];
        $company = $_POST["company"];

        $company = $this->companyRepository->saveCompany($company);
        $genres = $this->genreRepository->saveGenres(array_map('trim', explode(',', $genre)));
        $actors = $this->castMemberRepository->saveCastMembers(array_map('trim', explode(',', $cast)));
        $director = $this->castMemberRepository->saveCastMembers([trim($director)])[0];

        $movie = new Movie();
        $movie->setMovieID((int)$id);
        $movie->setTitle($title);
        $movie->setDescription($description);
        $movie->setAgeLimit((int)$ageLimit);
        $movie->setGenres($genres);
        $movie->setReleaseYear((int)$releaseYear);
        $movie->setLength((int)$length);
        $movie->setLanguage($language);
        $movie->setRanking((float)$ranking);
        $movie->setCompany($company);
        $movie->setDirector($director);
        $movie->setActors($actors);

        $this->movieRepository->saveMovie($movie);
    }

    public function delete(string $type, int $id) {
        if($type === 'movie') {
            $this->movieRepository->deleteMovie($id);
        }
    }   

}