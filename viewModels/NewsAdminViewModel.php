<?php
require_once __DIR__ . "/BasicViewModel.php";

class NewsAdminViewModel extends BasicViewModel {

    // @var News[]
    private array $news = [];

    /**
     * @return News[]
     */
    public function getNews(): array {
        return $this->news;
    }

    /**
     * @param News[] $news
     */
    public function setNews(array $news): void {
        $this->news = $news;
    }

}