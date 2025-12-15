<?php
require_once __DIR__ . "/UserRepository.php";
abstract class BaseRepository {

    private array $data = [];

    public function __construct() {
      $this->data = parse_ini_file(__DIR__ . "/../.env");
    }

    protected function getEnvVariable(string $key): ?string {
      return $this->data[$key] ?? null;
    }

    protected function connectDatabase() {
        $db_name = $this->getEnvVariable("DB_NAME");
        $db_host = $this->getEnvVariable("DB_HOST");
        $db_charset = "charset=utf8";
        $dsn = "$db_name; $db_host; $db_charset";
        $dbUser = $this->getEnvVariable("DB_USER");
        $dbPass = $this->getEnvVariable("DB_PASS");

        try{
            return new PDO($dsn, $dbUser, $dbPass);}
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}