<?php
require_once __DIR__ . "/BaseAdminController.php";
require_once __DIR__ . "/../../viewModels/AdminViewModel.php";
require_once __DIR__ . "/../../repositories/MovieRepository.php";
require_once __DIR__ . "/../../repositories/ShowingRepository.php";
require_once __DIR__ . "/../../repositories/NewsRepository.php";
require_once __DIR__ . "/../../repositories/AboutRepository.php";
require_once __DIR__ . "/../../repositories/CompanyRepository.php";
require_once __DIR__ . "/../../repositories/HallRepository.php";
require_once __DIR__ . "/../../repositories/OrderRepository.php";

class AdminController extends BaseAdminController {

    private MovieRepository $movieRepository;
    private CompanyRepository $companyRepository;
    private HallRepository $hallRepository;
    private ShowingRepository $showingRepository;
    private NewsRepository $newsRepository;
    private AboutRepository $aboutRepository;
    private OrderRepository $orderRepository;
    private UserRepository $userRepository;

    public function __construct() {
        parent::__construct();
        $this->movieRepository = new MovieRepository();
        $this->companyRepository = new CompanyRepository();
        $this->hallRepository = new HallRepository();
        $this->showingRepository = new ShowingRepository();
        $this->newsRepository = new NewsRepository();
        $this->aboutRepository = new AboutRepository();
        $this->orderRepository = new OrderRepository();
        $this->userRepository = new UserRepository();
    }

    public function adminFrontpage() {
        $viewModel = new AdminViewModel(__DIR__ . "/../../views/admin.php");

        $moviesById = [];
        foreach ($this->movieRepository->getAllMovies() as $movie) {
          $moviesById[$movie->getMovieID()] = $movie;
        }
        $viewModel->setMovies($moviesById);
        $viewModel->setShowings($this->showingRepository->getAllShowings());
        $viewModel->setNews($this->newsRepository->getAllNews());
        $viewModel->setAbout($this->aboutRepository->getAboutInfo());
        $viewModel->setHalls($this->hallRepository->getAllHalls());
        $viewModel->setNews($this->newsRepository->getAllNews());
        $viewModel->setOrders($this->orderRepository->getAllOrders());

        $userIds = array_values(array_unique(array_map(fn($order) => $order->getUserId(), $viewModel->getOrders())));
        $viewModel->setOrderUsers($this->userRepository->getUsersByID($userIds));

        $showingIds = array_values(array_unique(array_map(fn($order) => $order->getShowingId(), $viewModel->getOrders())));
        $viewModel->setOrderMovies($this->movieRepository->getMoviesByShowingId($showingIds));

        return $viewModel;
    }

    public function saveMovie(): void {
        $id = $this->retrieveInput("id", FILTER_SANITIZE_NUMBER_INT);
        $title = $this->retrieveInput("title");
        $genre = $this->retrieveInput("genre");
        $cast = $this->retrieveInput("cast");
        $description = $this->retrieveInput("description");
        $releaseYear = $this->retrieveInput("releaseYear", FILTER_SANITIZE_NUMBER_INT);
        $length = $this->retrieveInput("length", FILTER_SANITIZE_NUMBER_INT);
        $language = $this->retrieveInput("language");
        $ranking = $this->retrieveInput("ranking", FILTER_SANITIZE_NUMBER_FLOAT);
        $company = $this->retrieveInput("company");
        $director = $this->retrieveInput("director");
        $ageLimit = $this->retrieveInput("ageLimit", FILTER_SANITIZE_NUMBER_INT);

        $company = $this->companyRepository->saveCompany($company);
        $genres = $this->movieRepository->saveGenres(array_map('trim', explode(',', $genre)));
        $actors = $this->movieRepository->saveCastMembers(array_map('trim', explode(',', $cast)));
        $director = $this->movieRepository->saveCastMembers([trim($director)])[0];

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
        $this->handleUpload($movie->getMovieID(), 'movies', 'poster', 500, 750);
    }

    public function saveShowing(): void {
        $id = $this->retrieveInput("id", FILTER_SANITIZE_NUMBER_INT);
        $movieID = $this->retrieveInput("movie", FILTER_SANITIZE_NUMBER_INT);
        $date = $this->retrieveInput("date");
        $startTime = $this->retrieveInput("startTime");
        $type = $this->retrieveInput("type");
        $price = $this->retrieveInput("price", FILTER_SANITIZE_NUMBER_FLOAT);
        $hallID = $this->retrieveInput("hall", FILTER_SANITIZE_NUMBER_INT);

        $showing = new Showing();
        $showing->setShowingID((int)$id);
        $showing->setMovieID((int)$movieID);
        $showing->setDate(new DateTime($date));
        $showing->setStartTime($startTime);
        $showing->setType($type);
        $showing->setPrice((float)$price);
        $showing->setHall(($this->hallRepository->getHallById((int)$hallID)));

        $this->showingRepository->saveShowing($showing);
    }

    public function saveNews(): void {
        $id = $this->retrieveInput("id", FILTER_SANITIZE_NUMBER_INT);
        $title = $this->retrieveInput("title");
        $description = $this->retrieveInput("description");
        $releaseDate = $this->retrieveInput("releaseDate");

        $news = new News();
        $news->setNewsID((int)$id);
        $news->setTitle($title);
        $news->setDescription($description);
        $news->setReleaseDate(new DateTime($releaseDate));

        $this->newsRepository->saveNews($news);
        $this->handleUpload($news->getNewsID(), 'news', 'image', 750, 500);
    }

    public function saveAbout(): void {
      $this->aboutRepository->saveAboutInfo($_POST);
    }

    public function delete(): void {
        $type = $this->retrieveInput("type");
        $id = $this->retrieveInput("id", FILTER_SANITIZE_NUMBER_INT);

        if($type === 'movie') {
            $this->movieRepository->deleteMovie($id);
        }
        else if($type === 'showing') {
            $this->showingRepository->deleteShowing($id);
        }
        else if($type === 'news') {
            $this->newsRepository->deleteNews($id);
        }
    }

}