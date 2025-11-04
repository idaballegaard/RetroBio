<?php
require_once __DIR__ . "/UserRepository.php";
abstract class BaseRepository {
    protected function connectDatabase() {
        $db_name = "mysql:dbname=RetroBioDBNEW";
        $db_host = "host=localhost";
        $db_charset = "charset=utf8";
        $dsn = "$db_name; $db_host; $db_charset";
        $dbUser = "IdaB";
        $dbPass = "123456";

        try{
            return new PDO($dsn, $dbUser, $dbPass);}
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}