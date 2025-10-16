<?php
abstract class BaseRepository {
    protected function connectDatabase() {
        $db_name = "mysql:dbname=RetroBioDB";
        $db_host = "host=localhost";
        $db_charset = "charset=utf8";
        define("DSN", "$db_name; $db_host; $db_charset");
        define("DB_USER", "IdaB");
        define("DB_PASS", "123456");

        try{
            return new PDO(DSN, DB_USER, DB_PASS);}
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}