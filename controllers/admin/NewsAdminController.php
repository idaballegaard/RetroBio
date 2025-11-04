<?php
require_once __DIR__ . "/BaseAdminController.php";
require_once __DIR__ . "/../../viewModels/NewsAdminViewModel.php";
require_once __DIR__ . "/../../repositories/NewsRepository.php";

class NewsAdminController extends BaseAdminController {

    public function newsList() {
        $viewModel = new NewsAdminViewModel(__DIR__ . "/../../views/admin/news.php");

        $newsRepository = new NewsRepository();
        $news = $newsRepository->getAllNews();
        $viewModel->setNews($news);

        return $viewModel;
    }

}